<?php

namespace App\Http\Controllers\BarangKeluar;

use Illuminate\Http\Request;
use App\Models\Barang\BarangModel;
use App\Http\Controllers\Controller;
use App\Models\BarangKeluar\BarangKeluarModel;
use App\Models\Pelanggan\PelangganModel;
use App\Models\StokBarang\StokBarangModel;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
                        ->orWhere('tb_pelanggan.nama', 'like', '%' . $query . '%');
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
        $stok = StokBarangModel::select('id_barang', 'jumlah_barang', 'lokasi')->get();
        $pelanggan = PelangganModel::select('id_pelanggan', 'nama')->get();
        return view('BarangKeluar.Form.forms', compact('barang', 'pelanggan', 'stok'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
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
    public function edit(BarangKeluarModel $barangKeluarModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangKeluarModel $barangKeluarModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangKeluarModel $barangKeluarModel)
    {
        //
    }
}
