<?php

namespace App\Models\BarangKeluar;

use Illuminate\Support\Str;
use App\Models\Barang\BarangModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggan\PelangganModel;
use App\Models\StokBarang\StokBarangModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangKeluarModel extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'tb_barang_keluar';
    protected $primaryKey = 'id_barang_keluar';
    protected $fillable = [
        'id_barang',
        'id_pelanggan',
        'id_stok',
        'kode_barang_keluar',
        'tanggal',
        'kode_retur',
        'jumlah',
        'tujuan',
        'satuan',
        'petugas',
        'lokasi',
        'keterangan',
    ];

    protected $dates     = ["deleted_at"];
    public $incrementing = false;
    protected $with = ['barang', 'pelanggan', 'stok'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($barang_keluar) {
            $barang_keluar->kode_barang_keluar = self::generateOutBound();
        });
    }

    /**
     * Generate kode barang keluar dengan format:
     * OTB.{angka_acak_8_digit}.{3_huruf_acak}
     * Contoh: OTB.04231.XYZ
     *
     * Tidak menggunakan tanggal.
     * Cek ke database untuk memastikan tidak duplikat.
     *
     * @return string Kode outbound unik
     */
    public static function generateOutBound()
    {
        $prefix = 'OTB';
        do {
            // Buat angka acak 8 digit
            $randomNumber = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

            // Buat 3 huruf acak (A-Z)
            $random = strtoupper(Str::random(3));

            // Gabungkan semuanya
            $kode = "$prefix$randomNumber$random";

            // Ulangi jika sudah ada di database
        } while (self::where('kode_barang_keluar', $kode)->exists());

        return $kode;
    }

    public function barang()
    {
        return $this->belongsTo(BarangModel::class, "id_barang");
    }
    public function pelanggan()
    {
        return $this->belongsTo(PelangganModel::class, "id_pelanggan");
    }
    public function stok()
    {
        return $this->belongsTo(StokBarangModel::class, "id_stok");
    }
}
