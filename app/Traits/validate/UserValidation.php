<?php

namespace App\Traits\validate;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

trait UserValidation
{
    public function validationUpdate($request, $id = null)
    {
        return Validator::make(
            $request,
            [
                'name' => 'required|string|max:50',
                'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')->ignore($id, 'id')],
                'password' => ['nullable', 'confirmed', 'string', 'min:6'],
                'password_confirmation' => ['nullable', 'string', 'min:6', 'same:password'],
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'name.string' => 'Nama harus menggunakan karakter yang sesuai.',
                'name.min' => 'Nama maksimal 50 karakter',

                'email.min' => 'Email maksimal 50 karakter',
                'email.required' => 'Email wajib diisi.',
                'email.unique' => 'Email sudah terdaftar.',

                'password.confirmed' => 'Password confirm tidak sesuai.',
                'password.string' => 'Password harus menggunakan karakter yang sesuai.',
                'password.min' => 'Password minimal 6 karakter',

                'password_confirmation.string' => 'Password harus menggunakan karakter yang sesuai.',
                'password_confirmation.min' => 'Password minimal 6 karakter.',
            ]
        )->validate();
    }
    public function validationSave($request)
    {
        return Validator::make(
            $request,
            [
                'name' => 'required|string|max:50',
                'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
                'password' => ['required', 'confirmed', 'string', 'min:6'],
                'password_confirmation' => ['required', 'string', 'min:6', 'same:password'],
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'name.string' => 'Nama harus menggunakan karakter yang sesuai.',
                'name.min' => 'Nama maksimal 50 karakter',

                'email.min' => 'Email maksimal 50 karakter',
                'email.required' => 'Email wajib diisi.',
                'email.unique' => 'Email sudah terdaftar.',

                'password.required' => 'Kata sandi wajib diisi.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
                'password.string' => 'Kata sandi harus menggunakan karakter yang sesuai.',
                'password.min' => 'Kata sandi minimal 6 karakter',

                'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
                'password_confirmation.string' => 'Konfirmasi kata sandi harus menggunakan karakter yang sesuai.',
                'password_confirmation.min' => 'konfirmasi kata sandi minimal 6 karakter.',
                'password_confirmation.same'=> 'Konfirmasi kata sandi harus sesuai dangan kata sandi.',
            ]
        )->validate();
    }
}
