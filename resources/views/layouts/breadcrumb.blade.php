<div class="pagetitle">
    <nav style="--bs-breadcrumb-divider: '>';"
        class="d-lg-flex flex flex-wrap flex-row flex-col justify-content-between align-items-center py-3">
        {{-- title --}}
        <h3 class="fw-bold"><i class="@yield('icon')"></i> <span>@yield('text')</span> @yield('breadcrumb')</h3>

        <ol class="breadcrumb align-items-center">

            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Library</li>

        </ol>

    </nav>
</div>
