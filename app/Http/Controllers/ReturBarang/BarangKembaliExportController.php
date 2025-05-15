<?php

namespace App\Http\Controllers\ReturBarang;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BarangKembaliExport;
use App\Http\Controllers\Controller;
use App\Models\ReturBarang\ReturBarangModel;
use Maatwebsite\Excel\Facades\Excel;

class BarangKembaliExportController extends Controller
{
    public function export(Request $request)
    {
        $startDate = $request->input('tanggal_awal');
        $endDate = $request->input('tanggal_akhir');
        return Excel::download(new BarangKembaliExport($startDate, $endDate), 'Laporan Barang Kembali ' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }

    public function printPdf(Request $request)
    {
        $startDate = $request->input('tanggal_awal_pdf');
        $endDate = $request->input('tanggal_akhir_pdf');

        if ($startDate && $endDate) {
            $barang_kembali = ReturBarangModel::whereBetween('tanggal', [$startDate, $endDate])
                ->get();
        } else {
            $barang_kembali = ReturBarangModel::all();
        }
        // Atur opsi rendering
        $pdf = PDF::loadView('BarangKembali.cetak.cetak_pdf', compact('barang_kembali'));
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'DejaVu Sans',
        ]);
        return $pdf->stream('laporan data barang keluar ' . Carbon::now()->format('d-m-Y') . ' .pdf');
    }
}
