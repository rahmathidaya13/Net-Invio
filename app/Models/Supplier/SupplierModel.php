<?php

namespace App\Models\Supplier;

use App\Models\BarangMasuk\BarangMasukModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory, HasUuids;
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
}
