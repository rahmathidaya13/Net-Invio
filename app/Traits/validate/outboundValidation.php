<?php

namespace App\Traits\validate;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

trait outboundValidation
{
    public function validationText($request, $isUpdated = false)
    {
        $rules = [
            "tanggal" => 'required|date|in:' . now()->toDateString(),
            "id_barang" => [
                'required',
                Rule::exists('tb_barang', 'id_barang')
            ],
            "id_stok" => [
                'required',
                Rule::exists('tb_stok', 'id_stok')
            ],
            "pelanggan" => [
                'required',
                'exists:tb_pelanggan,id_pelanggan'
            ],
            'lokasi' => ['required', 'string', 'in:gudang-1,gudang-2'],
            'tujuan' => ['required', 'string', 'in:pemasangan,pergantian'],
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string',
            'petugas' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:250',
            'kode_keluar' => 'required|string|max:25',
        ];
        if (!$isUpdated) {
            $rules['barang'] = ['required', 'exists:tb_stok,id_stok'];
        }
        return Validator::make($request, $rules, [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal tidak valid.',
            'tanggal.in' => 'Tanggal hanya boleh diisi dengan hari ini.',

            'barang.required' => 'Nama Barang wajib dipilih.',
            'barang.exists' => 'Nama Barang tidak ditemukan.',

            'pelanggan.required' => 'Nama pelanggan wajib dipilih',
            'pelanggan.exists' => 'Nama pelanggan tidak ditemukan',

            'lokasi.required' => 'Tempat/Lokasi tidak ditemukan',
            'lokasi.in' => 'Tempat/Lokasi tidak ditemukan',
            'lokasi.string' => 'Tempat/Lokasi tidak ditemukan',
            'tujuan.required' => 'Tujuan wajib dipilih',
            'tujuan.string' => 'Tujuan tidak sesuai',
            'tujuan.in' => 'Tujuan tidak sesuai yang ditentukan',

            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal adalah 1.',

            'satuan.required' => 'Satuan wajib di pilih.',
            'satuan.string' => 'Satuan harus berupa karakter yang sesuai.',

            'petugas.required' => 'Nama petugas wajib dibuat',
            'petugas.string' => 'Nama petugas tidak sesuai',
            'petugas.max' => 'Nama petugas maksimal 50 karakter',


            'keterangan.string' => 'karakter yang digunakan tidak sesuai.',
            'keterangan.max' => 'Keterangan maksimal 250 karakter.',

            'kode_keluar.required' => 'Kode barang keluar wajib diisi.',
            'kode_keluar.string' => 'Kode barang keluar tidak sesuai.',
            'kode_keluar.max' => 'Kode barang keluar maksimal 25 karakter.',
        ])->validate();
    }
}
