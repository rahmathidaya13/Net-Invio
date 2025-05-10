<?php

namespace App\Models\BarangKeluar;

use App\Models\Barang\BarangModel;
use App\Models\Pelanggan\PelangganModel;
use App\Models\StokBarang\StokBarangModel;
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
        'id_stok',
        'kode_barang_keluar',
        'tanggal',
        'kode_retur',
        'jumlah',
        'tujuan',
        'satuan',
        'petugas',
        'lokasi',
        'keterangan',
    ];

    protected $dates     = ["deleted_at"];
    public $incrementing = false;
    protected $with = ['barang', 'pelanggan', 'stok'];
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, "id_barang");
    }
    public function pelanggan()
    {
        return $this->belongsTo(PelangganModel::class, "id_pelanggan");
    }
    public function stok()
    {
        return $this->belongsTo(StokBarangModel::class, "id_stok");
    }
}
