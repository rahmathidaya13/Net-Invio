<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogStokModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'log_stok';
    protected $primaryKey = 'id_log_stok';
    protected $fillable = [
        'id_barang',
        'tanggal',
        'tipe',
        'jumlah',
        'lokasi',
        'keterangan',
        'dibuat_oleh',
    ];

    public $incrementing = false;
}
