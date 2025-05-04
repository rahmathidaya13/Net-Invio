<?php

namespace App\Traits\Validate;

use Illuminate\Support\Facades\Validator;

trait supplierValidation
{
    public function validationText($request, $id = null)
    {
        return Validator::make($request, [
            'nama_supplier' => 'required|string|max:50',
            'kontak' => 'required|digits_between:10,13|regex:/^08[0-9]{8,11}$/',
            'email' => 'nullable|email|max:50|unique:tb_supplier,email,' . $id . ',id_supplier',
            'alamat' => 'required|string|max:200',
        ], [

            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.max' => 'Nama supplier maksimal 50 karakter.',
            'nama_supplier.string' => 'Nama supplier harus menggunakan karakter yang sesuai',

            'kontak.required' => 'Kontak supplier wajib diisi.',
            'kontak.digits_between' => 'Kontak supplier harus antara 10 hingga 13 digit.',
            'kontak.regex' => 'Kontak supplier harus diawali dengan 08 dan hanya angka.',

            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 50 karakter.',
            'email.unique' => 'Email sudah digunakan sudah terdaftar',

            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 200 karakter.',
            'alamat.string' => 'Alamat harus menggunakan karakter yang sesuai',
        ])->validate();
    }
}
