<?php

namespace App\Repositories;

use App\Models\Barang\BarangModel;
use Illuminate\Support\Facades\Cache;

class BarangRepository
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
        $cacheKey = 'barang_' . auth()->id() . '_' . md5("limit={$limit}&keyword={$keyword}&sort={$sortOrder}&page={$page}");

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($limit, $keyword, $sortOrder) {
            return BarangModel::when($keyword, function ($q) use ($keyword) {
                $q->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('kode_barang', 'like', '%' . $keyword . '%')
                        ->orWhere('nama_barang', 'like', '%' . $keyword . '%')
                        ->orWhere('serial_number', 'like', '%' . $keyword . '%')
                        ->orWhere('tipe_model', 'like', '%' . $keyword . '%');
                });
            })->latest()
                ->orderBy('nama_barang', $sortOrder)
                ->paginate($limit);
        });
    }
}
