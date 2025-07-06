<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        session(['google_login_started' => true]);
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        if (!session()->pull('google_login_started')) {
            return redirect('/login')->with('error', 'Akses login Google tidak sah.');
        }

        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::firstOrCreate(['email' => $googleUser->getEmail()], [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'password' => bcrypt(Str::random(26)),
            'email_verified_at' => now()->toDateTimeString(),
            'can_download' => true,
        ]);
        $user->profile()->create();

        // Jika google_id belum tersimpan, update (untuk user lama)
        if (!$user->google_id) {
            $user->update([
                'google_id' => $googleUser->getId(),
            ]);
        }

        // update status user online
        $user->update([
            'isActive' => true,
        ]);
        Auth::login($user);
        return redirect()->intended('/home');
    }
}
