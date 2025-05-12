@extends('layouts.app')
@section('title', 'Daftar supplier')
@section('icon', 'bi bi-people-fill')
@section('breadcrumb', Str::upper('Daftar supplier'))
@section('content')
    <x-bread-crumbs :items="[['text' => 'Daftar Supplier', 'url' => '/supplier/list']]" />
    <div class="row">
        <div class="col-12 col-lg-12">

            <x-alert-error-all type="danger" title="Alert!" />

            @if ($message = Session::get('success'))
                <x-alert type="success" message="{{ $message }}" />
            @endif
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    {{-- this button --}}
                    @can('add')
                        <x-link url="/supplier/create" icon="bi bi-plus-circle" label="Tambah"
                            class="btn btn-primary btn-sm text-light" />
                    @endcan
                    <x-link icon="bi bi-upload" label="Import" class="btn btn-outline-success btn-sm" />
                    <x-link icon="bi bi-printer-fill" label="Cetak" class="btn btn-outline-secondary btn-sm" />
                </div>
                <div class="col-lg-3 mb-0 mb-lg-0 d-flex flex-wrap align-items-center gap-1 ms-lg-auto">
                    <x-form-input autofocus placeholder="Masukan pencarian..." type="search"
                        name="keyword" class="form-control-sm" />
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
                $thead = ['No', 'Nama supplier', 'Kontak', 'Email', 'Alamat'];
            @endphp
            <x-card class="shadow-sm rounded-0" bodyClass="text-bg-light shadow-sm border border-light p-0"
                titleClass="text-start fs-6">
                <div class="table-responsive">
                    <x-table theadColor="success" tbodyId="supplier_tabel" class=" text-nowrap table-hover table-clickable"
                        :header="$thead">
                        @include('Supplier.partials.table', ['supplier' => $supplier])
                    </x-table>
                </div>
                <div class="d-flex flex-wrap justify-content-lg-between align-items-center flex-column flex-lg-row p-3">
                    @include('Supplier.partials.informasi', ['supplier' => $supplier])
                    @include('Supplier.partials.pagination', ['supplier' => $supplier])
                </div>
            </x-card>
        </div>

    </div>
@endsection
