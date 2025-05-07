<?php

namespace App\Traits\validate;

use Illuminate\Support\Facades\Validator;

trait ReceivingValidate
{
    public function validateReceiving($request, $isUpdated = false)
    {
        $rules = [
            'supplier' => 'nullable|exists:tb_supplier,id_supplier',
            'tanggal' => 'required|date|in:' . now()->toDateString(),
            'sumber' => 'required|string|in:internal,supplier',
            'pembeli' => 'nullable|string|max:50',
            'nota' => 'required|string|max:50',
            'jumlah' => 'required|integer|min:1',
            'harga_brg' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:250',
        ];
        if (!$isUpdated) {
            $rules['nama_barang'] = 'required|exists:tb_barang,id_barang';
            $rules['lokasi'] = ['required', 'string', 'max:50', 'regex:/^[\pL\s\-0-9,\.]+$/u'];
        }
        return Validator::make($request, $rules, [
            'nama_barang.required' => 'Nama Barang wajib dipilih.',
            'nama_barang.exists' => 'Nama Barang tidak ditemukan.',

            'supplier.exists' => 'Supplier tidak ditemukan.',

            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal tidak valid.',
            'tanggal.in' => 'Tanggal hanya boleh diisi dengan hari ini.',

            'sumber.required' => 'Sumber pembelian wajib dipilih.',
            'sumber.string' => 'Sumber pembelian tidak valid.',
            'sumber.in' => 'Sumber pembelian tidak valid.',

            'pembeli.string' => 'Pembeli tidak valid.',
            'pembeli.max' => 'Pembeli tidak valid.',

            'nota.required' => 'Nota wajib diisi.',
            'nota.string' => 'Nota tidak valid.',
            'nota.max' => 'Nota maksimal 50 karakter.',

            'jumlah.required' => 'Jumlah barang wajib diisi.',
            'jumlah.integer' => 'Jumlah barang tidak valid.',
            'jumlah.min' => 'Jumlah barang minimal 1.',

            'harga_brg.required' => 'Harga barang wajib diisi.',
            'harga_brg.numeric' => 'Harga barang tidak valid.',
            'harga_brg.min' => 'Harga barang tidak valid.',

            'lokasi.required' => 'Lokasi/tempat wajib dipilih.',
            'lokasi.string' => 'Lokasi/tempat tidak valid.',
            'lokasi.max' => 'Lokasi/tempat maksimal 50 karakter.',
            'lokasi.regex' => 'Karakter yang digunakan tidak sesuai.',

            'keterangan.string' => 'Keterangan tidak valid.',
            'keterangan.max' => 'Keterangan maksimal 250 karakter.',
        ])->validate();
    }
}
