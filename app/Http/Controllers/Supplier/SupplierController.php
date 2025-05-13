<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier\SupplierModel;
use App\Traits\validate\supplierValidation;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use supplierValidation;
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $query = $request->get('keyword', '');
        $sortOrder = $request->get('sort_order', 'desc');

        $supplier = SupplierModel::when($query, function ($q) use ($query) {
            $q->where(function ($subQuery) use ($query) {
                $subQuery->where('nama', 'like', '%' . $query . '%')
                    ->orWhere('kontak', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%');
            });
        })->latest()
            ->orderBy('nama', $sortOrder)
            ->paginate($limit)
            ->appends(['keyword' => $query, 'limit' => $limit, 'sort_order' => $sortOrder]);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('Supplier.partials.table', compact('supplier'))->render(),
                'pagination' => view('Supplier.partials.pagination', compact('supplier'))->render(),
                'info' => [
                    'firstItem' => $supplier->firstItem(),
                    'lastItem' => $supplier->lastItem(),
                    'total' => $supplier->total(),
                ],
            ]);
        }
        return view('Supplier.index', compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Supplier.Form.forms');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validationText($request->all());
        $supplier = new SupplierModel();
        $supplier->nama = $request->input('nama_supplier');
        $supplier->kontak = $request->input('kontak');
        $supplier->email = $request->input('email');
        $supplier->alamat = $request->input('alamat');
        $supplier->save();
        return redirect()->route('supplier.list')->with('success', 'Data Supplier ' . ucwords($supplier->nama) . ' berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SupplierModel $supplierModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supplier = SupplierModel::findOrFail($id);
        return view('Supplier.Form.forms', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validationText($request->all(), $id);
        $supplier = SupplierModel::findOrFail($id);
        $supplier->nama = $request->input('nama_supplier');
        $supplier->kontak = $request->input('kontak');
        $supplier->email = $request->input('email');
        $supplier->alamat = $request->input('alamat');
        $supplier->update();
        return redirect()->route('supplier.list')->with('success', 'Data Supplier ' . ucwords($supplier->nama) . ' berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = SupplierModel::findOrFail($id);
        $supplier->delete();
        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
