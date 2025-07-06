<?php

namespace App\Models\StokBarang;

use Illuminate\Support\Str;
use App\Models\Barang\BarangModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\BarangKeluar\BarangKeluarModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StokBarangModel extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'tb_stok';
    protected $primaryKey = 'id_stok';
    protected $fillable = [
        'id_barang',
        'kode_stok',
        'no_warehouse',
        'tanggal',
        'jumlah_barang',
        'lokasi',
        'keterangan',
    ];
    public $incrementing = false;
    protected $dates     = ["deleted_at"];

    protected $with = ['barang'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($stok) {
            if (empty($stok->kode_stok) && empty($stok->no_warehouse)) {
                $stok->kode_stok = self::generateCodeStock();
                $stok->no_warehouse = self::noWarehouse();
            }
        });
    }
    public static function generateCodeStock()
    {
        $prefix = 'STK';
        do {
            // Buat angka acak 8 digit
            $randomNumber = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

            // Buat 3 huruf acak (A-Z)
            $random = strtoupper(Str::random(3));

            // Gabungkan semuanya
            $kode = "$prefix$randomNumber$random";

            // Ulangi jika sudah ada di database
        } while (self::where('kode_stok', $kode)->exists());

        return $kode;
    }
    public static function noWarehouse()
    {
        $prefix = 'WH';
        do {
            // Buat angka acak 8 digit
            $randomNumber = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

            // Buat 3 huruf acak (A-Z)
            $random = strtoupper(Str::random(3));

            // Gabungkan semuanya
            $kode = "$prefix$randomNumber$random";

            // Ulangi jika sudah ada di database
        } while (self::where('no_warehouse', $kode)->exists());

        return $kode;
    }
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'id_barang');
    }
    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluarModel::class, 'id_stok');
    }
}
