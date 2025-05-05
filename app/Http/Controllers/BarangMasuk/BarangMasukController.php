<?php

namespace App\Http\Controllers\BarangMasuk;

use App\Http\Controllers\Controller;
use App\Models\Barang\BarangModel;
use App\Models\BarangMasuk\BarangMasukModel;
use App\Models\Supplier\SupplierModel;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
                        ->orWhere('tb_supplier.nama', 'like', '%' . $query . '%');
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
        $convert = $request->merge([
            'harga_brg' => str_replace([".", ","], "", $request->input('harga'))
        ]);
        $barangMasuk = new BarangMasukModel();
        $barangMasuk->id_barang = $request->input('nama_barang');
        $barangMasuk->id_supplier = $request->input('supplier');
        $barangMasuk->tanggal = $request->input('tanggal');
        $barangMasuk->sumber = $request->input('sumber');
        $barangMasuk->pembeli = $request->input('pembeli');
        $barangMasuk->nota = $request->input('nota');
        $barangMasuk->jumlah = $request->input('jumlah');
        $barangMasuk->harga = $convert['harga_brg'];
        $barangMasuk->keterangan = $request->input('keterangan');
        $barangMasuk->save();
        return redirect()->route('receiving.list')->with('success', 'Barang Masuk Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangMasukModel $barangMasukModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangMasukModel $barangMasukModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangMasukModel $barangMasukModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangMasukModel $barangMasukModel)
    {
        //
    }
}
