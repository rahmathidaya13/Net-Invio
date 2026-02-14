<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\TelegramNotification;
use Illuminate\Support\Facades\Cache;
use App\Models\Supplier\SupplierModel;
use App\Repositories\SupplierRepository;
use App\Traits\validate\supplierValidation;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use supplierValidation;

    protected $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }
    public function index(Request $request)
    {
        $filters = [
            'limit' => $request->get('limit', 10),
            'keyword' => $request->get('keyword', ''),
            'sort_order' => $request->get('sort_order', 'desc'),
            'page' => $request->get('page', 1),
        ];

        $supplier = $this->supplierRepository->getListWithCache($filters)->appends($filters);

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

        // TelegramNotification::sendOrFail("➕ *Penambahan Supplier Baru*\n" .
        //     "Nama Supplier: *{$supplier->nama}*\n" .
        //     "kontak: *{$supplier->kontak}*\n" .
        //     "Email: *{$supplier->email}*\n" .
        //     "Alamat: *{$supplier->alamat}*\n" .
        //     "Status: *" . 'Dibuat' . "*\n" .
        //     "Created at: *" . auth()->user()->name . "*");
        Cache::flush();

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
        // TelegramNotification::sendOrFail("📝 *Perubahan Data Supplier*\n" .
        //     "Nama Supplier: *{$supplier->nama}*\n" .
        //     "kontak: *{$supplier->kontak}*\n" .
        //     "Email: *{$supplier->email}*\n" .
        //     "Alamat: *{$supplier->alamat}*\n" .
        //     "Status: *" . 'Diubah' . "*\n" .
        //     "Updated at: *" . auth()->user()->name . "*");
        Cache::flush();
        return redirect()->route('supplier.list')->with('success', 'Data Supplier ' . ucwords($supplier->nama) . ' berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = SupplierModel::findOrFail($id);
        $supplier->delete();
        // TelegramNotification::sendOrFail("🗑️ *Penghapusan Data Supplier*\n" .
        //     "Nama Supplier: *{$supplier->nama}*\n" .
        //     "kontak: *{$supplier->kontak}*\n" .
        //     "Email: *{$supplier->email}*\n" .
        //     "Alamat: *{$supplier->alamat}*\n" .
        //     "Status: *" . 'Dihapus' . "*\n" .
        //     "Deleted at: *" . auth()->user()->name . "*");
        Cache::flush();
        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
