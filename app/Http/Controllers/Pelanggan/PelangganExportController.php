<?php

namespace App\Http\Controllers\Pelanggan;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Exports\PelangganExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Pelanggan\PelangganModel;

class PelangganExportController extends Controller
{
    public function export(Request $request)
    {
        $startDate = $request->input('tanggal_awal');
        $endDate = $request->input('tanggal_akhir');
        return Excel::download(new PelangganExport($startDate, $endDate), 'Daftar Pelanggan.xlsx');
    }

    public function printPdf(Request $request)
    {
        $startDate = $request->input('tanggal_awal_pdf');
        $endDate = $request->input('tanggal_akhir_pdf');

        if ($startDate && $endDate) {
            $pelanggan = PelangganModel::whereBetween('tanggal', [$startDate, $endDate])
                ->get();
        } else {
            $pelanggan = PelangganModel::all();
        }
        // Atur opsi rendering
        $pdf = PDF::loadView('Pelanggan.cetak.cetak_pdf', compact('pelanggan'));
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'DejaVu Sans',
        ]);
        return $pdf->stream('Daftar Pelanggan.pdf');
    }
}
