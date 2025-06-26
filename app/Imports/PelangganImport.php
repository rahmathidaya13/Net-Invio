<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\Pelanggan\PelangganModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PelangganImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $data
     */
    public $newRows = 0;

    public function collection(Collection $data)
    {
        // ambil baris dari isi file excel yaitu headernya
        $firstRow = $data->first();
        // insialisasi header column
        $columnHeader = [
            'noidentitas',
            'tanggal',
            'nama_pelanggan',
            'jenis_kelamin',
            'nohandphone',
            'email',
            'alamat',
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
            $fromExcel = $rows['tanggal'];
            $dateTime = Date::excelToDateTimeObject($fromExcel);
            $formatedDate = Carbon::instance($dateTime)->format('Y-m-d');
            // cek data barang sebelumnya, jika ada maka akan diabaikan
            $exists = PelangganModel::where("no_identitas",  $rows['noidentitas'])
                ->where('tanggal', $formatedDate)
                ->where('nama', $rows['nama_pelanggan'])
                ->where('jenis_kelamin', $rows['jenis_kelamin'])
                ->where('nohp', $rows['nohandphone'])
                ->where('email', $rows['email'])
                ->where('alamat', $rows['alamat'])
                ->exists();

            // jika data yang diinput tidak ada maka akan disimpan
            if (!$exists) {
                PelangganModel::create([
                    'no_identitas' => $rows['noidentitas'],
                    'tanggal' => $formatedDate,
                    'nama' => $rows['nama_pelanggan'],
                    'jenis_kelamin' => $rows['jenis_kelamin'],
                    'nohp' => $rows['nohandphone'],
                    'email' => $rows['email'],
                    'alamat' => $rows['alamat'],
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
