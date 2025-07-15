@extends('layouts.app')
@section('title', 'Daftar Barang Masuk')
@section('icon', 'bi bi-cart-plus-fill')
@section('breadcrumb', Str::upper('Daftar Barang Masuk'))
@section('content')
    <x-bread-crumbs :items="[['text' => 'Daftar Barang Masuk', 'url' => '/receiving/list']]" />
    <div class="row">
        <div class="col-12 col-lg-12">

            <x-alert-error-all type="danger" title="Alert!" />

            @if ($message = Session::get('success'))
                <x-alert :duration="10" type="success" message="{{ $message }}" />
            @endif
            <div class="callout callout-info d-grid">
                <strong class="fs-4 mb-2"> <i class="bi bi-megaphone-fill"></i> Informasi</strong>
                <span class="flex-column col-12 col-xl-8 align-content-center">Halaman ini digunakan untuk mencatat barang
                    yang baru masuk ke gudang.
                    Pastikan data seperti tanggal masuk, jumlah, dan supplier jika dari supplier dicatat dengan
                    benar.</span>
            </div>
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    {{-- this button --}}
                    @can('add')
                        <x-link url="/receiving/create" icon="bi bi-plus-circle" label="Tambah"
                            class="btn btn-primary btn-sm text-light" />
                    @endcan
                    {{-- print pdf & excell --}}
                    @can('download')
                        <div class="dropdown">
                            <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-printer-fill"></i> Print
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <x-link data-bs-toggle="modal" data-bs-target="#modalExcell"
                                        icon="bi bi-file-earmark-excel-fill" label="Excel"
                                        class="dropdown-item print_excell" />
                                </li>
                                <li>
                                    <x-link data-bs-toggle="modal" data-bs-target="#modalPDF" icon="bi bi-file-earmark-pdf-fill"
                                        label="Pdf" class="dropdown-item print_pdf" />
                                </li>
                            </ul>
                        </div>
                    @endcan

                </div>
                <div class="col-lg-3 mb-0 mb-lg-0 d-flex flex-wrap align-items-center gap-1 ms-lg-auto">
                    <x-form-input autofocus placeholder="Masukan pencarian..." type="search" name="keyword"
                        class="form-control-sm" />
                    <div class="d-none" id="text-result">Search result: <span id="results" class="fw-bold"></span>
                    </div>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="d-flex flex-wrap align-items-center gap-2 justify-content-between">
                    <div class="input-group align-items-center" style="width: 12rem">
                        <span class="me-2">Tampilkan hasil: </span>
                        <x-form-select class="form-select-sm" name="limit" :options="['10' => '10', '20' => '20', '50' => '50', '100' => '100']" />
                    </div>
                    <div class="input-group align-items-center w-15">
                        <x-form-select class="form-select-sm" name="sort_order" text="Sort By" :options="['asc' => 'Ascending', 'desc' => 'Descending']" />
                    </div>
                </div>
            </div>

            @php
                $thead = [
                    'No',
                    'Kode Barang Masuk',
                    'Tanggal',
                    'Nota',
                    'Nama Barang',
                    'Supplier',
                    'Sumber',
                    'Pembeli',
                    'Jumlah',
                    'Harga',
                    'Lokasi Penyimpanan',
                    'Keterangan',
                ];
            @endphp
            <x-card class="shadow-sm overflow-hidden" bodyClass="p-0" titleClass="text-start fs-6">
                <div class="table-responsive table-responsive-fixed">
                    <x-table theadColor="success" tbodyId="barang_masuk_tabel"
                        class="text-center text-nowrap table-hover table-clickable" :header="$thead">
                        @include('BarangMasuk.partials.table', ['barang_masuk' => $barang_masuk])
                    </x-table>
                </div>
                <div class="d-flex flex-wrap justify-content-lg-between align-items-center flex-column flex-lg-row p-3">
                    @include('BarangMasuk.partials.informasi', ['barang_masuk' => $barang_masuk])
                    @include('BarangMasuk.partials.pagination', ['barang_masuk' => $barang_masuk])
                </div>
            </x-card>
        </div>

    </div>
    @include('BarangMasuk.modal.modalExcell')
    @include('BarangMasuk.modal.modalPDF')
@endsection
