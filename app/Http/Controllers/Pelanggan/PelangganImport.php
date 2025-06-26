<?php

namespace App\Http\Controllers\Pelanggan;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Imports\PelangganImport as ImportsPelanggan;

class PelangganImport extends Controller
{
    public function imports(Request $request)
    {
        $request->validate([
            'file_import' => 'required|mimes:xlsx,xls,csv',
        ], [
            'file_import.required' => 'File import harus dipilih.',
            'file_import.mimes' => 'File import dipilih tidak sesuai, pastikan format csv,xlsx,xls.'

        ]);
        $pelanggan = new ImportsPelanggan();
        Excel::import($pelanggan,  $request->file('file_import'));
        $countRows = $pelanggan->countRowNew();
        return back()->with('success',  "Data pelanggan berhasil diimport sebanyak $countRows items");
    }
}
