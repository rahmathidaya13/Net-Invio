<?php

namespace App\Traits\validate;

use Illuminate\Support\Facades\Validator;

trait pelangganValidation
{
    public function validationText($request, $id = null)
    {
        return Validator::make($request, [
            'nid' => 'required|string|max:25',
            'tanggal' => 'required|date|before:tomorrow',
            'nama_pelanggan' => 'required|string|max:50',
            'jk' => 'required|in:laki-laki,perempuan',
            'nohp' => 'required|digits_between:10,13|regex:/^08[0-9]{8,11}$/',
            'email' => 'nullable|email|max:50|unique:tb_pelanggan,email,' . $id . ',id_pelanggan',
            'alamat' => 'required|string|max:150',
        ], [
            'nid.required' => 'Nomor identitas wajib diisi.',
            'nid.max' => 'Nomor identitas maksimal 25 karakter.',
            'nid.string' => 'Nomor identitas harus menggunakan karakter yang sesuai',

            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'tanggal.before' => 'Tanggal tidak boleh melebihi hari ini.',

            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'nama_pelanggan.max' => 'Nama maksimal 50 karakter.',
            'nama_pelanggan.string' => 'Nama harus menggunakan karakter yang sesuai',

            'jk.required' => 'Jenis kelamin wajib dipilih.',
            'jk.in' => 'Jenis kelamin harus laki-laki atau perempuan.',

            'nohp.required' => 'Nomor handphone wajib diisi.',
            'nohp.digits_between' => 'Nomor handphone harus antara 10 hingga 13 digit.',
            'nohp.regex' => 'Nomor handphone harus diawali dengan 08 dan hanya angka.',

            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 50 karakter.',
            'email.unique' => 'Email sudah digunakan sudah terdaftar',

            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 150 karakter.',
            'alamat.string' => 'Alamat harus menggunakan karakter yang sesuai',
        ])->validate();
    }
}
