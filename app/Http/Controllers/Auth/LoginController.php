<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Cari user berdasarkan email yang diinputkan.
        $user = User::where("email", $request->input("email"))->first();

        // Menggunakan Hash::check() untuk membandingkan password yang di-hash di database.
        // Mencegah error saat email tidak ditemukan.
        // Langsung login jika email & password cocok.
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['error' => 'Email atau password salah.']);
        }
        Auth::login($user);
        if (!$user->isActive) {
            $user->isActive = true;
            $user->save();
        }
        return redirect()->route('home');
    }
    protected function validateLogin(Request $request)
    {
        $this->checkRateLimit($request); // Memeriksa batas percobaan login
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|max:50',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar di sistem.',

            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa karakter yang valid.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.max' => 'Password maksimal 50 karakter.',
        ]);
    }

    // Membatasi 5 kali percobaan login per menit.
    // Jika gagal lebih dari 5 kali, pengguna harus menunggu.
    // Mencegah serangan brute force.
    // Fungsi untuk membatasi percobaan login
    protected function checkRateLimit(Request $request)
    {
        $key = 'login_attempts:' . Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'error' => ['Terlalu banyak percobaan login. Silakan coba lagi dalam beberapa menit.'],
            ]);
        }

        RateLimiter::hit($key, 60); // Reset percobaan dalam 1 menit
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user->isActive) {
            $user->isActive = false;
            $user->save();
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
