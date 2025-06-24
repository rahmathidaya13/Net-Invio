<?php

namespace App\Http\Controllers\BarangMasuk;

use Illuminate\Http\Request;
use App\Models\Log\LogStokModel;
use App\Models\Barang\BarangModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier\SupplierModel;
use App\Models\StokBarang\StokBarangModel;
use App\Traits\validate\ReceivingValidate;
use App\Models\BarangMasuk\BarangMasukModel;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ReceivingValidate;
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $query = $request->get('keyword', '');
        $sortOrder = $request->get('sort_order', 'desc');

        $barang_masuk = BarangMasukModel::join("tb_barang", "tb_barang_masuk.id_barang", "=", "tb_barang.id_barang")
            ->leftJoin("tb_supplier", "tb_barang_masuk.id_supplier", "=", "tb_supplier.id_supplier")
            ->select("tb_barang_masuk.*", "tb_barang.nama_barang", "tb_supplier.nama as nama_supplier")
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('tb_barang.nama_barang', 'like', '%' . $query . '%')
                        ->orWhere('tb_supplier.nama', 'like', '%' . $query . '%')
                        ->orWhere('kode_brg_masuk', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('tb_barang.nama_barang', $sortOrder)
            ->paginate($limit)
            ->appends(['keyword' => $query, 'limit' => $limit, 'sort_order' => $sortOrder]);
        if ($request->ajax()) {
            return response()->json([
                'table' => view('BarangMasuk.partials.table', compact('barang_masuk'))->render(),
                'pagination' => view('BarangMasuk.partials.pagination', compact('barang_masuk'))->render(),
                'info' => [
                    'firstItem' => $barang_masuk->firstItem(),
                    'lastItem' => $barang_masuk->lastItem(),
                    'total' => $barang_masuk->total(),
                ],
            ]);
        }
        return view('BarangMasuk.index', compact('barang_masuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barang = BarangModel::select('id_barang', 'nama_barang')->get();
        $supplier = SupplierModel::select('id_supplier', 'nama')->get();
        return view('BarangMasuk.Form.forms', compact('barang', 'supplier'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->merge([
            'harga' => str_replace(['.', ','], ['', ''], $request->input('harga'))
        ]);
        $this->validateReceiving($request->all());
        $barangMasuk = new BarangMasukModel();
        $barangMasuk->id_barang = $request->input('id_barang');
        $barangMasuk->id_supplier = $request->input('supplier');
        $barangMasuk->tanggal = $request->input('tanggal');
        $barangMasuk->sumber = $request->input('sumber');
        $barangMasuk->pembeli = $request->input('pembeli');
        $barangMasuk->nota = $request->input('nota');
        $barangMasuk->jumlah = $request->input('jumlah');
        $barangMasuk->lokasi = $request->input('lokasi_barang');
        $barangMasuk->harga = floatval($request['harga']);
        $barangMasuk->keterangan = $request->input('keterangan');
        $barangMasuk->save();

        $currentStok = StokBarangModel::where('id_barang', $request->input('id_barang'))
            ->where('lokasi', $request->input('lokasi_barang'))
            ->whereDate('tanggal', $request->input('tanggal'))
            ->orderByDesc('created_at')
            ->first();

        if ($currentStok) {
            $currentStok->jumlah_barang += $request->input('jumlah');
            $currentStok->save();

            LogStokModel::create([
                'id_barang' => $barangMasuk->id_barang,
                'tanggal' => $barangMasuk->tanggal,
                'tipe' => 'barang_masuk',
                'jumlah' => $request->input('jumlah'),
                'lokasi' => $barangMasuk->lokasi,
                'keterangan' => $request->input('keterangan'),
                'dibuat_oleh' => Auth::user()->name,
            ]);
        } else {
            $oldStok = StokBarangModel::where('id_barang', $request->input('id_barang'))
                ->where('lokasi', $request->input('lokasi_barang'))
                ->whereDate('tanggal', $request->input('tanggal'))
                ->orderByDesc('created_at')
                ->first();
            $newStok = new StokBarangModel();
            $newStok->id_barang = $request->input('id_barang');
            $newStok->tanggal = $request->input('tanggal');
            $newStok->jumlah_barang = (int) ($oldStok?->jumlah_barang ?? 0) + (int) $request->input('jumlah');
            $newStok->lokasi = $request->input('lokasi_barang');
            $newStok->asal_barang = 'barang_masuk';
            $newStok->keterangan = $request->input('keterangan');
            $newStok->save();

            LogStokModel::create([
                'id_barang' => $newStok->id_barang,
                'tanggal' => $newStok->tanggal,
                'tipe' => 'barang_masuk',
                'jumlah' => $request->input('jumlah'),
                'lokasi' => $newStok->lokasi,
                'keterangan' => $request->input('keterangan'),
                'dibuat_oleh' => Auth::user()->name,
            ]);
        }

        return redirect()->route('receiving.list')->with('success', 'Penambahan ' . ucwords($barangMasuk->barang->nama_barang) . ' barang Masuk Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barang_masuk = BarangMasukModel::findOrFail($id);
        return response()->json([
            'result' => $barang_masuk,
        ], 200);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = BarangModel::select('id_barang', 'nama_barang')->get();
        $supplier = SupplierModel::select('id_supplier', 'nama')->get();
        $barang_masuk = BarangMasukModel::findOrFail($id);
        return view('BarangMasuk.Form.forms', compact('barang_masuk', 'barang', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->merge([
            'harga' => str_replace(['.', ','], ['', ''], $request->input('harga'))
        ]);
        $this->validateReceiving($request->all(), true);
        $barang_masuk = BarangMasukModel::findOrFail($id);
        $barang_masuk->id_barang = $request->input('id_barang');
        $barang_masuk->id_supplier = $request->input('supplier');
        $barang_masuk->tanggal = $request->input('tanggal');
        $barang_masuk->sumber = $request->input('sumber');
        $barang_masuk->pembeli = $request->input('pembeli');
        $barang_masuk->nota = $request->input('nota');
        $barang_masuk->jumlah = $request->input('jumlah');
        $barang_masuk->lokasi = $request->input('lokasi_barang');
        $barang_masuk->harga = floatval($request['harga']);
        $barang_masuk->keterangan = $request->input('keterangan');
        $barang_masuk->update();

        // ambil nilai terkakhir dari log stok model
        $logStok = LogStokModel::where('id_barang', $request->input('id_barang'))
            ->where('lokasi', $request->input('lokasi_barang'))
            ->where('tipe', 'barang_masuk')
            ->whereDate('tanggal', $request->input('tanggal'))
            ->orderByDesc('created_at')
            ->first();

        $currentStok = StokBarangModel::where('id_barang', $request->input('id_barang'))
            ->where('lokasi', $request->input('lokasi_barang'))
            ->whereDate('tanggal', $request->input('tanggal'))
            ->orderByDesc('created_at')
            ->first();
        $selisih =  ($currentStok->jumlah_barang - $logStok->jumlah) + $request->input('jumlah');
        if ($currentStok) {
            $currentStok->jumlah_barang = $selisih;
            $currentStok->save();

            LogStokModel::create([
                'id_barang' => $barang_masuk->id_barang,
                'tanggal' => $barang_masuk->tanggal,
                'tipe' => 'barang_masuk',
                'jumlah' => $request->input('jumlah'),
                'lokasi' => $barang_masuk->lokasi,
                'keterangan' => $request->input('keterangan'),
                'dibuat_oleh' => Auth::user()->name,
            ]);
        } else {
            $oldStok = StokBarangModel::where('id_barang', $request->input('id_barang'))
                ->where('lokasi', $request->input('lokasi_barang'))
                ->whereDate('tanggal', $request->input('tanggal'))
                ->orderByDesc('tanggal')
                ->orderBy('tanggal', 'desc')
                ->first();
            $newStok = new StokBarangModel();
            $newStok->id_barang = $request->input('id_barang');
            $newStok->tanggal = $request->input('tanggal');
            $newStok->jumlah_barang = (int) ($oldStok?->jumlah_barang ?? 0) + (int) $request->input('jumlah');
            $newStok->lokasi = $request->input('lokasi_barang');
            $newStok->asal_barang = 'barang_masuk';
            $newStok->keterangan = $request->input('keterangan');
            $newStok->save();

            LogStokModel::create([
                'id_barang' => $newStok->id_barang,
                'tanggal' => $newStok->tanggal,
                'tipe' => 'barang_masuk',
                'jumlah' => $request->input('jumlah'),
                'lokasi' => $newStok->lokasi,
                'keterangan' => $request->input('keterangan'),
                'dibuat_oleh' => Auth::user()->name,
            ]);
        }

        return redirect()->route('receiving.list')->with('success', 'Data Barang ' . ucwords($barang_masuk->barang->nama_barang) . ' berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang_masuk = BarangMasukModel::findOrFail($id);
        $barang_masuk->delete();
        // hapus log
        LogStokModel::where('id_barang', $barang_masuk->id_barang)
            ->where('lokasi', $barang_masuk->lokasi)
            ->where('tipe', 'barang_masuk')
            ->whereDate('tanggal', $barang_masuk->tanggal)
            ->orderByDesc('created_at')
            ->delete();

        $currentStok = StokBarangModel::where('id_barang',  $barang_masuk->id_barang)
            ->where('lokasi',  $barang_masuk->lokasi)
            ->whereDate('tanggal', $barang_masuk->tanggal)
            ->orderByDesc('created_at')
            ->first();
        $selisih =  $currentStok->jumlah_barang -  $barang_masuk->jumlah;
        if ($currentStok) {
            $currentStok->jumlah_barang = $selisih;
            $currentStok->save();
        }

        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
