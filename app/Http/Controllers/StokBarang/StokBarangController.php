<?php

namespace App\Http\Controllers\StokBarang;

use App\Http\Controllers\Controller;
use App\Models\Barang\BarangModel;
use App\Models\StokBarang\StokBarangModel;
use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $query = $request->get('keyword', '');
        $sortOrder = $request->get('sort_order', 'desc');

        $barang = BarangModel::select('id_barang', 'nama_barang')->get();
        $stok = StokBarangModel::join("tb_barang", "tb_stok.id_barang", "tb_barang.id_barang")
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('nama_barang', 'like', '%' . $query . '%');
                });
            })->latest()
            ->orderBy('nama', $sortOrder)
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
        return view('StokBarang.index', compact('stok', 'barang'));
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
        //
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
    public function edit(StokBarangModel $stokBarangModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StokBarangModel $stokBarangModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StokBarangModel $stokBarangModel)
    {
        //
    }
}
