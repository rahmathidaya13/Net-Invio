<?php

namespace App\Traits\validate;

use Illuminate\Support\Facades\Validator;


trait ItemValidation
{
    public function validateItem($request)
    {
        return Validator::make($request, [
            // 'kode_barang' => 'required|string|max:50',
            'sn' => 'nullable|string|max:50',
            'nama_barang' => 'required|string|max:50',
            'jenis_barang' => 'required|string|max:50',
            'merek' => 'required|string|max:50',
            'model' => 'nullable|string|max:50',
            'satuan' => 'required|string|max:20',
            'keterangan' => 'nullable|string',
        ], [
            'kode_barang.required' => 'Kode barang wajib di isi.',
            'kode_barang.string' => 'Kode barang harus berupa karakter yang sesuai.',
            'kode_barang.max' => 'Kode barang maksimal 50 karakter',

            'sn.string' => 'Serial number harus berupa karakter yang sesuai.',
            'sn.max' => 'Serial number maksimal 50 karakter.',

            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.string' => 'Nama barang harus berupa karakter yang sesuai.',
            'nama_barang.max' => 'Nama barang maksimal 50 karakter',

            'jenis_barang.required' => 'Jenis barang wajib diisi.',
            'jenis_barang.string' => 'Jenis barang harus berupa karakter yang sesuai.',
            'jenis_barang.max' => 'Jenis barang maksimal 50 karakter',

            'merek.required' => 'Merek barang wajib diisi.',
            'merek.string' => 'Merek barang harus berupa karakter yang sesuai.',
            'merek.max' => 'Merek barang maksimal 50 karakter',

            'model.string' => 'Tipe model harus berupa karakter yang sesuai.',
            'model.max' => 'Tipe model maksimal 50 karakter',

            'satuan.required' => 'Satuan wajib di pilih.',
            'satuan.string' => 'Satuan harus berupa karakter yang sesuai.',
            'satuan.max' => 'Satuan maksimal 20 karakter',

            'keterangan.string' => 'Keterangan harus berupa karakter yang sesuai.',

        ])->validate();
    }
}
