<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark sb-s" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav ">
                <div class="sb-sidenav-menu-heading">Features</div>
                <x-link class="nav-link {{ request()->is('home*') ? 'active bg-success' : 'collapsed' }}"
                    url="{{ route('home') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </x-link>

                {{-- komponen pelanggan --}}
                <x-link class="nav-link {{ request()->is('user*') ? 'active text-bg-success' : 'collapsed' }}"
                    data-bs-toggle="collapse" data-bs-target="#collapseLayoutsCus" aria-expanded="false"
                    aria-controls="collapseLayoutsCus">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                    User
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </x-link>
                <div class="{{ request()->segment(1) === 'user' ? 'show' : 'collapse' }}" id="collapseLayoutsCus"
                    aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <x-link label="Daftar Pengguna" url="{{ route('user.list') }}" icon="fas fa-id-badge me-2"
                            class="nav-link {{ request()->is('user/list') ? 'active nav-sub-link' : '' }}" />
                        <x-link label="Tambah Pengguna" url="{{ route('create.user') }}" icon="fas fa-plus-square me-2"
                            class="nav-link {{ request()->is('user/create') ? 'active nav-sub-link' : '' }}" />
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Settings</div>
                <x-link class="nav-link" id="logout">
                    <div class="sb-nav-link-icon"><i class="fas fa-arrow-circle-left"></i></div>
                    Keluar
                    <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </x-link>
            </div>
        </div>
    </nav>
</div>
