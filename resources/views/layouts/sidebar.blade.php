<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark sb-s" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Features</div>
                <x-link class="nav-link {{ request()->is('home*') ? 'active text-bg-primary' : '' }}" url="/home">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </x-link>

                {{-- side barang --}}
                <x-link url="/barang/list"
                    class="nav-link {{ request()->is('barang*') ? 'active text-bg-primary' : '' }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                    Data Barang
                </x-link>

                {{-- end side barang --}}


                {{-- side pelanggan --}}
                <x-link url="/pelanggan/list"
                    class="nav-link {{ request()->is('pelanggan*') ? 'active text-bg-primary' : '' }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Data Pelanggan
                </x-link>
                {{-- end side pelanggan --}}

                {{-- side supplier --}}
                <x-link url="/supplier/list"
                    class="nav-link {{ request()->is('supplier*') ? 'active text-bg-primary' : '' }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-people-fill"></i></div>
                    Data Supplier
                </x-link>
                {{-- end side supplier --}}

                {{-- side supplier --}}
                <x-link url="/stok/list" class="nav-link {{ request()->is('stok*') ? 'active text-bg-primary' : '' }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-clipboard"></i></div>
                    Stok Barang
                </x-link>
                {{-- end side supplier --}}


                {{-- side barang masuk --}}
                <x-link url="/receiving/list"
                    class="nav-link {{ request()->is('receiving*') ? 'active text-bg-primary' : '' }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-cart-plus"></i></div>
                    Barang Masuk
                </x-link>
                {{-- end side barang masuk --}}


                {{-- side barang keluar --}}
                <x-link url="/outbound/list"
                    class="nav-link {{ request()->is('outbound*') ? 'active text-bg-primary' : '' }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-cart-x-fill"></i></div>
                    Barang Keluar
                </x-link>
                {{-- end side barang keluar --}}

                {{-- side barang keluar --}}
                <x-link url="/retur/list"
                    class="nav-link {{ request()->is('retur*') ? 'active text-bg-primary' : '' }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-arrow-repeat"></i></div>
                    Barang Kembali
                </x-link>
                {{-- end side barang keluar --}}


                <x-link url="/user/list"
                    class="nav-link {{ request()->is('user*') ? 'active text-bg-primary' : 'collapsed' }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                    User
                </x-link>

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
