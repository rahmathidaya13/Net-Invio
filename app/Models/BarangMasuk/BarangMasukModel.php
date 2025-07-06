<?php

namespace App\Models\BarangMasuk;

use Illuminate\Support\Str;
use App\Models\Barang\BarangModel;
use App\Models\Supplier\SupplierModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasukModel extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'tb_barang_masuk';
    protected $primaryKey = 'id_barang_masuk';
    protected $fillable = [
        'id_barang',
        'id_supplier',
        'tanggal',
        'kode_brg_masuk',
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

    public static function boot()
    {
        parent::boot();
        static::creating(function ($barang_masuk) {
            $barang_masuk->kode_brg_masuk = self::generateInBound();
        });
    }
    /**
     * Generate kode barang masuk dengan format:
     * INB.{angka_acak_8_digit}.{3_huruf_acak}
     * Contoh: INB.04231.XYZ
     *
     * Tidak menggunakan tanggal.
     * Cek ke database untuk memastikan tidak duplikat.
     *
     * @return string Kode inbound unik
     */
    public static function generateInBound()
    {
        $prefix = 'INB';
        do {
            // Buat angka acak 8 digit
            $randomNumber = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

            // Buat 3 huruf acak (A-Z)
            $random = strtoupper(Str::random(3));

            // Gabungkan semuanya
            $kode = "$prefix$randomNumber$random";

            // Ulangi jika sudah ada di database
        } while (self::where('kode_brg_masuk', $kode)->exists());

        return $kode;
    }
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
