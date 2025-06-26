<?php

namespace App\Http\Controllers\ReturBarang;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Barang\BarangModel;
use App\Http\Controllers\Controller;
use App\Helpers\TelegramNotification;
use App\Models\Supplier\SupplierModel;
use App\Models\Pelanggan\PelangganModel;
use App\Traits\validate\ReturValidation;
use App\Models\ReturBarang\ReturBarangModel;

class ReturBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ReturValidation;
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $query = $request->get('keyword', '');
        $sortOrder = $request->get('sort_order', 'desc');

        $barang_kembali = ReturBarangModel::join("tb_barang", "tb_retur_barang.id_barang", "=", "tb_barang.id_barang")
            ->leftJoin("tb_pelanggan",  "tb_retur_barang.id_pelanggan", "=", "tb_pelanggan.id_pelanggan")
            ->select("tb_retur_barang.*", "tb_barang.nama_barang", "tb_pelanggan.nama")
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('tb_barang.nama_barang', 'like', '%' . $query . '%')
                        ->orWhere('tb_pelanggan.nama', 'like', '%' . $query . '%')
                        ->orWhere('kode_retur', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('tb_barang.nama_barang', $sortOrder)
            ->paginate($limit)
            ->appends(['keyword' => $query, 'limit' => $limit, 'sort_order' => $sortOrder]);
        if ($request->ajax()) {
            return response()->json([
                'table' => view('BarangKembali.partials.table', compact('barang_kembali'))->render(),
                'pagination' => view('BarangKembali.partials.pagination', compact('barang_kembali'))->render(),
                'info' => [
                    'firstItem' => $barang_kembali->firstItem(),
                    'lastItem' => $barang_kembali->lastItem(),
                    'total' => $barang_kembali->total(),
                ],
            ]);
        }
        return view('BarangKembali.index', compact('barang_kembali'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barang = BarangModel::select('id_barang', 'nama_barang')->get();
        $pelanggan = PelangganModel::select('id_pelanggan', 'nama')->get();
        $supplier = SupplierModel::select('id_supplier', 'nama')->get();
        return view('BarangKembali.Form.forms', compact('barang', 'pelanggan', 'supplier'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validationText($request->all());
        $filesName = [];
        $path = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                if ($file && $file->isValid()) {
                    $fileNameOrigin = uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/uploads'), $fileNameOrigin);

                    $filesName[] = $fileNameOrigin;
                    $path[] = 'assets/uploads/' . $fileNameOrigin;
                }
            }
        }
        $barang_kembali = new ReturBarangModel();
        $barang_kembali->id_barang = $request->input('id_barang');
        $barang_kembali->id_pelanggan = $request->input('id_pelanggan');
        $barang_kembali->id_supplier = $request->input('id_supplier');
        $barang_kembali->tanggal = $request->input('tanggal');
        $barang_kembali->jumlah = $request->input('jumlah');
        $barang_kembali->tipe_retur = $request->input('tipe_retur');
        $barang_kembali->status_pergantian = $request->input('status');
        $barang_kembali->alasan = $request->input('alasan');
        $barang_kembali->image = implode(',', $filesName);
        $barang_kembali->path = implode(',', $path);
        $barang_kembali->save();

        TelegramNotification::sendOrFail("➕ *Barang Kembali/Retur*\n" .
            "Tanggal: *" . Carbon::parse($barang_kembali->tanggal)->format('d-m-Y') . "*\n" .
            "Nama Barang: *{$barang_kembali->barang->nama_barang}*\n" .
            "Nama Pelanggan: *{$barang_kembali->pelanggan->nama}*\n" .
            "Nama Supplier: *{$barang_kembali->supplier?->nama}*\n" .
            "Jumlah Barang: *{$barang_kembali->jumlah}*\n" .
            "Jenis Retur: *{$barang_kembali->tipe_retur}*\n" .
            "Status Pergantian: *{$barang_kembali->status_pergantian}*\n" .
            "Alasan Retur: *{$barang_kembali->alasan}*\n" .
            "Status: *" . 'Dibuat' . "*\n" .
            "Created at: *" . auth()->user()->name . "*");
        return redirect()->route('retur.list')->with('success', 'Barang Kembali ' . ucwords($barang_kembali->barang->nama_barang) . ' berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $barang = BarangModel::select('id_barang', 'nama_barang')->get();
        $pelanggan = PelangganModel::select('id_pelanggan', 'nama')->get();
        $supplier = SupplierModel::select('id_supplier', 'nama')->get();

        $barang_kembali = ReturBarangModel::findOrFail($id);
        return view('BarangKembali.Form.forms', compact('barang_kembali', 'barang', 'pelanggan', 'supplier'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validationText($request->all());
        // File lama dihapus sebelum file baru disimpan.
        // File baru tidak tercampur dengan variabel path lama.
        $barang_kembali = ReturBarangModel::findOrFail($id);
        $filesNameNew = [];
        $pathNew = [];
        if ($request->hasFile('gambar')) {
            // Jika ada file baru diupload
            if ($barang_kembali->path) {
                $pathOld = explode(',', $barang_kembali->path);
                // Hapus file lama jika ada
                foreach ($pathOld as $p) {
                    if (file_exists(public_path($p))) {
                        unlink(public_path($p));
                    }
                }
            }
            // Upload file baru
            foreach ($request->file('gambar') as $file) {
                if ($file && $file->isValid()) {
                    $fileNameOrigin = uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/uploads'), $fileNameOrigin);

                    $filesNameNew[] = $fileNameOrigin;
                    $pathNew[] = 'assets/uploads/' . $fileNameOrigin;
                    // cek path pada tabel jika ada hapus value dan hapus file pada storage

                }
            }
        }

        $barang_kembali->id_barang = $request->input('id_barang');
        $barang_kembali->id_pelanggan = $request->input('id_pelanggan');
        $barang_kembali->id_supplier = $request->input('id_supplier');
        $barang_kembali->tanggal = $request->input('tanggal');
        $barang_kembali->jumlah = $request->input('jumlah');
        $barang_kembali->tipe_retur = $request->input('tipe_retur');
        $barang_kembali->status_pergantian = $request->input('status');
        $barang_kembali->alasan = $request->input('alasan');
        // Jika tidak ada file baru, gunakan file lama
        // Hanya update image dan path jika ada file baru
        if (!empty($filesNameNew)) {
            $barang_kembali->image = implode(',',  $filesNameNew);
            $barang_kembali->path = implode(',', $pathNew);
        }
        $barang_kembali->update();

        TelegramNotification::sendOrFail("📝 *Perubahan Barang Kembali/Retur*\n" .
            "Tanggal: *" . Carbon::parse($barang_kembali->tanggal)->format('d-m-Y') . "*\n" .
            "Nama Barang: *{$barang_kembali->barang->nama_barang}*\n" .
            "Nama Pelanggan: *{$barang_kembali->pelanggan->nama}*\n" .
            "Nama Supplier: *{$barang_kembali->supplier?->nama}*\n" .
            "Jumlah Barang: *{$barang_kembali->jumlah}*\n" .
            "Jenis Retur: *{$barang_kembali->tipe_retur}*\n" .
            "Status Pergantian: *{$barang_kembali->status_pergantian}*\n" .
            "Alasan Retur: *{$barang_kembali->alasan}*\n" .
            "Status: *" . 'Diubah' . "*\n" .
            "Updated at: *" . auth()->user()->name . "*");
        return redirect()->route('retur.list')->with('success', 'Perubahan data barang Kembali ' . ucwords($barang_kembali->barang->nama_barang) . ' berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang_kembali = ReturBarangModel::findOrFail($id);
        if ($barang_kembali->path) {
            $pathOld = explode(',', $barang_kembali->path);
            // Hapus file lama jika ada
            foreach ($pathOld as $p) {
                if (file_exists(public_path($p))) {
                    unlink(public_path($p));
                }
            }
        }
        $barang_kembali->delete();
        TelegramNotification::sendOrFail("🗑️ *Penghapusan Barang Kembali/Retur*\n" .
            "Tanggal: *" . Carbon::parse($barang_kembali->tanggal)->format('d-m-Y') . "*\n" .
            "Nama Barang: *{$barang_kembali->barang->nama_barang}*\n" .
            "Nama Pelanggan: *{$barang_kembali->pelanggan->nama}*\n" .
            "Nama Supplier: *{$barang_kembali->supplier?->nama}*\n" .
            "Jumlah Barang: *{$barang_kembali->jumlah}*\n" .
            "Jenis Retur: *{$barang_kembali->tipe_retur}*\n" .
            "Status Pergantian: *{$barang_kembali->status_pergantian}*\n" .
            "Alasan Retur: *{$barang_kembali->alasan}*\n" .
            "Status: *" . 'Dihapus' . "*\n" .
            "Deleted at: *" . auth()->user()->name . "*");
        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
