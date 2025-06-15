<?php

namespace App\Traits\validate;

use Illuminate\Support\Facades\Validator;

trait ReturValidation
{
    public function validationText($request)
    {
        return Validator::make($request, [
            "tanggal" => "required|date",
            "kode_retur" => "required|string|max:50",
            "barang" => "required|exists:tb_barang,id_barang",
            "pelanggan" => "nullable|exists:tb_pelanggan,id_pelanggan",
            "supplier" => "nullable|exists:tb_supplier,id_supplier",
            "jumlah" => "required|integer|min:1",
            "tipe_retur" => "required|string|in:masuk,keluar",
            "status" => "required|string|in:diganti,tidak_diganti,diperbaiki",
            "alasan" => "required|string",
            "gambar.*" => "image|mimes:jpeg,png,jpg|max:2048",
        ], [
            "tanggal.required" => "Tanggal wajib diisi.",
            "tanggal.date" => "Tanggal tidak valid.",

            "kode_retur.required" => "Kode retur wajib diisi.",
            "kode_retur.string" => "Kode retur tidak valid",
            "kode_retur.max" => "Kode retur maksimal 50 karakter",

            "barang.required" => "Barang wajib dipilih.",
            "barang.exists" => "Barang yang dipilih tidak terdaftar",

            "pelanggan.exists" => "Pelanggan yang dipilih tidak terdaftar",

            "supplier.exists" => "Supplier yang dipilih tidak terdaftar",

            "jumlah.required" => "Jumlah retur wajib diisi.",
            "jumlah.integer" => "Jumlah yang diinput harus berupa angka.",
            "jumlah.min" => "Jumlah yang diinput minimal 1",

            "tipe_retur.required" => "Tipe retur barang wajib dipilih",
            "tipe_retur.string" => "Tipe retur barang tidak valid",
            "tipe_retur.in" => "Tipe retur barang yang dipilih tidak sesuai",

            "status.required" => "Status retur wajib dipilih.",
            "status.string" => "Status retur yang dipilih tidak valid",
            "status.in" => "Status retur yang dipilih tidak sesuai",

            "alasan.required" => "Alasan wajib diisi.",
            "alasan.string" => "Alasan yang diinput tidak sesuai.",

            "gambar.image" => "Format file harus berupa gambar.",
            "gambar.mimes" => "Gambar yang didukung adalah jpeg,png,jpg.",
            "gambar.max" => "Gambar yang diupload tidak lebih dari 2mb.",
        ])->validate();
    }
}
