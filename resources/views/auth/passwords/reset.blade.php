@include('layouts.header')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h4 class="mb-0">{{ __('🔐 Reset Password') }}</h4>
                </div>

                <div class="card-body p-4">

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Alamat Email') }}</label>
                            <input id="email" type="email"
                                   class="form-control rounded-3 @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ $email ?? old('email') }}"
                                   required autofocus autocomplete="email">

                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password Baru') }}</label>
                            <input id="password" type="password"
                                   class="form-control rounded-3 @error('password') is-invalid @enderror"
                                   name="password"
                                   required autocomplete="new-password">

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">{{ __('Konfirmasi Password') }}</label>
                            <input id="password-confirm" type="password"
                                   class="form-control rounded-3"
                                   name="password_confirmation"
                                   required autocomplete="new-password">
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3">
                                {{ __('🔄 Reset Password Sekarang') }}
                            </button>
                        </div>

                        {{-- Link kembali ke login --}}
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                ← Kembali ke halaman login
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@include('layouts.footer')
