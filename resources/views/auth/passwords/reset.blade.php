@include('layouts.header')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if ($message = Session::get('status'))
                <x-alert type="success" :message="$message" />
            @endif
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h4 class="mb-0">{{ __("🔐 Reset Password") }}</h4>
                </div>

                <div class="card-body p-4">
                    <x-form url="/password/reset">
                        <x-form-input name="token" :value="$token" type="hidden" />
                        <div class="mb-3">
                            <x-form-label for="email" :value="__('Alamat Email')" />
                            <x-form-input class="rounded-3" type="email" name="email" :value="$email ?? old('email')" autofocus
                                autocomplete="email" />
                        </div>
                        <div class="mb-3">
                            <x-form-label for="password" :value="__('Password Baru')" />
                            <x-form-input class="rounded-3" type="password" name="password"
                                autocomplete="new-password" />
                        </div>
                        <div class="mb-3">
                            <x-form-label for="password-confirm" :value="__('Konfirmasi Password')" />
                            <x-form-input class="rounded-3" type="password" name="password_confirmation"
                                autocomplete="new-password" />
                        </div>

                        <div class="d-grid">
                            <x-base-button :label="__('🔄 Reset Password Sekarang')" class="rounded-3 btn-lg" />
                        </div>

                        <div class="text-center mt-3">
                            <x-link url="/login" class="text-decoration-none" :label="__('← Kembali ke halaman login')" />
                        </div>
                    </x-form>
                </div>
            </div>

        </div>
    </div>
</div>

@include('layouts.footer')
