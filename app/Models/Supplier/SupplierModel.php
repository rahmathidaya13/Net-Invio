<?php

namespace App\Models\Supplier;

use App\Models\BarangMasuk\BarangMasukModel;
use App\Models\ReturBarang\ReturBarangModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'tb_supplier';
    protected $primaryKey = 'id_supplier';
    protected $fillable = [
        'nama',
        'kontak',
        'email',
        'alamat',
    ];
    public $incrementing = false;
    protected $dates     = ["deleted_at"];
    public function barangMasuk()
    {
        // Satu data pada tabel supplier dapat memiliki banyak catatan pada tabel barang_masuk.
        return $this->hasMany(BarangMasukModel::class, "id_supplier", "id_supplier");
    }
    public function barangKembali()
    {
        // Satu data pada tabel supplier dapat memiliki banyak catatan pada tabel barang_masuk.
        return $this->hasMany(ReturBarangModel::class, "id_supplier");
    }
}
