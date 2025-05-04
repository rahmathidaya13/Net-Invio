<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark sb-s" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav ">
                <div class="sb-sidenav-menu-heading">Features</div>
                <x-link class="nav-link {{ request()->is('home*') ? 'active bg-success' : 'collapsed' }}" url="/home">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </x-link>

                {{-- side barang --}}
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

                        @php
                            $uuidBarang = Request::segment(3);
                        @endphp
                        @if (Request::is('barang/edit*'))
                            <x-link label="Ubah Barang" url="/barang/edit" parameters="{{ $uuidBarang }}"
                                icon="far fa-circle me-2"
                                class="nav-link {{ request()->is('barang/edit*') ? 'active nav-sub-link' : '' }}" />
                        @endif
                    </nav>
                </div>
                {{-- end side barang --}}


                {{-- side pelanggan --}}
                <x-link class="nav-link {{ request()->is('pelanggan*') ? 'active text-bg-success' : 'collapsed' }}"
                    data-bs-toggle="collapse" data-bs-target="#collapseLayoutsPLG" aria-expanded="false"
                    aria-controls="collapseLayoutsCus">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Data Pelanggan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </x-link>
                <div class="{{ request()->segment(1) === 'pelanggan' ? 'show' : 'collapse' }}" id="collapseLayoutsPLG"
                    aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <x-link label="Daftar Pelanggan" url="/pelanggan/list" icon="far fa-circle me-2"
                            class="nav-link {{ request()->is('pelanggan/list') ? 'active nav-sub-link' : '' }}" />
                        <x-link label="Tambah Pelanggan" url="/pelanggan/create" icon="far fa-circle me-2"
                            class="nav-link {{ request()->is('pelanggan/create') ? 'active nav-sub-link' : '' }}" />

                        @php
                            $uuidPelanggan = Request::segment(3);
                        @endphp
                        @if (Request::is('pelanggan/edit*'))
                            <x-link label="Ubah Pelanggan" url="/pelanggan/edit" parameters="{{ $uuidPelanggan }}"
                                icon="far fa-circle me-2"
                                class="nav-link {{ request()->is('pelanggan/edit*') ? 'active nav-sub-link' : '' }}" />
                        @endif
                    </nav>
                </div>
                {{-- end side pelanggan --}}

                {{-- side supplier --}}
                <x-link class="nav-link {{ request()->is('supplier*') ? 'active text-bg-success' : 'collapsed' }}"
                    data-bs-toggle="collapse" data-bs-target="#collapseLayoutsSPL" aria-expanded="false"
                    aria-controls="collapseLayoutsCus">
                    <div class="sb-nav-link-icon"><i class="bi bi-people-fill"></i></div>
                    Data Supplier
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </x-link>
                <div class="{{ request()->segment(1) === 'supplier' ? 'show' : 'collapse' }}" id="collapseLayoutsSPL"
                    aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <x-link label="Daftar Supplier" url="/supplier/list" icon="far fa-circle me-2"
                            class="nav-link {{ request()->is('supplier/list') ? 'active nav-sub-link' : '' }}" />
                        <x-link label="Tambah Supplier" url="/supplier/create" icon="far fa-circle me-2"
                            class="nav-link {{ request()->is('supplier/create') ? 'active nav-sub-link' : '' }}" />

                        @php
                            $uuidSupplier = Request::segment(3);
                        @endphp
                        @if (Request::is('supplier/edit*'))
                            <x-link label="Ubah Pelanggan" url="/supplier/edit" parameters="{{ $uuidSupplier }}"
                                icon="far fa-circle me-2"
                                class="nav-link {{ request()->is('supplier/edit*') ? 'active nav-sub-link' : '' }}" />
                        @endif
                    </nav>
                </div>
                {{-- end side supplier --}}

                {{-- side supplier --}}
                <x-link class="nav-link {{ request()->is('stok*') ? 'active text-bg-success' : 'collapsed' }}"
                    data-bs-toggle="collapse" data-bs-target="#collapseLayoutsSTOK" aria-expanded="false"
                    aria-controls="collapseLayoutsCus">
                    <div class="sb-nav-link-icon"><i class="bi bi-clipboard"></i></div>
                    Data Stok
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </x-link>
                <div class="{{ request()->segment(1) === 'stok' ? 'show' : 'collapse' }}" id="collapseLayoutsSTOK"
                    aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <x-link label="Daftar Stok" url="/stok/list" icon="far fa-circle me-2"
                            class="nav-link {{ request()->is('stok/list') ? 'active nav-sub-link' : '' }}" />
                        <x-link label="Tambah Stok" url="/stok/create" icon="far fa-circle me-2"
                            class="nav-link {{ request()->is('stok/create') ? 'active nav-sub-link' : '' }}" />

                        @php
                            $uuidStok = Request::segment(3);
                        @endphp
                        @if (Request::is('stok/edit*'))
                            <x-link label="Ubah Stok Barang" url="/stok/edit" parameters="{{ $uuidStok }}"
                                icon="far fa-circle me-2"
                                class="nav-link {{ request()->is('stok/edit*') ? 'active nav-sub-link' : '' }}" />
                        @endif
                    </nav>
                </div>
                {{-- end side supplier --}}


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
