<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark sb-s" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav ">
                <div class="sb-sidenav-menu-heading">Features</div>
                <x-link class="nav-link {{ request()->is('home*') ? 'active bg-success' : 'collapsed' }}" url="/home">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </x-link>

                {{-- <x-link class="nav-link {{ request()->is('barang*') ? 'active bg-success' : 'collapsed' }}"
                    url="/barang/list">
                    <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                    Daftar Barang
                </x-link> --}}

                <x-link class="nav-link {{ request()->is('barang*') ? 'active text-bg-success' : 'collapsed' }}"
                    data-bs-toggle="collapse" data-bs-target="#collapseLayoutsItm" aria-expanded="false"
                    aria-controls="collapseLayoutsCus">
                    <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                    Data Barang
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </x-link>
                <div class="{{ request()->segment(1) === 'barang' ? 'show' : 'collapse' }}" id="collapseLayoutsItm"
                    aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <x-link label="Daftar Barang" url="/barang/list" icon="far fa-circle me-2"
                            class="nav-link {{ request()->is('barang/list') ? 'active nav-sub-link' : '' }}" />
                        <x-link label="Tambah Barang" url="/barang/create" icon="far fa-circle me-2"
                            class="nav-link {{ request()->is('barang/create') ? 'active nav-sub-link' : '' }}" />
                    </nav>
                </div>

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
                        <x-link label="Daftar Pengguna" url="/user/list" icon="fas fa-id-badge me-2"
                            class="nav-link {{ request()->is('user/list') ? 'active nav-sub-link' : '' }}" />
                        <x-link label="Tambah Pengguna" url="/user/create" icon="fas fa-plus-square me-2"
                            class="nav-link {{ request()->is('user/create') ? 'active nav-sub-link' : '' }}" />
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Settings</div>
                <x-link class="nav-link" id="logout">
                    <div class="sb-nav-link-icon"><i class="fas fa-arrow-circle-left"></i></div>
                    Keluar
                    <x-form url="/logout" id="logout-form" class="d-none" />
                </x-link>
            </div>
        </div>
    </nav>
</div>
