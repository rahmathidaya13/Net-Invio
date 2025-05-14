<?php

namespace App\Http\Controllers\Barang;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Exports\BarangExport;
use App\Models\Barang\BarangModel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Options;

class BarangExportController extends Controller
{
    public function export()
    {
        return Excel::download(new BarangExport(), 'Laporan Daftar Barang.xlsx');
    }

    public function printPdf()
    {
        $barang = BarangModel::all();

        // Atur opsi rendering
        $pdf = PDF::loadView('Barang.cetak.cetak_pdf', compact('barang'));
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'DejaVu Sans',
        ]);
        return $pdf->stream('laporan data barang.pdf');
    }
}
