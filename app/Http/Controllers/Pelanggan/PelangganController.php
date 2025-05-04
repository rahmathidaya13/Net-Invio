<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan\PelangganModel;
use App\Traits\Validate\PelangganValidation;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use PelangganValidation;
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $query = $request->get('keyword', '');
        $sortOrder = $request->get('sort_order', 'desc');

        $pelanggan = PelangganModel::when($query, function ($q) use ($query) {
            $q->where(function ($subQuery) use ($query) {
                $subQuery->where('nama', 'like', '%' . $query . '%')
                    ->orWhere('nohp', 'like', '%' . $query . '%');
            });
        })->latest()
            ->orderBy('nama', $sortOrder)
            ->paginate($limit)
            ->appends(['keyword' => $query, 'limit' => $limit, 'sort_order' => $sortOrder]);

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

        $this->validationText($request->all(), $id);
        $pelanggan = new PelangganModel();
        $pelanggan->tanggal = $request->input('tanggal');
        $pelanggan->no_identitas = $request->input('nid');
        $pelanggan->nama = $request->input('nama_pelanggan');
        $pelanggan->jenis_kelamin = $request->input('jk');
        $pelanggan->nohp = $request->input('nohp');
        $pelanggan->email = $request->input('email');
        $pelanggan->alamat = $request->input('alamat');
        $pelanggan->update();
        return redirect()->route('pelanggan.list')->with('success', 'Data pelanggan ' . $pelanggan->nama . ' berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = PelangganModel::findOrFail($id);
        $pelanggan->delete();
        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
