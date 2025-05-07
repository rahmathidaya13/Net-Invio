<?php

namespace App\Models\Barang;

use App\Models\BarangMasuk\BarangMasukModel;
use App\Models\StokBarang\StokBarangModel;
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
        'nama_barang',
        'jenis',
        'merek',
        'tipe_model',
        'serial_number',
        'satuan',
        'lokasi',
        'keterangan',
    ];

    protected $dates     = ["deleted_at"];
    public $incrementing = false;

    public function stok()
    {
        return $this->hasOne(StokBarangModel::class, "id_barang");
    }

    public function barangMasuk()
    {
        // Satu data pada tabel barang dapat memiliki banyak entri pada tabel barang_masuk.
        return $this->hasMany(BarangMasukModel::class, 'id_barang');
    }
}
