<?php

namespace App\Http\Controllers\StokBarang;

use Illuminate\Http\Request;
use App\Models\Log\LogStokModel;
use App\Models\Barang\BarangModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\StokBarang\StokBarangModel;
use App\Traits\Validate\StokValidation;
use PhpParser\Node\Expr\Cast\String_;

class StokBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    use StokValidation;
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $query = $request->get('keyword', '');
        $sortOrder = $request->get('sort_order', 'desc');
        $stok = StokBarangModel::join("tb_barang", "tb_stok.id_barang", "tb_barang.id_barang")
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('tb_barang.nama_barang', 'like', '%' . $query . '%');
                });
            })->latest('tb_stok.created_at')
            ->orderBy('tb_barang.nama_barang', $sortOrder)
            ->paginate($limit)
            ->appends(['keyword' => $query, 'limit' => $limit, 'sort_order' => $sortOrder]);
        if ($request->ajax()) {
            return response()->json([
                'table' => view('StokBarang.partials.table', compact('stok'))->render(),
                'pagination' => view('StokBarang.partials.pagination', compact('stok'))->render(),
                'info' => [
                    'firstItem' => $stok->firstItem(),
                    'lastItem' => $stok->lastItem(),
                    'total' => $stok->total(),
                ],
            ]);
        }
        return view('StokBarang.index', compact('stok'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barang = BarangModel::select('id_barang', 'nama_barang')->get();
        return view('StokBarang.Form.forms', compact('barang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validationText($request->all());
        // cek stok saat ini berdasarkan kondisi saat ini dari form atau request
        $currentStok = StokBarangModel::where('id_barang', $request->input('nama_barang'))
            ->whereDate('tanggal', $request->input('tanggal'))
            ->first();

        if ($currentStok) {
            $currentStok->jumlah_barang += $request->input('jumlah');
            $currentStok->save();

            // catat log jika ada perubahan pada kondisi yang sama
            LogStokModel::create([
                'id_barang' => $request->input('nama_barang'),
                'tanggal' => $request->input('tanggal'),
                'tipe' => 'penyesuaian',
                'jumlah' => $request->input('jumlah'),
                'lokasi' => $request->input('lokasi'),
                'keterangan' => $request->input('keterangan'),
                'dibuat_oleh' => Auth::user()->name,
            ]);
            $stok = $currentStok;
        } else {
            // Ambil stok terakhir sebelum tanggal ini (jika ada)
            $oldStok = StokBarangModel::where('id_barang', $request->input('nama_barang'))
                ->orderByDesc('tanggal')
                ->first();
            $stok = new StokBarangModel();
            $stok->id_barang = $request->input('nama_barang');
            $stok->tanggal = $request->input('tanggal');
            $stok->jumlah_barang = (int) ($oldStok?->jumlah_barang ?? 0) + (int) $request->input('jumlah');
            $stok->lokasi = $request->input('lokasi');
            $stok->save();

            // khusus untuk catat log baru
            LogStokModel::create([
                'id_barang' => $stok->id_barang,
                'tanggal' => $stok->tanggal,
                'tipe' => 'penyesuaian',
                'jumlah' => $request->input('jumlah'),
                'lokasi' => $stok->lokasi,
                'keterangan' => $request->input('keterangan'),
                'dibuat_oleh' => Auth::user()->name,
            ]);
        }
        return redirect()->route('stok.list')->with('success', 'Penambahan Stok  Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(StokBarangModel $stokBarangModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = BarangModel::select('id_barang', 'nama_barang')->get();
        $stok = StokBarangModel::findOrFail($id);
        return view('StokBarang.Form.forms', compact('stok', 'barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validationText($request->all(), $id);

        // Update data stok
        $stok = StokBarangModel::findOrFail($id);

        $jumlahStokLama = $stok->jumlah_barang;
        $jumlahStokBaru = (int) $request->input('jumlah');
        $selisih = $jumlahStokBaru - $jumlahStokLama;

        $stok->id_barang = $request->input('nama_barang');
        $stok->tanggal = $request->input('tanggal');
        $stok->jumlah_barang = $jumlahStokBaru;
        $stok->lokasi = $request->input('lokasi');
        $stok->update();

        // khusus untuk catat log baru
        LogStokModel::create([
            'id_barang' => $stok->id_barang,
            'tanggal' => $stok->tanggal,
            'tipe' => 'penyesuaian',
            'jumlah' => $selisih,
            'lokasi' => $stok->lokasi,
            'keterangan' => $request->input('keterangan'),
            'dibuat_oleh' => Auth::user()->name,
        ]);

        return redirect()->route('stok.list')->with('success', 'Perubahan Stok ' . ucwords($stok->barang->nama_barang) . '  Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $stok = StokBarangModel::findOrFail($id);
        $stok->delete();
        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
