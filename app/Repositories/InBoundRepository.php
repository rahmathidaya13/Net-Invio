<?php

namespace App\Repositories;

use App\Models\BarangMasuk\BarangMasukModel;
use Illuminate\Support\Facades\Cache;

class InBoundRepository
{
    public function getListWithCache(array $filters)
    {
        //Cache::remember($key, $minutes, $callback) akan:
        //Mengecek apakah data dengan key itu ada.
        //Jika tidak ada, jalankan closure dan simpan hasilnya ke cache selama waktu yang ditentukan (5 menit di sini).
        //md5() digunakan untuk membentuk cache key unik dari kombinasi keyword, limit, sort_order, dan page.

        $limit = $filters['limit'] ?? 10;
        $keyword = $filters['keyword'] ?? '';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $page = $filters['page'] ?? 1;

        // cache berdasarkan kombinasi filter (keyword, limit, sort_order, page)
        $cacheKey = 'barang_masuk_' . auth()->id() . '_' . md5("limit={$limit}&keyword={$keyword}&sort={$sortOrder}&page={$page}");

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($limit, $keyword, $sortOrder) {
            return BarangMasukModel::join("tb_barang", "tb_barang_masuk.id_barang", "=", "tb_barang.id_barang")
                ->leftJoin("tb_supplier", "tb_barang_masuk.id_supplier", "=", "tb_supplier.id_supplier")
                ->select("tb_barang_masuk.*", "tb_barang.nama_barang", "tb_supplier.nama as nama_supplier")
                ->when($keyword, function ($q) use ($keyword) {
                    $q->where(function ($subQuery) use ($keyword) {
                        $subQuery->where('tb_barang.nama_barang', 'like', '%' . $keyword . '%')
                            ->orWhere('tb_supplier.nama', 'like', '%' . $keyword . '%')
                            ->orWhere('kode_brg_masuk', 'like', '%' . $keyword . '%');
                    });
                })->orderBy('tb_barang.nama_barang', $sortOrder)
                ->paginate($limit);
        });
    }
}
