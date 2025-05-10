<?php

namespace App\Models\ReturBarang;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturBarangModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tb_retur_barang';
    protected $primaryKey = 'id_retur';
    protected $fillable = [
        'id_barang',
        'id_pelanggan',
        'id_supplier',
        'tanggal',
        'jumlah',
        'tipe_retur',
        'status_pergantian',
        'image',
        'alasan',
    ];
    public $incrementing = false;
    protected $dates     = ["deleted_at"];
}
