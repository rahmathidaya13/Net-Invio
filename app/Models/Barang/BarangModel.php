<?php

namespace App\Models\Barang;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tb_barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = [
        'kode_barang',
        'jenis',
        'merek',
        'tipe_model',
        'serial_number',
        'satuan',
        'keterangan',
    ];

    protected $dates     = ["deleted_at"];
    public $incrementing = false;
}
