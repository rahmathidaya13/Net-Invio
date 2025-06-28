<?php

namespace App\Repositories;

use App\Models\Supplier\SupplierModel;
use Illuminate\Support\Facades\Cache;

class SupplierRepository
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
        $cacheKey = 'supplier_' . auth()->id() . '_' . md5("limit={$limit}&keyword={$keyword}&sort={$sortOrder}&page={$page}");

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($limit, $keyword, $sortOrder) {
            return SupplierModel::when($keyword, function ($q) use ($keyword) {
                $q->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('nama', 'like', '%' . $keyword . '%')
                        ->orWhere('kontak', 'like', '%' . $keyword . '%')
                        ->orWhere('email', 'like', '%' . $keyword . '%');
                });
            })->latest()
                ->orderBy('nama', $sortOrder)
                ->paginate($limit);
        });
    }
}
