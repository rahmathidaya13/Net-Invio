@include('layouts.header')
@include('layouts.navbar')
<div id="layoutSidenav">
    @include('layouts.sidebar')
    <div id="layoutSidenav_content">
        {{-- effect loading --}}
        {{-- <div id="loading">
            <div class="lds-ellipsis">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div> --}}
        <div class="loader-wrapper">
            <div class="loader"></div>
        </div>

        {{-- end effect --}}
        <main>
            <div class="container-fluid px-4">
                {{-- @include('layouts.breadcrumb') --}}
                @yield('content')
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; 2025 <a class="text-decoration-none"
                            href="{{ route('home') }}">Net-Invio</a> </div>
                    <div>
                        <b class="text-muted">Version 1.0.0</b>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
@include('layouts.footer')
