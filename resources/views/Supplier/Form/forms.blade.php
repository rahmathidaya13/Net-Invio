@extends('layouts.app')
@section('title', isset($supplier) ? 'Ubah Data supplier' : 'Tambah Data Supplier')
@section('icon', isset($supplier) ? 'bi bi-pencil-square' : 'bi bi-plus-square-fill')
@section('breadcrumb', Str::upper(isset($supplier) ? 'Ubah Data Supplier' : 'Tambah Data Supplier'))
@section('content')
    <x-bread-crumbs :items="[
        ['text' => 'Daftar Supplier', 'url' => '/supplier/list'],
        ['text' => ucwords(isset($supplier) ? 'Ubah Data Supplier' : 'Tambah Data Supplier')],
    ]" />

    <div class="row">
        <div class="col-12 col-xl-12">
            @if ($message = Session::get('success'))
                <x-alert type="info" message="{{ $message }}" />
            @endif

            <div class="row align-items-center mb-3">
                <div class="col-xl-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    <x-link url="/supplier/list" icon="bi bi-arrow-left-circle" label="Kembali" class="btn btn-danger btn-sm" />
                </div>
            </div>
            <x-card class="shadow-sm overflow-hidden" bodyClass="text-bg-light shadow-sm p-4"
                headerClass="text-uppercase text-bg-dark rounded-0 p-3" titleClass="text-start fs-5">
                {{-- title --}}
                <x-slot name="header">
                    <h5 class="card-title text-start mb-0">Form supplier</h5>
                </x-slot>
                {{-- content --}}

                <x-form url="{{ isset($supplier) ? '/supplier/update' : '/supplier/store' }}"
                    method="{{ isset($supplier) ? 'put' : null }}" parameters="{{ $supplier->id_supplier ?? '' }}">
                    <x-horizontal-input autofocus placeholder="JhonDoe" name="nama_supplier" label="Nama Supplier"
                        value="{{ old('nama_supplier', $supplier->nama ?? '') }}" />

                    <x-horizontal-input placeholder="0812xxxx" name="kontak" label="Kontak"
                        value="{{ old('kontak', $supplier->kontak ?? '') }}" />
                    <x-horizontal-input type="email" placeholder="@example.com" name="email" label="Email"
                        value="{{ old('email', $supplier->email ?? '') }}" />
                    <div class="mb-3 row align-items-center">
                        <x-form-label for="alamat" value="Alamat" class="col-xl-2 col-form-label form-label" />
                        <div class="col-xl-5">
                            <x-text-area name="alamat" value="{{ old('alamat', $supplier->alamat ?? '') }}" />
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <div class="offset-xl-2 d-grid d-xl-block gap-2">
                            <x-base-button type="submit" class="text-light rounded-2 shadow-sm"
                                variant="{{ isset($supplier) ? 'success' : 'primary' }}"
                                label="{{ isset($supplier) ? 'Ubah' : 'Simpan' }}"
                                icon="{{ isset($supplier) ? 'bi bi-pencil-square' : 'bi bi-floppy-fill' }}" />

                            <x-base-button type="reset" class="stext-light rounded-2" variant="outline-danger"
                                label="Hapus" icon="bi bi-trash3-fill" />
                        </div>
                    </div>
                </x-form>
            </x-card>
        </div>
    </div>
@endsection
