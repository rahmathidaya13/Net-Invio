<?php

namespace App\Http\Controllers\BarangMasuk;

use Illuminate\Http\Request;
use App\Exports\BarangMasukExport;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BarangMasuk\BarangMasukModel;
use Carbon\Carbon;

class BarangMasukExportController extends Controller
{
    public function export(Request $request)
    {
        $startDate = $request->input('tanggal_awal');
        $endDate = $request->input('tanggal_akhir');
        return Excel::download(new BarangMasukExport($startDate, $endDate), 'Laporan Barang Masuk ' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }

    public function printPdf(Request $request)
    {
        $startDate = $request->input('tanggal_awal_pdf');
        $endDate = $request->input('tanggal_akhir_pdf');

        if ($startDate && $endDate) {
            $barang_masuk = BarangMasukModel::whereBetween('tanggal', [$startDate, $endDate])
                ->get();
        } else {
            $barang_masuk = BarangMasukModel::all();
        }
        // Atur opsi rendering
        $pdf = PDF::loadView('BarangMasuk.cetak.cetak_pdf', compact('barang_masuk'));
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'DejaVu Sans',
        ]);
        return $pdf->stream('laporan data barang masuk ' . Carbon::now()->format('d-m-Y') . ' .pdf');
    }
}
