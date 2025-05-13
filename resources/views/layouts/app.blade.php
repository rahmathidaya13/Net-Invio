@include('layouts.header')
@include('layouts.navbar')
<div id="layoutSidenav">
    @include('layouts.sidebar')
    <div id="layoutSidenav_content">
        {{-- loader splash --}}
        <div class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <main>
            <div class="container-fluid px-4">
                {{-- @include('layouts.breadcrumb') --}}
                @yield('content')
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; {{ \Carbon\Carbon::now()->format('Y') }} <a
                            class="text-decoration-none" href="{{ route('home') }}">Net-Invio</a> </div>
                    <div>
                        <b class="text-muted">Version 0.0.1</b>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
@include('layouts.footer')
