<?php

namespace App\Http\Controllers\BarangKeluar;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Log\LogStokModel;
use App\Models\Barang\BarangModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\TelegramNotification;
use App\Models\Pelanggan\PelangganModel;
use App\Models\StokBarang\StokBarangModel;
use App\Traits\validate\outboundValidation;
use App\Models\BarangKeluar\BarangKeluarModel;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use outboundValidation;
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $query = $request->get('keyword', '');
        $sortOrder = $request->get('sort_order', 'desc');

        $barang_keluar = BarangKeluarModel::join("tb_barang", "tb_barang_keluar.id_barang", "=", "tb_barang.id_barang")
            ->leftJoin("tb_pelanggan", "tb_barang_keluar.id_pelanggan", "=", "tb_pelanggan.id_pelanggan")
            ->select("tb_barang_keluar.*", "tb_barang.nama_barang", "tb_pelanggan.nama")
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('tb_barang.nama_barang', 'like', '%' . $query . '%')
                        ->orWhere('tb_pelanggan.nama', 'like', '%' . $query . '%')
                        ->orWhere('kode_barang_keluar', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('tb_barang.nama_barang', $sortOrder)
            ->paginate($limit)
            ->appends(['keyword' => $query, 'limit' => $limit, 'sort_order' => $sortOrder]);
        if ($request->ajax()) {
            return response()->json([
                'table' => view('BarangKeluar.partials.table', compact('barang_keluar'))->render(),
                'pagination' => view('BarangKeluar.partials.pagination', compact('barang_keluar'))->render(),
                'info' => [
                    'firstItem' => $barang_keluar->firstItem(),
                    'lastItem' => $barang_keluar->lastItem(),
                    'total' => $barang_keluar->total(),
                ],
            ]);
        }
        return view('BarangKeluar.index', compact('barang_keluar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barang = BarangModel::select('id_barang', 'nama_barang')->get();
        $stok = StokBarangModel::select('id_stok', 'id_barang', 'jumlah_barang', 'lokasi')->get();
        $pelanggan = PelangganModel::select('id_pelanggan', 'nama')->get();
        return view('BarangKeluar.Form.forms', compact('barang', 'pelanggan', 'stok'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validationText($request->all());
        $barang_keluar = new BarangKeluarModel();
        $barang_keluar->id_barang = $request->input('id_barang');
        $barang_keluar->id_stok = $request->input('id_stok');
        $barang_keluar->id_pelanggan = $request->input('pelanggan');
        $barang_keluar->tanggal = $request->input('tanggal');
        $barang_keluar->jumlah = (int) $request->input('jumlah');
        $barang_keluar->tujuan = $request->input('tujuan');
        $barang_keluar->satuan = $request->input('satuan');
        $barang_keluar->petugas = $request->input('petugas');
        $barang_keluar->lokasi = $request->input('lokasi');
        $barang_keluar->keterangan = $request->input('keterangan');
        $barang_keluar->save();

        // TelegramNotification::sendOrFail("➕ *Penambahan Data Barang Keluar*\n" .
        //     "Tanggal: *" . Carbon::parse($barang_keluar->tanggal)->format('d-m-Y') . "*\n" .
        //     "Nama Barang: *{$barang_keluar->barang?->nama_barang}*\n" .
        //     "Nama Pelanggan: *{$barang_keluar->pelanggan?->nama}*\n" .
        //     "Tujuan Keluar: *{$barang_keluar->tujuan}*\n" .
        //     "Satuan: *{$barang_keluar->satuan}*\n" .
        //     "Petugas: *{$barang_keluar->petugas}*\n" .
        //     "Jumlah Barang: *{$barang_keluar->jumlah}*\n" .
        //     "Dikeluarkan dari: *{$barang_keluar->lokasi}*\n" .
        //     "Status: *" . 'Dibuat' . "*\n" .
        //     "Created at: *" . auth()->user()->name . "*");

        $currentStok = StokBarangModel::where('id_barang', $request->input('id_barang'))
            ->where('lokasi', $request->input('lokasi'))
            ->orderByDesc('created_at')
            ->first();

        if ($currentStok) {
            $currentStok->jumlah_barang -= $request->input('jumlah');
            $currentStok->save();

            LogStokModel::create([
                'id_barang' => $barang_keluar->id_barang,
                'tanggal' => $barang_keluar->tanggal,
                'tipe' => 'barang_keluar',
                'jumlah' => $barang_keluar->jumlah,
                'lokasi' => $barang_keluar->lokasi,
                'keterangan' => $barang_keluar->keterangan,
                'dibuat_oleh' => Auth::user()->name,
            ]);
        }
        return redirect()->route('outbound.list')->with('success', 'Barang ' . ucwords($barang_keluar->barang->nama_barang) . ' telah diKeluarkan dari stok');
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangKeluarModel $barangKeluarModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = BarangModel::select('id_barang', 'nama_barang')->get();
        $stok = StokBarangModel::select('id_stok', 'id_barang', 'jumlah_barang', 'lokasi')->get();
        $pelanggan = PelangganModel::select('id_pelanggan', 'nama')->get();
        $barang_keluar = BarangKeluarModel::findOrFail($id);
        return view('BarangKeluar.Form.forms', compact('barang', 'pelanggan', 'stok', 'barang_keluar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validationText($request->all(), true);
        $barang_keluar = BarangKeluarModel::findOrFail($id);
        $barang_keluar->id_barang = $request->input('id_barang');
        $barang_keluar->id_stok = $request->input('id_stok');
        $barang_keluar->id_pelanggan = $request->input('pelanggan');
        $barang_keluar->tanggal = $request->input('tanggal');
        $barang_keluar->jumlah = (int) $request->input('jumlah');
        $barang_keluar->tujuan = $request->input('tujuan');
        $barang_keluar->satuan = $request->input('satuan');
        $barang_keluar->petugas = $request->input('petugas');
        $barang_keluar->lokasi = $request->input('lokasi');
        $barang_keluar->keterangan = $request->input('keterangan');
        $barang_keluar->update();

        // TelegramNotification::sendOrFail("📝 *Perubahan Data Barang Keluar*\n" .
        //     "Tanggal: *" . Carbon::parse($barang_keluar->tanggal)->format('d-m-Y') . "*\n" .
        //     "Nama Barang: *{$barang_keluar->barang?->nama_barang}*\n" .
        //     "Nama Pelanggan: *{$barang_keluar->pelanggan?->nama}*\n" .
        //     "Tujuan Keluar: *{$barang_keluar->tujuan}*\n" .
        //     "Satuan: *{$barang_keluar->satuan}*\n" .
        //     "Petugas: *{$barang_keluar->petugas}*\n" .
        //     "Jumlah Barang: *{$barang_keluar->jumlah}*\n" .
        //     "Dikeluarkan dari: *{$barang_keluar->lokasi}*\n" .
        //     "Status: *" . 'Diubah' . "*\n" .
        //     "Updated at: *" . auth()->user()->name . "*");

        // ambil nilai terkakhir dari log stok model
        $logStok = LogStokModel::where('id_barang', $request->input('id_barang'))
            ->where('lokasi', $request->input('lokasi'))
            ->where('tipe', 'barang_keluar')
            ->orderByDesc('created_at')
            ->first();

        $currentStok = StokBarangModel::where('id_barang', $request->input('id_barang'))
            ->where('lokasi', $request->input('lokasi'))
            ->orderByDesc('created_at')
            ->first();

        $selisih =  ($currentStok->jumlah_barang + $logStok->jumlah) - $request->input('jumlah');
        if ($currentStok) {
            $currentStok->jumlah_barang = $selisih;
            $currentStok->save();

            LogStokModel::create([
                'id_barang' => $barang_keluar->id_barang,
                'tanggal' => $barang_keluar->tanggal,
                'tipe' => 'barang_keluar',
                'jumlah' => $request->input('jumlah'),
                'lokasi' => $barang_keluar->lokasi,
                'keterangan' => $request->input('keterangan'),
                'dibuat_oleh' => Auth::user()->name,
            ]);
        }
        return redirect()->route('outbound.list')->with('success', 'Perubahan data barang ' . ucwords($barang_keluar->barang->nama_barang) . ' keluar berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang_keluar = BarangKeluarModel::findOrFail($id);
        $barang_keluar->delete();

        // TelegramNotification::sendOrFail("🗑️ *Penghapusan Barang Keluar*\n" .
        //     "Tanggal: *" . Carbon::parse($barang_keluar->tanggal)->format('d-m-Y') . "*\n" .
        //     "Nama Barang: *{$barang_keluar->barang?->nama_barang}*\n" .
        //     "Nama Pelanggan: *{$barang_keluar->pelanggan?->nama}*\n" .
        //     "Tujuan Keluar: *{$barang_keluar->tujuan}*\n" .
        //     "Satuan: *{$barang_keluar->satuan}*\n" .
        //     "Petugas: *{$barang_keluar->petugas}*\n" .
        //     "Jumlah Barang: *{$barang_keluar->jumlah}*\n" .
        //     "Dikeluarkan dari: *{$barang_keluar->lokasi}*\n" .
        //     "Status: *" . 'Dihapus' . "*\n" .
        //     "Deleted at: *" . auth()->user()->name . "*");

        // hapus log
        LogStokModel::where('id_barang', $barang_keluar->id_barang)
            ->where('lokasi', $barang_keluar->lokasi)
            ->where('tipe', 'barang_keluar')
            ->orderByDesc('created_at')
            ->delete();

        $currentStok = StokBarangModel::where('id_barang',  $barang_keluar->id_barang)
            ->where('lokasi',  $barang_keluar->lokasi)
            ->orderByDesc('created_at')
            ->first();
        $selisih =  $currentStok->jumlah_barang +  $barang_keluar->jumlah;
        if ($currentStok) {
            $currentStok->jumlah_barang = $selisih;
            $currentStok->save();
        }

        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
