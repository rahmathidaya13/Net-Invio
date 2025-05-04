<?php

namespace App\Models\BarangKeluar;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluarModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tb_barang_keluar';
    protected $primaryKey = 'id_barang_keluar';
    protected $fillable = [
        'id_barang',
        'id_pelanggan',
        'tanggal',
        'jumlah',
        'tujuan',
        'keterangan',
    ];

    protected $dates     = ["deleted_at"];
    public $incrementing = false;
}
