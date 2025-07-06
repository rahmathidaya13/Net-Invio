<?php

namespace App\Models\Barang;

use Carbon\Carbon;
use Faker\UniqueGenerator;
use Illuminate\Support\Str;
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
            $barang->kode_barang = self::generateKodeBarang();
        });
    }

    /**
     * Generate kode barang otomatis dengan format BRG + 8 digit angka acak.
     * Contoh hasil: BRG00012345, BRG98765432
     *
     * Kode ini akan dicek ke database untuk memastikan tidak terjadi duplikasi.
     *
     * @return string Kode barang yang unik dan terformat
     */

    public static function generateKodeBarang()
    {
        $prefix = 'BRG'; // Awalan kode barang (prefix) yang konsisten
        do {
            // Buat angka acak antara 0 sampai 99.999.999
            // Kemudian pad dengan nol di depan agar selalu menjadi 8 digit
            $randomNumber = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            // Gabungkan prefix dan angka acak menjadi kode lengkap
            $kode = $prefix . $randomNumber;
            // Ulangi jika kode ini sudah ada di database (untuk menjaga keunikan)
        } while (self::where('kode_barang', $kode)->exists());
        // Kembalikan kode yang sudah dipastikan unik
        return $kode;
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
