<?php

namespace App\Models\ReturBarang;

use Illuminate\Support\Str;
use App\Models\Barang\BarangModel;
use App\Models\Supplier\SupplierModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggan\PelangganModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturBarangModel extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'tb_retur_barang';
    protected $primaryKey = 'id_retur';
    protected $fillable = [
        'id_barang',
        'id_pelanggan',
        'id_supplier',
        'kode_retur',
        'tanggal',
        'jumlah',
        'tipe_retur',
        'status_pergantian',
        'image',
        'path',
        'alasan',
    ];
    public $incrementing = false;
    protected $dates     = ["deleted_at"];
    protected $with = ['barang', 'pelanggan', 'supplier'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($retur) {
            $retur->kode_retur = self::generateReturCode();
        });
    }
    /**
     * Generate kode retur barang dengan format:
     * RTR.{angka_acak_8_digit}.{3_huruf_acak}
     * Contoh: RTR.04231.XYZ
     *
     * Tidak menggunakan tanggal.
     * Cek ke database untuk memastikan tidak duplikat.
     *
     * @return string Kode retur barang unik
     */
    public static function generateReturCode()
    {
        $prefix = 'RTR';
        do {
            // Buat angka acak 8 digit
            $randomNumber = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

            // Buat 3 huruf acak (A-Z)
            $random = strtoupper(Str::random(3));

            // Gabungkan semuanya
            $kode = "$prefix$randomNumber$random";

            // Ulangi jika sudah ada di database
        } while (self::where('kode_retur', $kode)->exists());

        return $kode;
    }
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'id_barang');
    }
    public function pelanggan()
    {
        return $this->belongsTo(PelangganModel::class, 'id_pelanggan');
    }
    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'id_supplier');
    }
}
