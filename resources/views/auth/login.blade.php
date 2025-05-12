@section('title', 'Login')
@include('layouts.header')
<div class="container py-5">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8 col-12 align-items-center">
            @if ($errors->has('error'))
                <x-alert type="danger" message="{{ $errors->first('error') }}" />
            @endif
            {{-- overflow-hidden di .card mencegah elemen anak seperti  keluar dari batasnya. --}}
            <div class="card text-bg-light overflow-hidden shadow">
                <div class="row g-0">
                    <div class="col-xl-6 d-none d-xl-block position-relative">
                        {{-- rounded-start memastikan gambar ikut border radius kiri dari card. --}}
                        {{-- h-100 dan w-100 + object-fit-cover membuat gambar menyesuaikan ukuran secara baik. --}}
                        <img class="img-login object-fit-cover rounded-start border-end"
                            src="{{ asset('assets/image/image-login2.jpeg') }}" alt="">

                        {{-- Overlay gradient hitam di atas --}}
                        {{-- <div class="gradient-overlay">
                        </div> --}}
                        <div class="gradient-top"></div>

                        <div class="gradient-bottom"></div>

                        <div class="card-img-overlay  p-3 title-overlay">
                            <h5 class="card-title text-uppercase fw-bold fs-2 text-white app_title mt-2">
                                Net-invio
                            </h5>
                            <p class="text-white small text-capitalize lh-sm">
                                <em>
                                    Pantau jumlah stok dan kelola data barang dengan lebih efisien secara real-time
                                </em>
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 p-4 pt-5 d-flex flex-column ">
                        <div class="text-center mb-3">
                            <h1 class="fw-bold text-uppercase">Login</h1>
                        </div>
                        <x-form url="/login">
                            <div class="mb-3">
                                <x-form-label for="email" value="Email" />
                                <div class="input-group">
                                    <span class="input-group-text rounded-0"> <i class="bi bi-envelope-at-fill"
                                            id="showPass"></i>
                                    </span>
                                    <x-form-input placeholder="example@mail.com" name="email" type="email"
                                        value="{{ old('email') }}" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <x-form-label for="password" value="Password" />
                                <div class="input-group">
                                    <span class="input-group-text rounded-0"> <i class="bi bi-file-lock2-fill "></i>
                                    </span>
                                    <input placeholder="*******" type="password"
                                        class="form-control @error('password')
                                        is-invalid
                                    @enderror"
                                        name="password" id="password" value="{{ old('password') }}">
                                    <span class="input-group-text rounded-0"> <i class="bi bi-eye-fill rounded-0"
                                            id="showPass" style="cursor: pointer"></i>
                                    </span>
                                    @error('password')
                                        <div class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-grid mb-3">
                                <x-base-button label="Login" variant="success" class="rounded-0" type="submit" />
                            </div>
                        </x-form>

                        <footer class="pt-4 bg-light mt-5">
                            <div class="container-fluid px-4">
                                <div
                                    class="d-flex justify-content-between align-items-center flex-column small text-muted footer-custom">
                                    <strong class="footer-name-app text-uppercase small">Net-Invio</strong>
                                    <span class="footer-version small-sm">Version 0.0.1</span>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
