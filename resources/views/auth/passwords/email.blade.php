@section('title', 'Password Forget')
@include('layouts.header')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            @if ($message = Session::get('status'))
                <x-alert type="success" :message="$message" />
            @endif

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h4 class="mb-0">🔒 Reset Password</h4>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted text-center mb-4">
                        Masukkan email yang terdaftar, kami akan mengirimkan link untuk reset password.
                    </p>
                    <x-form url="/password/email">
                        <div class="mb-3">
                            <x-form-label for="email" :value="__('Email')" />
                            <x-form-input class="rounded-3" name="email" type="email" :value="old('email')" autofocus
                                autocomplete="email" />
                        </div>
                        <div class="d-grid mt-4">
                            <x-base-button class="btn-lg rounded-3" :label="__('📩 Kirim Link Reset Password')" />
                        </div>
                        <div class="mt-4 text-center">
                            <x-link url="/login" class="text-decoration-none" :label="__('← Kembali ke halaman login')" />
                        </div>
                    </x-form>
                </div>
            </div>

        </div>
    </div>
</div>

@include('layouts.footer')
