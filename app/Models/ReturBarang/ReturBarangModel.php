<?php

namespace App\Models\ReturBarang;

use App\Models\Barang\BarangModel;
use App\Models\Pelanggan\PelangganModel;
use App\Models\Supplier\SupplierModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturBarangModel extends Model
{
    use HasFactory, HasUlids;
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
        'path',
        'alasan',
    ];
    public $incrementing = false;
    protected $dates     = ["deleted_at"];
    protected $with = ['barang', 'pelanggan', 'supplier'];
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
