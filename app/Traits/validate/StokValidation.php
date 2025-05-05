<?php

namespace App\Traits\validate;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

trait StokValidation
{
    public function validationText($request, $id = null)
    {
        return Validator::make($request, [
            'nama_barang' => [
                'required',
                'uuid',
                Rule::exists('tb_barang', 'id_barang') // memastikan ID barang valid
            ],
            'tanggal' => [
                'required',
                'date',
                'in:' . now()->toDateString(), // tidak boleh lebih dari hari ini
            ],
            'jumlah' => [
                'required',
                'integer',
                'min:1',
            ],
            'lokasi' => [
                'required',
                'string',
                'max:50',
                'regex:/^[\pL\s\-0-9,\.]+$/u' // hanya huruf, angka, spasi, koma, titik
            ],
            ['keterangan' => 'required|string|max:200'],
        ], [
            'nama_barang.required' => 'Nama barang wajib dipilih.',
            'nama_barang.uuid' => 'Format barang tidak valid.',

            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal adalah 1.',

            'lokasi.required' => 'Lokasi wajib diisi.',
            'lokasi.string' => 'Format lokasi tidak valid.',
            'lokasi.max' => 'Karakter yang digunakan tidak sesuai.',
            'lokasi.regex' => 'Karakter yang digunakan huruf dan angka',

            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'tanggal.in' => 'Tanggal hanya boleh diisi dengan hari ini.',

            'keterangan.string' => 'karakter yang digunakan tidak sesuai.',
            'keterangan.max' => 'Keterangan maksimal 200 karakter.',

        ])->validate();
    }
}
