<?php

namespace App\Models\BarangMasuk;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasukModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tb_barang_masuk';
    protected $primaryKey = 'id_barang_masuk';
    protected $fillable = [
        'id_barang',
        'id_supplier',
        'tanggal',
        'sumber',
        'pembeli',
        'nota',
        'jumlah',
        'keterangan',
    ];

    protected $dates     = ["deleted_at"];
    public $incrementing = false;
}
