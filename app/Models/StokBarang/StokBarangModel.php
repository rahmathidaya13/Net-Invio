<?php

namespace App\Models\StokBarang;

use App\Models\Barang\BarangModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarangModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tb_stok';
    protected $primaryKey = 'id_stok';
    protected $fillable = [
        'id_barang',
        'tanggal',
        'jumlah_barang',
        'lokasi',
        'keterangan',
    ];
    public $incrementing = false;
    protected $dates     = ["deleted_at"];

    protected $with = ['barang'];
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'id_barang');
    }
}
