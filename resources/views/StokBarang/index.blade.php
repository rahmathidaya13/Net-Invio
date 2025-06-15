@extends('layouts.app')
@section('title', 'Daftar Stok Barang')
@section('icon', 'bi bi-clipboard-check-fill')
@section('breadcrumb', Str::upper('Daftar Stok Barang'))
@section('content')
    <x-bread-crumbs :items="[['text' => 'Daftar Stok Barang', 'url' => '/stok/list']]" />
    <div class="row">
        <div class="col-12 col-lg-12">

            <x-alert-error-all type="danger" title="Alert!" />

            @if ($message = Session::get('success'))
                <x-alert type="success" message="{{ $message }}" />
            @endif

            <div class="callout callout-info d-grid">
                <strong class="fs-4 mb-2"> <i class="bi bi-megaphone-fill"></i> Informasi</strong>
                <span class="flex-column col-12 col-xl-8 align-content-center">Halaman ini menampilkan data stok barang
                    terkini. Pastikan stok diperbarui
                    secara berkala untuk menghindari selisih pencatatan.</span>
            </div>
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    {{-- this button --}}
                    @can('add')
                        <x-link url="/stok/create" icon="bi bi-plus-circle" label="Tambah"
                            class="btn btn-primary btn-sm text-light" />
                    @endcan

                    {{-- print pdf & excell --}}
                    <div class="dropdown">
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-printer-fill"></i> Print
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <x-link data-bs-toggle="modal" data-bs-target="#modalExcell" icon="bi bi-file-earmark-excel-fill" label="Excel"
                                    class="dropdown-item print_excell" />
                            </li>
                            <li>
                                <x-link data-bs-toggle="modal" data-bs-target="#modalPDF"
                                    icon="bi bi-file-earmark-pdf-fill" label="Pdf" class="dropdown-item print_pdf" />
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 mb-0 mb-lg-0 d-flex flex-wrap align-items-center gap-1 ms-lg-auto">
                    <x-form-input autofocus placeholder="Masukan pencarian..." type="search" name="keyword"
                        class="form-control-sm" />
                    <div class="d-none" id="text-result">Search result: <span id="results" class="fw-bold"></span>
                    </div>
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="d-flex flex-wrap align-items-center gap-2 justify-content-between mb-3">
                    <div class="input-group align-items-center" style="width: 12rem">
                        <span class="me-2">Tampilkan hasil: </span>
                        <x-form-select class="form-select-sm" name="limit" :options="['10' => '10', '20' => '20', '50' => '50', '100' => '100']" />
                    </div>
                    <div class="input-group align-items-center w-15 gap-3">
                        <x-form-select class="form-select-sm" name="sort_order" text="Sort By" :options="['asc' => 'Ascending', 'desc' => 'Descending']" />

                    </div>

                </div>

            </div>
            @php
                $thead = ['No','Kode Stok', 'Tanggal', 'No.Warehouse', 'Nama Barang', 'Jumlah Barang', 'Lokasi/Tempat'];
            @endphp
            <x-card class="shadow-sm overflow-hidden" bodyClass="p-0" titleClass="text-start fs-6">
                <div class="table-responsive table-responsive-fixed">
                    <x-table theadColor="success" tbodyId="stok_tabel"
                        class="text-center text-nowrap table-hover table-clickable" :header="$thead">
                        @include('StokBarang.partials.table', ['stok' => $stok])
                    </x-table>
                </div>
                <div class="d-flex flex-wrap justify-content-lg-between align-items-center flex-column flex-lg-row p-3">
                    @include('StokBarang.partials.informasi', ['stok' => $stok])
                    @include('StokBarang.partials.pagination', ['stok' => $stok])
                </div>
            </x-card>
        </div>

    </div>

@include('StokBarang.modal.modalExcell')
@include('StokBarang.modal.modalPDF')
@endsection
