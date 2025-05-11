<?php

namespace App\Http\Controllers\ReturBarang;

use App\Http\Controllers\Controller;
use App\Models\Barang\BarangModel;
use App\Models\Pelanggan\PelangganModel;
use App\Models\ReturBarang\ReturBarangModel;
use App\Models\Supplier\SupplierModel;
use Illuminate\Http\Request;

class ReturBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
                        ->orWhere('tb_pelanggan.nama', 'like', '%' . $query . '%');
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
        $barang_kembali->kode_retur = $request->input('kode_retur');
        $barang_kembali->tanggal = $request->input('tanggal');
        $barang_kembali->jumlah = $request->input('jumlah');
        $barang_kembali->tipe_retur = $request->input('tipe_retur');
        $barang_kembali->status_pergantian = $request->input('status');
        $barang_kembali->alasan = $request->input('alasan');
        $barang_kembali->image = implode(',', $filesName);
        $barang_kembali->path = implode(',', $path);
        $barang_kembali->save();
        return redirect()->route('retur.list')->with('success', 'Barang Kembali berhasil dibuat');
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
        $barang_kembali->kode_retur = $request->input('kode_retur');
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
        return redirect()->route('retur.list')->with('success', 'Barang Kembali berhasil dibuat');
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
        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
