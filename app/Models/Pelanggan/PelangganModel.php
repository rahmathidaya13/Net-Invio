<?php

namespace App\Models\Pelanggan;

use App\Models\BarangKeluar\BarangKeluarModel;
use App\Models\ReturBarang\ReturBarangModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PelangganModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tb_pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = [
        'tanggal',
        'nama',
        'nohp',
        'email',
        'jenis_kelamin',
        'alamat',
        'no_identitas'
    ];
    public $incrementing = false;
    protected $dates     = ["deleted_at"];

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluarModel::class, "id_pelanggan");
    }
    public function barangKembali()
    {
        return $this->hasMany(ReturBarangModel::class, "id_pelanggan");
    }
}
