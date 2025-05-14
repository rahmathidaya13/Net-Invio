<?php

namespace App\Exports;

use App\Models\Barang\BarangModel;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangExport implements FromView, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view("Barang.cetak.cetak_excel", ["barang" => BarangModel::all()]);
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Jenis',
            'Merek',
            'Tipe Model',
            'Serial Number',
            'Satuan',
            'Keterangan'
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Merge cell A1 sampai H1 dan A2 sampai H2 untuk area judul
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');

        // Styling untuk judul di baris 1 (misalnya: "Laporan Data Barang")
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 20,
                'name' => 'calibri'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 20,
                'name' => 'calibri'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        // end styling judul

        // Tinggikan tinggi baris 1 dan 2 agar teks tidak terlalu mepet
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(30);

        // Styling untuk header tabel (baris ke-4)
        $sheet->getStyle('A4:H4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => '000000'], // Warna teks hitam
                'size' => 12,
                'name' => 'calibri'
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'd1e7dd'], // Hijau pastel
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);
        // end styling header table

        // Tinggikan baris header agar tampak rapi
        $sheet->getRowDimension(4)->setRowHeight(22);
        // Atur tinggi baris untuk setiap baris isi data (dari baris ke-5 hingga baris terakhir)
        for ($row = 5; $row <= $sheet->getHighestRow(); $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20); // tinggi 20 bisa disesuaikan
        }


        // Bungkus teks header jika terlalu panjang
        $sheet->getStyle('A4:H4')->getAlignment()->setWrapText(true);


        // Ambil jumlah baris terakhir yang berisi data
        $lastRow = $sheet->getHighestRow();

        // Styling isi tabel (baris 5 hingga baris terakhir)
        $sheet->getStyle("A5:H$lastRow")->applyFromArray([
            'font' => [
                'size' => 12,
                'name' => 'Calibri',
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);


        // Tambahkan Zebra striping untuk baris isi (baris ganjil mulai dari baris 5)
        for ($row = 5; $row <= $lastRow; $row++) {
            if ($row % 2 != 0) {
                $sheet->getStyle("A$row:H$row")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'E6E6E6'], // Abu terang
                    ],
                ]);
            }
        }

        // Auto resize semua kolom dari A sampai H agar konten tidak terpotong
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }
}
