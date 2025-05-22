<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use App\Imports\BarangImport;
use App\Models\Barang\BarangModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BarangImportController extends Controller
{
    public function imports(Request $request)
    {
        $request->validate([
            'file_import' => 'required|mimes:xlsx,xls,csv',
        ], [
            'file_import.required' => 'File import harus dipilih.',
            'file_import.mimes' => 'File import dipilih tidak sesuai, pastikan format csv,xlsx,xls.'

        ]);
        $barangImport = new BarangImport();
        Excel::import($barangImport,  $request->file('file_import'));
        $countRows = $barangImport->countRowNew();
        return back()->with('success', "Data barang berhasil diimport sebanyak $countRows items");
    }
}
