@section('title', 'Login')
@include('layouts.header')
<div class="container py-5">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-4 col-12 align-items-center">
            @if ($errors->has('error'))
                <x-alert type="danger" message="{{ $errors->first('error') }}" />
            @endif
            <x-card class="shadow-sm" headerClass="bg-light border-0" title="Login"
                bodyClass="text-bg-light shadow-sm border border-light"
                titleClass="text-center fw-bold fs-1 text-uppercase p-2">
                <x-form url="/login">
                    <div class="mb-3">
                        <x-form-label for="email" value="Email" />
                        <x-input-group iconLeft="bi bi-envelope-at-fill" name="email" type="email"
                            value="{{ old('email') }}" />
                    </div>
                    <div class="mb-3">
                        <x-form-label for="password" value="Password" />
                        <x-input-group iconLeft="bi bi-file-lock2-fill" iconRight="bi bi-eye-fill" name="password"
                            type="password" value="{{ old('password') }}" />
                    </div>
                    <div class="d-grid mb-3">
                        <x-base-button label="Login" variant="success" class="rounded-0" type="submit" />
                    </div>
                </x-form>
            </x-card>
        </div>
    </div>
</div>
@include('layouts.footer')
