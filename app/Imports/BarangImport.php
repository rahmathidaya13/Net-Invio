<?php

namespace App\Imports;

use App\Models\Barang\BarangModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToCollection, WithHeadingRow
{

    public $newRows = 0;

    public function collection(Collection $data)
    {
        // ambil baris dari isi file excel yaitu headernya
        $firstRow = $data->first();
        // insialisasi header column
        $columnHeader = [
            'kode_barang',
            'nama_barang',
            'jenis',
            'merek',
            'tipe_model',
            'serial_number',
            'satuan',
            'keterangan',
        ];
        // validasi isi header column atau isi file excel or csv
        foreach ($columnHeader as $col) {
            if (!isset($firstRow[$col])) {
                throw ValidationException::withMessages([
                    'error' => "Format file tidak sesuai dengan template"
                ]);
            }
        }

        // Simpan data
        foreach ($data as $rows) {
            // cek data barang sebelumnya, jika ada maka akan diabaikan
            $exists = BarangModel::where("kode_barang", $rows['kode_barang'])
                ->where('nama_barang', $rows['nama_barang'])
                ->where('jenis', $rows['jenis'])
                ->where('merek', $rows['merek'])
                ->where('tipe_model', $rows['tipe_model'])
                ->where('serial_number', $rows['serial_number'])
                ->where('satuan', $rows['satuan'])
                ->where('keterangan', $rows['keterangan'])
                ->exists();

            // jika data yang diinput tidak ada maka akan disimpan
            if (!$exists) {
                BarangModel::create([
                    'kode_barang' => $rows['kode_barang'],
                    'nama_barang' => $rows['nama_barang'],
                    'jenis' => $rows['jenis'],
                    'merek' => $rows['merek'],
                    'tipe_model' => $rows['tipe_model'],
                    'serial_number' => $rows['serial_number'],
                    'satuan' => $rows['satuan'],
                    'keterangan' => $rows['keterangan'],
                ]);
                $this->newRows++;
            }
        }
    }

    public function countRowNew()
    {
        return $this->newRows;
    }
    public function headingRow(): int
    {
        return 4;
    }
}
