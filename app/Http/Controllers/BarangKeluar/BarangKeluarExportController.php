<?php

namespace App\Http\Controllers\BarangKeluar;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BarangKeluarExport;
use App\Http\Controllers\Controller;
use App\Models\BarangKeluar\BarangKeluarModel;
use Maatwebsite\Excel\Facades\Excel;

class BarangKeluarExportController extends Controller
{
    public function export(Request $request)
    {
        $startDate = $request->input('tanggal_awal');
        $endDate = $request->input('tanggal_akhir');
        return Excel::download(new BarangKeluarExport($startDate, $endDate), 'Laporan Barang Keluar ' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }

    public function printPdf(Request $request)
    {
        $startDate = $request->input('tanggal_awal_pdf');
        $endDate = $request->input('tanggal_akhir_pdf');

        if ($startDate && $endDate) {
            $barang_keluar = BarangKeluarModel::whereBetween('tanggal', [$startDate, $endDate])
                ->get();
        } else {
            $barang_keluar = BarangKeluarModel::all();
        }
        // Atur opsi rendering
        $pdf = PDF::loadView('BarangKeluar.cetak.cetak_pdf', compact('barang_keluar'));
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'DejaVu Sans',
        ]);
        return $pdf->stream('laporan data barang keluar ' . Carbon::now()->format('d-m-Y') . ' .pdf');
    }
}
