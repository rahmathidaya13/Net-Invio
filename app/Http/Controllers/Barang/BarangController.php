<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use App\Models\Barang\BarangModel;
use App\Traits\Validate\ItemValidation;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ItemValidation;
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $query = $request->get('keyword', '');
        $sortOrder = $request->get('sort_order', 'desc');

        $barang = BarangModel::when($query, function ($q) use ($query) {
            $q->where(function ($subQuery) use ($query) {
                $subQuery->where('kode_barang', 'like', '%' . $query . '%')
                    ->orWhere('nama_barang', 'like', '%' . $query . '%')
                    ->orWhere('serial_number', 'like', '%' . $query . '%')
                    ->orWhere('tipe_model', 'like', '%' . $query . '%');
            });
        })->latest()
            ->orderBy('nama_barang', $sortOrder)
            ->paginate($limit)
            ->appends(['keyword' => $query, 'limit' => $limit, 'sort_order' => $sortOrder]);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('Barang.partials.table', compact('barang'))->render(),
                'pagination' => view('Barang.partials.pagination', compact('barang'))->render(),
                'info' => [
                    'firstItem' => $barang->firstItem(),
                    'lastItem' => $barang->lastItem(),
                    'total' => $barang->total(),
                ],
            ]);
        }
        return view('Barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Barang.Form.forms');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateItem($request->all());
        $barang = new BarangModel();
        $barang->kode_barang = $request->input('kode_barang');
        $barang->serial_number = $request->input('sn', '-');
        $barang->nama_barang = $request->input('nama_barang');
        $barang->jenis = $request->input('jenis_barang');
        $barang->merek = $request->input('merek');
        $barang->tipe_model = $request->input('model', '-');
        $barang->satuan = $request->input('satuan');
        $barang->keterangan = $request->input('keterangan', '-');
        $barang->save();
        return redirect()->route('barang.list')->with('success', 'Data Barang ' . ucwords($barang->nama_barang) . ' Berhasil Ditambahkan');
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
        $barang = BarangModel::findOrFail($id);
        return view('Barang.Form.forms', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barang =  BarangModel::findOrFail($id);
        $barang->kode_barang = $request->input('kode_barang');
        $barang->serial_number = $request->input('sn');
        $barang->nama_barang = $request->input('nama_barang');
        $barang->jenis = $request->input('jenis_barang');
        $barang->merek = $request->input('merek');
        $barang->tipe_model = $request->input('model');
        $barang->satuan = $request->input('satuan');
        $barang->keterangan = $request->input('keterangan');
        $barang->update();
        return redirect()->route('barang.list')->with('success', 'Data Barang ' . ucwords($barang->nama_barang) . ' Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = BarangModel::findOrFail($id);
        $barang->delete();
        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
