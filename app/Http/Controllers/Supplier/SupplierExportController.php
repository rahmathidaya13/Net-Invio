<?php

namespace App\Http\Controllers\Supplier;

use App\Exports\SupplierExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Supplier\SupplierModel;
use Maatwebsite\Excel\Facades\Excel;

class SupplierExportController extends Controller
{
    public function export()
    {
        return Excel::download(new SupplierExport(), 'Daftar Supplier.xlsx');
    }

    public function printPdf()
    {
        $supplier = SupplierModel::all();

        // Atur opsi rendering
        $pdf = PDF::loadView('Supplier.cetak.cetak_pdf', compact('supplier'));
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'DejaVu Sans',
        ]);
        return $pdf->stream('data supplier.pdf');
    }
}
