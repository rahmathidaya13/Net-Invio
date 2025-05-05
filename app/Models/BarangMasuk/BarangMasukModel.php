<?php

namespace App\Models\BarangMasuk;

use App\Models\Barang\BarangModel;
use App\Models\Supplier\SupplierModel;
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
        'harga',
        'keterangan',
    ];

    protected $dates     = ["deleted_at"];
    public $incrementing = false;
    protected $with = ['barang', 'supplier'];
    public function barang()
    {
        // Setiap data pada tabel barang_masuk berelasi dengan satu data pada tabel barang
        return $this->belongsTo(BarangModel::class, "id_barang");
    }

    public function supplier()
    {
        // Setiap data pada tabel barang_masuk berelasi dengan satu data pada tabel supplier
        return $this->belongsTo(SupplierModel::class, 'id_supplier');
    }
}
