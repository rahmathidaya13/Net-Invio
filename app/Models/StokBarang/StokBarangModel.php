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
            if (empty($kode->kode_stok)) {
                $stok->kode_stok = self::generateCodeStock();
            }
        });
    }
    public static function generateCodeStock()
    {
        $prefix = 'STK-';
        $date = now()->format('dmy');
        $time = now()->format('His');
        $random = strtoupper(Str::random(3));
        return $prefix . $date . $time . $random;
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
