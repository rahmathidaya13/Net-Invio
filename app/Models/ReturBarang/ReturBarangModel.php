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

    public static function generateReturCode()
    {
        $prefix = 'RTR';
        $date = now()->format('dmy');
        $randomNumber = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $random = strtoupper(Str::random(3));
        return "$prefix.$date.$randomNumber$random";
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
