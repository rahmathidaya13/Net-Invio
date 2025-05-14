<?php

namespace App\Http\Controllers\StokBarang;

use Illuminate\Http\Request;
use App\Exports\StokBarangExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\StokBarang\StokBarangModel;
use Barryvdh\DomPDF\Facade\Pdf;

class StokBarangExportController extends Controller
{
    public function export()
    {
        return Excel::download(new StokBarangExport(), 'Laporan Stok Barang.xlsx');
    }

    public function printPdf()
    {
        $stok = StokBarangModel::all();

        // Atur opsi rendering
        $pdf = PDF::loadView('StokBarang.cetak.cetak_pdf', compact('barang'));
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'DejaVu Sans',
        ]);
        return $pdf->stream('laporan data stok barang.pdf');
    }
}
