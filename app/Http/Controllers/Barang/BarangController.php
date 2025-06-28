<?php

namespace App\Http\Controllers\Barang;

use Illuminate\Http\Request;
use App\Models\Barang\BarangModel;
use App\Http\Controllers\Controller;
use App\Helpers\TelegramNotification;
use Illuminate\Support\Facades\Cache;
use App\Repositories\BarangRepository;
use App\Traits\validate\ItemValidation;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ItemValidation;
    protected $barangRepository;
    public function __construct(BarangRepository $itemRepository)
    {
        $this->barangRepository = $itemRepository;
    }
    public function index(Request $request)
    {
        $filters = [
            'limit' => $request->get('limit', 10),
            'keyword' => $request->get('keyword', ''),
            'sort_order' => $request->get('sort_order', 'desc'),
            'page' => $request->get('page', 1),
        ];

        $barang = $this->barangRepository->getListWithCache($filters)->appends($filters);
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
        // $this->authorize('can_add', BarangModel::class); // untuk gunakan policy pada controller
        return view('Barang.Form.forms');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateItem($request->all());
        $barang = new BarangModel();
        // $barang->kode_barang = $request->input('kode_barang'); //sudah digenerate otomatis
        $barang->serial_number = $request->input('sn', '-');
        $barang->nama_barang = $request->input('nama_barang');
        $barang->jenis = $request->input('jenis_barang');
        $barang->merek = $request->input('merek');
        $barang->tipe_model = $request->input('model', '-');
        $barang->satuan = $request->input('satuan');
        $barang->keterangan = $request->input('keterangan', '-');
        $barang->save();

        TelegramNotification::sendOrFail("➕ *Penambahan Data Barang*\n" .
            "Nama Barang: *{$barang->nama_barang}*\n" .
            "Serial Number: *{$barang->serial_number}*\n" .
            "Jenis Barang: *{$barang->jenis}*\n" .
            "Merek: *{$barang->merek}*\n" .
            "Model: *{$barang->tipe_model}*\n" .
            "Satuan: *{$barang->satuan}*\n" .
            "Status: *" . 'Dibuat' . "*\n" .
            "Created at: *" . auth()->user()->name . "*");

        Cache::flush();
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
        $this->validateItem($request->all());
        $barang =  BarangModel::findOrFail($id);
        // $barang->kode_barang = $request->input('kode_barang'); // sudah digenerate otomatis
        $barang->serial_number = $request->input('sn');
        $barang->nama_barang = $request->input('nama_barang');
        $barang->jenis = $request->input('jenis_barang');
        $barang->merek = $request->input('merek');
        $barang->tipe_model = $request->input('model');
        $barang->satuan = $request->input('satuan');
        $barang->keterangan = $request->input('keterangan');
        $barang->update();

        TelegramNotification::sendOrFail("📝 *Perubahan Data Barang*\n" .
            "Nama Barang: *{$barang->nama_barang}*\n" .
            "Serial Number: *{$barang->serial_number}*\n" .
            "Jenis Barang: *{$barang->jenis}*\n" .
            "Merek: *{$barang->merek}*\n" .
            "Model: *{$barang->tipe_model}*\n" .
            "Satuan: *{$barang->satuan}*\n" .
            "Status: *" . 'Diubah' . "*\n" .
            "Created at: *" . auth()->user()->name . "*");

        Cache::flush();
        return redirect()->route('barang.list')->with('success', 'Data Barang ' . ucwords($barang->nama_barang) . ' Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = BarangModel::findOrFail($id);
        $barang->delete();
        TelegramNotification::sendOrFail("🗑️ *Penghapusan Data Barang*\n" .
            "Nama Barang: *{$barang->nama_barang}*\n" .
            "Serial Number: *{$barang->serial_number}*\n" .
            "Jenis Barang: *{$barang->jenis}*\n" .
            "Merek: *{$barang->merek}*\n" .
            "Model: *{$barang->tipe_model}*\n" .
            "Satuan: *{$barang->satuan}*\n" .
            "Status: *" . 'Dihapus' . "*\n" .
            "Created at: *" . auth()->user()->name . "*");
        Cache::flush();

        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
