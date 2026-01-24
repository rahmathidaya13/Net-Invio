<?php

namespace App\Http\Controllers;

use App\Models\ProfileModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(string $id)
    {
        $user = User::findOrFail($id);
        return view('Profile.index', compact('user'));
    }

    public function update(Request $request, string $id)
    {

        $request->validate([
            'phone'     => ['nullable', 'string', 'max:13'],
            'address'   => ['nullable', 'string', 'max:250'],
            'gender'    => ['nullable', 'in:laki-laki,perempuan'],
            'birthdate' => ['nullable', 'date', 'before_or_equal:today'],
            'position'  => ['nullable', 'string', 'max:50'],
            'pic_profile'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // max: 2MB
        ], [
            'phone.max'                => 'Nomor HP maksimal 13 karakter.',
            'address.max'              => 'Alamat maksimal 250 karakter.',
            'gender.in'                => 'Jenis kelamin harus salah satu dari: laki-laki, perempuan.',
            'birthdate.date'           => 'Format tanggal lahir tidak valid.',
            'birthdate.before_or_equal' => 'Tanggal lahir tidak boleh di masa depan.',
            'position.max'             => 'Jabatan/posisi maksimal 50 karakter.',
            'pic_profile.image'              => 'File yang diunggah harus berupa gambar.',
            'pic_profile.mimes'              => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'pic_profile.max'                => 'Ukuran gambar maksimal 2MB.',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if ($request->hasFile('pic_profile')) {
            $file = $request->file('pic_profile');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/profile'), $fileName);

            if ($user->profile->image) {
                $old = public_path('assets/profile/' . $user->profile->image);
                if (file_exists($old)) {
                    unlink($old);
                }
            }
        }

        auth()->user()->profile->update([
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
            'birthdate' => $request->input('birthdate'),
            'position' => $request->input('position'),
            'image' => $fileName ?? $user->profile->image,
        ]);
        return back()->with('success', 'Profile updated successfully');
    }
}
