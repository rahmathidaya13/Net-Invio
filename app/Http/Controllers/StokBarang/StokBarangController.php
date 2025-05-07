<?php

namespace App\Http\Controllers\StokBarang;

use Illuminate\Http\Request;
use App\Models\Log\LogStokModel;
use App\Models\Barang\BarangModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\String_;
use App\Traits\Validate\StokValidation;
use App\Models\StokBarang\StokBarangModel;
use App\Models\BarangMasuk\BarangMasukModel;

class StokBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    use StokValidation;
    public function index(Request $request)
    {
        $barang_masuk = BarangMasukModel::select('id_barang_masuk', 'id_barang', 'tanggal', 'jumlah')->get();

        $limit = $request->get('limit', 10);
        $query = $request->get('keyword', '');
        $sortOrder = $request->get('sort_order', 'desc');
        $stok = StokBarangModel::join('tb_barang', 'tb_stok.id_barang', '=', 'tb_barang.id_barang')
            ->select('tb_stok.*', 'tb_barang.nama_barang')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('tb_barang.nama_barang', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('tb_barang.nama_barang', $sortOrder)
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
        return view('StokBarang.index', compact('stok', 'barang_masuk'));
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
        return redirect()->route('stok.list')->with('success', 'Penambahan Stok  Berhasil');
    }

    /**
     * Display the specified resource.
     */
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

        return redirect()->route('stok.list')->with('success', 'Perubahan Stok ' . ucwords($stok->barang->nama_barang) . '  Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $stok = StokBarangModel::findOrFail($id);
        $stok->delete();
        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
