@extends('layouts.app')
@section('title', 'Dashboard')
@section('icon', 'fas fa-home')
@section('breadcrumb', Str::upper('Dashboard'))
@section('content')
    <x-bread-crumbs :items="[['text' => 'Dashboard', 'url' => '/home']]" />

    {{-- <div class="card mb-4">
        <div class="card-body">
            DataTables is a third party plugin that is used to generate the demo table below. For more information about
            DataTables, please visit the
            <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
            .
        </div>
    </div> --}}

    @if ($message = Session::get('error'))
        <x-alert type="danger" message="{{ $message }}" />
    @endif

    <div class="callout callout-info d-grid">
        <strong class="fs-3">Selamat datang kembali, {{ ucwords(auth()->user()->name) }}!</strong>
        <span class="text-capitalize">
            Anda login sebagai <b>{{ auth()->user()->role }}</b>, Semoga harimu selalu produktif dan selalu
            menyenangkan.</span>
    </div>
    <div class="row gap-3 gap-lg-0">

        {{-- count data barang --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm text-bg-primary card-gradient border-0 rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase  mb-1">Stok Barang</h6>
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
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm text-bg-primary card-gradient border-0 rounded-4">
                <div class="card-body ">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Barang Masuk</h6>
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


        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm text-bg-primary card-gradient border-0 rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Barang Keluar</h6>
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


        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm text-bg-primary card-gradient border-0 rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Pelanggan</h6>
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
