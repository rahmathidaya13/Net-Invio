@section('title', 'Login')
@include('layouts.header')
<div class="container py-5">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-4 col-12 align-items-center">

            {{-- <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                    <img src="assets/img/logo.png" alt="">
                    <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
            </div> --}}
            @if ($errors->has('error'))
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle text-white mr-2"></i>
                    <small> {{ $errors->first('error') }}</small>
                </div>
            @endif

            <div class="card mb-3">

                <div class="card-body text-bg-light shadow-sm border border-light">

                    <div class="pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-3 text-uppercase fw-bold">@yield('title')</h5>
                    </div>

                    <form role="form" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-0" id="basic-addon1"><i
                                        class="bi bi-envelope-at-fill"></i></span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control @error('email')
                                    is-invalid
                                @enderror "
                                    id="email">
                                @error('email')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-0" id="basic-addon1"><i
                                        class="bi bi-file-lock2-fill"></i></span>
                                <input type="password" name="password" id="password" value="{{ old('password') }}"
                                    class="form-control @error('password')
                                    is-invalid
                                @enderror"
                                    id="password">
                                <span class="input-group-text rounded-0" id="basic-addon1"><i class="bi bi-eye-fill"
                                        id="showPass" style="cursor: pointer"></i></span>
                                @error('password')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-grid mb-3">
                            <button class="btn btn-success rounded-0" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
