<?php

namespace App\Models\Barang;

use Carbon\Carbon;
use Faker\UniqueGenerator;
use Illuminate\Database\Eloquent\Model;
use App\Models\StokBarang\StokBarangModel;
use App\Models\BarangMasuk\BarangMasukModel;
use App\Models\ReturBarang\ReturBarangModel;
use App\Models\BarangKeluar\BarangKeluarModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangModel extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'tb_barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jenis',
        'merek',
        'tipe_model',
        'serial_number',
        'satuan',
        'lokasi',
        'keterangan',
    ];

    protected $dates     = ["deleted_at"];
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($barang) {
            $barang->kode_barang = self::genarateKodeBarang();
        });
    }

    public static function genarateKodeBarang()
    {
        $prefix = 'BRG';
        $datePart = now()->format('dmy');

        // Ambil data barang terakhir berdasarkan kode_barang (urut menurun)
        $lastBarang = self::where('kode_barang', 'like', "$prefix%")
            ->orderBy('kode_barang', 'desc')
            ->first();

        $lastNumber = 0;

        // Cek apakah barang terakhir ada, dan ambil angka urutnya
        // Ini adalah regular expression (regex) yang dipakai untuk menangkap tiga digit angka terakhir dari string kode_barang. Mari kita uraikan bagian per bagian:
        if ($lastBarang && preg_match('/(\d{3})$/', $lastBarang->kode_barang, $matches)) {
            $lastNumber = (int) $matches[1]; // $matches[1] → hasil dari group tangkap pertama, yaitu (\d{3}).
        }

        $nextNumber = $lastNumber + 1;

        // Format angka 3 digit, contoh: 001, 002, dst.
        $numberFormatted = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Gabungkan semua jadi kode lengkap
        return "{$prefix}{$datePart}{$numberFormatted}";
    }
    // relasi dengan table stok
    public function stok()
    {
        return $this->hasOne(StokBarangModel::class, "id_barang");
    }

    public function barangMasuk()
    {
        // Satu data pada tabel barang dapat memiliki banyak entri pada tabel barang_masuk.
        return $this->hasMany(BarangMasukModel::class, 'id_barang');
    }
    public function barangKeluar()
    {
        // Satu data pada tabel barang dapat memiliki banyak entri pada tabel barang keluar.
        return $this->hasMany(BarangKeluarModel::class, 'id_barang');
    }
    public function barangKembali()
    {
        // Satu data pada tabel barang dapat memiliki banyak entri pada tabel barang keluar.
        return $this->hasMany(ReturBarangModel::class, 'id_barang');
    }
}
