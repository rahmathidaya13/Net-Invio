<?php

namespace App\Http\Controllers\StokBarang;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Log\LogStokModel;
use App\Models\Barang\BarangModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\StokRepository;
use Illuminate\Support\Facades\Auth;
use App\Helpers\TelegramNotification;
use Illuminate\Support\Facades\Cache;
use PhpParser\Node\Expr\Cast\String_;
use App\Traits\validate\StokValidation;
use App\Models\StokBarang\StokBarangModel;
use App\Models\BarangMasuk\BarangMasukModel;

class StokBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    use StokValidation;
    protected $stokRepository;
    public function __construct(StokRepository $stockRepository)
    {
        $this->stokRepository = $stockRepository;
    }
    public function index(Request $request)
    {
        $filters = [
            'limit' => $request->get('limit', 10),
            'keyword' => $request->get('keyword', ''),
            'sort_order' => $request->get('sort_order', 'desc'),
            'page' => $request->get('page', 1),
        ];
        $stok = $this->stokRepository->getListWithCache($filters)->appends($filters);
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
        return view('StokBarang.index', compact('stok'));
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
        $this->validationText($request->all());
        $stok = new StokBarangModel();
        $stok->id_barang = $request->input('nama_barang');
        $stok->tanggal = $request->input('tanggal');
        $stok->jumlah_barang =  (int) $request->input('jumlah');
        $stok->lokasi = $request->input('lokasi');
        $stok->keterangan = $request->input('keterangan');
        $stok->asal_barang = 'barang_tersedia';
        $stok->save();

        // khusus untuk catat log baru
        LogStokModel::create([
            'id_barang' => $stok->id_barang,
            'tanggal' => $stok->tanggal,
            'tipe' => 'barang_tersedia',
            'jumlah' =>  $stok->jumlah_barang,
            'lokasi' => $stok->lokasi,
            'keterangan' => $stok->keterangan,
            'dibuat_oleh' => Auth::user()->name,
        ]);

        TelegramNotification::sendOrFail("➕ *Penambahan Stok Barang*\n" .
            "Tanggal: *" . Carbon::parse($stok->tanggal)->format('d-m-Y') . "*\n" .
            "Nama Barang: *{$stok->barang->nama_barang}*\n" .
            "Jumlah Barang: *{$stok->jumlah_barang}*\n" .
            "Lokasi: *{$stok->lokasi}*\n" .
            "Status: *" . 'Dibuat' . "*\n" .
            "Created at: *" . auth()->user()->name . "*");
        Cache::flush();
        return redirect()->route('stok.list')->with('success', 'Penambahan Stok  Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stok = StokBarangModel::where('id_stok', $id)
            ->first();
        return response()->json([
            'stok' => $stok,
        ], 200);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = BarangModel::select('id_barang', 'nama_barang')->get();
        $stok = StokBarangModel::findOrFail($id);
        return view('StokBarang.Form.forms', compact('stok', 'barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validationText($request->all(), $id);

        // Update data stok
        $stok = StokBarangModel::findOrFail($id);
        $stok->id_barang = $request->input('nama_barang');
        $stok->tanggal = $request->input('tanggal');
        $stok->jumlah_barang = $request->input('jumlah');
        $stok->lokasi = $request->input('lokasi');
        $stok->keterangan = $request->input('keterangan');
        $stok->asal_barang = 'barang_tersedia';
        $stok->update();

        // khusus untuk catat log baru
        LogStokModel::create([
            'id_barang' => $stok->id_barang,
            'tanggal' => $stok->tanggal,
            'tipe' => 'barang_tersedia',
            'jumlah' =>  $stok->jumlah_barang,
            'lokasi' =>  $stok->lokasi,
            'keterangan' => $stok->keterangan,
            'dibuat_oleh' => Auth::user()->name,
        ]);

        TelegramNotification::sendOrFail("📝 *Perubahan Stok Barang*\n" .
            "Tanggal: *" . Carbon::parse($stok->tanggal)->format('d-m-Y') . "*\n" .
            "Nama Barang: *{$stok->barang->nama_barang}*\n" .
            "Jumlah Barang: *{$stok->jumlah_barang}*\n" .
            "Lokasi: *{$stok->lokasi}*\n" .
            "Status: *" . 'Diubah' . "*\n" .
            "Updated at: *" . auth()->user()->name . "*");

        Cache::flush();
        return redirect()->route('stok.list')->with('success', 'Perubahan Stok ' . ucwords($stok->barang->nama_barang) . '  Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $stok = StokBarangModel::findOrFail($id);
        $stok->delete();
        TelegramNotification::sendOrFail("🗑️ *Penghapusan Stok Barang*\n" .
            "Tanggal: *" . Carbon::parse($stok->tanggal)->format('d-m-Y') . "*\n" .
            "Nama Barang: *{$stok->barang->nama_barang}*\n" .
            "Jumlah Barang: *{$stok->jumlah_barang}*\n" .
            "Lokasi: *{$stok->lokasi}*\n" .
            "Status: *" . 'Dihapus' . "*\n" .
            "Deleted at: *" . auth()->user()->name . "*");
        Cache::flush();
        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
