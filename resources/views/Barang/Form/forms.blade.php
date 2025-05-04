@extends('layouts.app')
@section('title', isset($barang) ? 'Ubah Data Barang' : 'Tambah Data Barang')
@section('icon', isset($barang) ? 'bi bi-pencil-square' : 'bi bi-plus-square-fill')
@section('breadcrumb', Str::upper(isset($barang) ? 'Ubah Data Barang' : 'Tambah Data Barang'))
@section('content')
    <x-bread-crumbs :items="[
        ['text' => 'Daftar Barang', 'url' => '/barang/list'],
        ['text' => ucwords(isset($barang) ? 'Ubah Data Barang' : 'Tambah Data Barang')],
    ]" />
    <div class="row">
        <div class="col-12 col-lg-12">
            @if ($message = Session::get('success'))
                <x-alert type="info" message="{{ $message }}" />
            @endif

            <div class="row align-items-center mb-3">
                <div class="col-lg-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    <x-link url="/barang/list" icon="bi bi-arrow-left-circle" label="Kembali" class="btn btn-danger btn-sm" />
                </div>
            </div>
            <x-card class="shadow-sm rounded-0" bodyClass="text-bg-light shadow-sm border border-light p-4"
                headerClass="text-uppercase text-bg-dark rounded-0 p-3" titleClass="text-start fs-5">
                {{-- title --}}
                <x-slot name="header">
                    <h5 class="card-title text-start mb-0">Form Barang</h5>
                </x-slot>
                {{-- content --}}
                @php
                    $options = [
                        'pcs' => 'Pcs',
                        'roll' => 'Roll',
                        'unit' => 'Unit',
                        'meter' => 'Meter',
                    ];
                @endphp
                <x-form url="{{ isset($barang) ? '/barang/update' : '/barang/store' }}"
                    method="{{ isset($barang) ? 'put' : null }}" parameters="{{ $barang->id_barang ?? '' }}">
                    <x-horizontal-input placeholder="R-001, KBL-009" autofocus name="kode_barang" label="Kode Barang"
                        value="{{ old('kode_barang', $barang->kode_barang ?? '') }}" />
                    <x-horizontal-input placeholder="102579851SN" name="sn" label="Serial Number"
                        value="{{ old('sn', $barang->serial_number ?? '') }}" />
                    <x-horizontal-input placeholder="Indihome Router " name="nama_barang" label="Nama Barang"
                        value="{{ old('nama_barang', $barang->nama_barang ?? '') }}" />
                    <x-horizontal-input placeholder="Router/Kabel/Wireless Radio" name="jenis_barang" label="Jenis Barang"
                        value="{{ old('jenis_barang', $barang->jenis ?? '') }}" />
                    <x-horizontal-input placeholder="Mikrotik, TP-Link" name="merek" label="Merek"
                        value="{{ old('merek', $barang->merek ?? '') }}" />
                    <x-horizontal-input placeholder="CCR1009 Dll" name="model" label="Tipe Model"
                        value="{{ old('model', $barang->tipe_model ?? '') }}" />
                    <div class="mb-3 row align-items-center">
                        <x-form-label for="satuan" value="Satuan" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-form-select name="satuan" :options="$options" text="Pilih Satuan"
                                selected="{{ old('satuan', $barang->satuan ?? '') }}" />
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <x-form-label for="keterangan" value="Keterangan" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-text-area name="keterangan" value="{{ old('keterangan', $barang->keterangan ?? '') }}" />
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <x-form-label class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5 d-grid d-lg-block gap-2">
                            <x-base-button type="submit" class="text-light rounded-2 shadow-sm"
                                variant="{{ isset($barang) ? 'success' : 'primary' }}"
                                label="{{ isset($barang) ? 'Ubah' : 'Simpan' }}"
                                icon="{{ isset($barang) ? 'bi bi-pencil-square' : 'bi bi-floppy-fill' }}" />

                            <x-base-button type="reset" class="stext-light rounded-2" variant="outline-danger"
                                label="Hapus" icon="bi bi-trash3-fill" />
                        </div>
                    </div>
                </x-form>
            </x-card>
        </div>
    </div>
@endsection
