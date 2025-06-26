<?php

namespace App\Http\Controllers\Pelanggan;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\TelegramNotification;
use Illuminate\Support\Facades\Cache;
use App\Models\Pelanggan\PelangganModel;
use App\Repositories\PelangganRepository;
use App\Traits\validate\pelangganValidation;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use pelangganValidation;
    protected $pelangganRepository;
    public function __construct(PelangganRepository $PelangganRepository)
    {

        $this->pelangganRepository = $PelangganRepository;
    }
    public function index(Request $request)
    {

        $filters = [
            'limit' => $request->get('limit', 10),
            'keyword' => $request->get('keyword', ''),
            'sort_order' => $request->get('sort_order', 'desc'),
            'page' => $request->get('page', 1),
        ];
        $pelanggan = $this->pelangganRepository->getListWithCache($filters)->appends($filters);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('Pelanggan.partials.table', compact('pelanggan'))->render(),
                'pagination' => view('Pelanggan.partials.pagination', compact('pelanggan'))->render(),
                'info' => [
                    'firstItem' => $pelanggan->firstItem(),
                    'lastItem' => $pelanggan->lastItem(),
                    'total' => $pelanggan->total(),
                ],
            ]);
        }
        return view('Pelanggan.index', compact('pelanggan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pelanggan.Form.forms');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Cache::flush();
        $this->validationText($request->all());
        $pelanggan = new PelangganModel();
        $pelanggan->tanggal = $request->input('tanggal');
        $pelanggan->no_identitas = $request->input('nid');
        $pelanggan->nama = $request->input('nama_pelanggan');
        $pelanggan->jenis_kelamin = $request->input('jk');
        $pelanggan->nohp = $request->input('nohp');
        $pelanggan->email = $request->input('email');
        $pelanggan->alamat = $request->input('alamat');
        $pelanggan->save();

        TelegramNotification::sendOrFail("➕ *Penambahan Data Pelanggan*\n" .
            "ID: *{$pelanggan->no_identitas}*\n" .
            "Nama Pelanggan: *{$pelanggan->nama}*\n" .
            "Jenis Kelamin: *{$pelanggan->jenis_kelamin}*\n" .
            "No.Handphone: *{$pelanggan->nohp}*\n" .
            "Alamat: *{$pelanggan->alamat}*\n" .
            "Tanggal Daftar: *" . Carbon::parse($pelanggan->tanggal)->format('d-m-Y') . "*\n" .
            "Status: *" . 'Dibuat' . "*\n" .
            "Created at: *" . auth()->user()->name . "*");

        return redirect()->route('pelanggan.list')->with('success', 'Data pelanggan ' . $pelanggan->nama . ' berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(PelangganModel $pelangganModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pelanggan = PelangganModel::findOrFail($id);
        return view('Pelanggan.Form.forms', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Cache::flush();
        $this->validationText($request->all(), $id);
        $pelanggan = PelangganModel::findOrFail($id);
        $pelanggan->tanggal = $request->input('tanggal');
        $pelanggan->no_identitas = $request->input('nid');
        $pelanggan->nama = $request->input('nama_pelanggan');
        $pelanggan->jenis_kelamin = $request->input('jk');
        $pelanggan->nohp = $request->input('nohp');
        $pelanggan->email = $request->input('email');
        $pelanggan->alamat = $request->input('alamat');
        $pelanggan->update();

        TelegramNotification::sendOrFail("📝 *Perubahan Data Pelanggan*\n" .
            "ID: *{$pelanggan->no_identitas}*\n" .
            "Nama Pelanggan: *{$pelanggan->nama}*\n" .
            "Jenis Kelamin: *{$pelanggan->jenis_kelamin}*\n" .
            "No.Handphone: *{$pelanggan->nohp}*\n" .
            "Alamat: *{$pelanggan->alamat}*\n" .
            "Tanggal Daftar: *" .  Carbon::parse($pelanggan->tanggal)->format('d-m-Y') . "*\n" .
            "Status: *" . 'Diubah' . "*\n" .
            "Updated at: *" . auth()->user()->name . "*");

        return redirect()->route('pelanggan.list')->with('success', 'Data pelanggan ' . $pelanggan->nama . ' berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cache::flush();
        $pelanggan = PelangganModel::findOrFail($id);
        $pelanggan->delete();

        TelegramNotification::sendOrFail("🗑️ *Penghapusan Data Pelanggan*\n" .
            "ID: *{$pelanggan->no_identitas}*\n" .
            "Nama Pelanggan: *{$pelanggan->nama}*\n" .
            "Jenis Kelamin: *{$pelanggan->jenis_kelamin}*\n" .
            "No.Handphone: *{$pelanggan->nohp}*\n" .
            "Alamat: *{$pelanggan->alamat}*\n" .
            "Tanggal Daftar: *" . Carbon::parse($pelanggan->tanggal)->format('d-m-Y') . "*\n" .
            "Status: *" . 'Dihapus' . "*\n" .
            "Deleted at: *" . auth()->user()->name . "*");
        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
