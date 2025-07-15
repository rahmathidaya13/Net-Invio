@extends('layouts.app')
@section('title', 'Dashboard')
@section('icon', 'fas fa-home')
@section('breadcrumb', Str::upper('Dashboard'))
@section('content')
    <x-bread-crumbs :items="[['text' => 'Dashboard', 'url' => '/home']]" />

    @canany(['onlyAdmin', 'onlyDevelop'])
        <div class="d-flex justify-content-end flex-wrap gap-1 mb-3 ">
            <x-link icon="fas fa-undo-alt" url="/restore/create" label="Restore" class="btn-sm btn btn-dark rounded-0" />
            <x-link icon="fas fa-database" url="/backup" label="Backup" class="btn-sm btn btn-primary rounded-0" />
        </div>
    @endcanany

    @if ($message = Session::get('error'))
        <x-alert :duration="10" type="danger" message="{{ $message }}" />
    @endif
    @if ($message = Session::get('success'))
        <x-alert type="success" message="{{ $message }}" />
        <iframe class="d-none" src="{{ route('backup.download', ['file' => session('fileBackup')]) }}"></iframe>
    @endif


    <div class="callout callout-info d-grid">
        <strong class="fs-3">Selamat datang, {{ ucwords(auth()->user()->name) }}!</strong>
        <span class="text-capitalize">
            Semoga harimu selalu produktif dan selalu menyenangkan.</span>
    </div>

    <div class="row gap-2 gap-xl-0 g-xl-2 row-cols-1 row-cols-xl-4">

        {{-- count data barang --}}
        <div class="col-xl-6">
            <div class="card shadow-sm text-bg-primary card-gradient border-0 rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-uppercase mb-1">Stok Barang</h4>
                            <small>period: {{ \Carbon\Carbon::now()->format('m-Y') }}</small>
                            <h4 class="mb-0 fw-semibold">{{ $stokAll }}</h4>
                        </div>
                        <div class="icon-circle text-white d-flex align-items-center justify-content-center">
                            <i class="bi bi-boxes fs-1"></i>
                        </div>
                    </div>
                    <div class="pt-3">
                        <a href="/stok/list" class="text-white">
                            Lihat
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- count data barang masuk --}}
        <div class="col-xl-6">
            <div class="card shadow-sm text-bg-primary card-gradient border-0 rounded-4">
                <div class="card-body ">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-uppercase mb-1">Barang Masuk</h4>
                            <small>period: {{ \Carbon\Carbon::now()->format('m-Y') }}</small>
                            <h4 class="mb-0 fw-semibold">{{ $brgMasukAll }}</h4>
                        </div>
                        <div class="icon-circle text-white d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart-plus fs-1"></i>
                        </div>
                    </div>
                    <div class="pt-3">
                        <a href="/receiving/list" class="text-white">
                            Lihat
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-6">
            <div class="card shadow-sm text-bg-primary card-gradient border-0 rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-uppercase mb-1">Barang Keluar</h4>
                            <small>period: {{ \Carbon\Carbon::now()->format('m-Y') }}</small>
                            <h4 class="mb-0 fw-semibold">{{ $brgKeluarAll }}</h4>
                        </div>
                        <div class="icon-circle text-white d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart-x fs-1"></i>
                        </div>
                    </div>
                    <div class="pt-3">
                        <a href="/outbound/list" class="text-white">
                            Lihat
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-6">
            <div class="card shadow-sm text-bg-primary card-gradient border-0 rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-uppercase mb-1">Pelanggan</h4>
                            <small>period: {{ \Carbon\Carbon::now()->format('m-Y') }}</small>
                            <h4 class="mb-0 fw-semibold">{{ $pelangganAll }}</h4>
                        </div>
                        <div class="icon-circle text-white d-flex align-items-center justify-content-center">
                            <i class="fas fa-users fs-1"></i>
                        </div>
                    </div>
                    <div class="pt-3">
                        <a href="/pelanggan/list" class="text-white">
                            Lihat
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
