<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu ">
            <div class="nav">
                <div class="user-panel d-block mx-auto align-items-center flex-wrap flex-grow-1">
                    <div class="image">
                        <img src="{{ asset(isset(Auth::user()->id) && Auth::user()->profile->image ? '/assets/profile/' . Auth::user()->profile->image : 'assets/image/no-image.svg') }}"
                            class="elevation-2 profile img-circle" alt="User Image">
                    </div>
                    <div class="info">
                        <x-link url="/profile" :parameters="Auth::user()->id" :label="ucwords(Auth::user()->name)" id="profile-action"
                            class="d-block text-white profile-action text-decoration-none" />
                        <small class="d-block text-body-emphasis">
                            <i style="cursor: pointer" class="fas fa-circle online-status" title="checking..."></i>
                            {{ Auth::user()->role }}
                        </small>
                    </div>
                </div>
                @php
                    $isActive = request()->is('home*') || request()->is('restore*') ? 'active text-bg-primary' : '';
                @endphp
                <div class="sb-sidenav-menu-heading">Features</div>
                <x-link class="nav-link {{ $isActive }}" url="/home">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </x-link>

                @canany(['add', 'update', 'view', 'delete'])
                    <div class="sb-sidenav-menu-heading">Items</div>
                    {{-- side barang --}}
                    <x-link url="/barang/list"
                        class="nav-link {{ request()->is('barang*') ? 'active text-bg-primary' : '' }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                        Data Barang
                    </x-link>

                    {{-- end side barang --}}

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
                    <div class="sb-sidenav-menu-heading">Customers</div>



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
                @endcanany



                <div class="sb-sidenav-menu-heading">Settings</div>
                @can('onlyDevelop')
                    <x-link url="/user/list"
                        class="nav-link {{ request()->is('user*') ? 'active text-bg-primary' : 'collapsed' }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                        User
                    </x-link>
                @endcan

                <x-link class="nav-link" id="logout">
                    <div class="sb-nav-link-icon"><i class="fas fa-arrow-circle-left"></i></div>
                    Keluar
                    <x-form url="/logout" id="logout-form" class="d-none" />
                </x-link>
            </div>
        </div>
    </nav>
</div>
