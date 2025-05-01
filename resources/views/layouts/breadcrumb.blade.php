<div class="pagetitle">
    <nav class="d-lg-flex flex flex-wrap flex-row flex-col justify-content-between align-items-center py-3">
        <h3 class="fw-bold"><i class="@yield('icon')"></i> <span>@yield('text')</span> @yield('breadcrumb')</h3>
        <ol class="breadcrumb">
            @if (Request::is('home'))
                <li class="breadcrumb-item"><x-link class="btn btn-primary btn-sm" label="Home" />
                </li>
            @endif
            @if (Request::is(['user/create', 'user/edit*']))
                <li class="breadcrumb-item">
                    <x-link label="Kembali" icon="bi bi-arrow-left-circle" class="btn btn-danger btn-sm"
                        url="{{ route('user.list') }}" />
                </li>
            @endif

        </ol>
    </nav>
</div>
