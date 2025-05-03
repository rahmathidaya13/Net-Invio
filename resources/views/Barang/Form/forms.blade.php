@extends('layouts.app')
@section('title', 'Tambah Barang')
@section('icon', 'bi bi-plus-square-fill')
@section('breadcrumb', Str::upper('Tambah Barang'))
@section('content')
    <div class="row">
        <div class="col-12 col-lg-12">
            <x-alert-error-all type="danger" title="Alert!" />
            @if ($message = Session::get('success'))
                <x-alert type="info" message="{{ $message }}" />
            @endif

            <div class="row align-items-center mb-4">
                <div class="col-lg-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    <x-link url="/barang/list" icon="bi bi-arrow-left-circle" label="Kembali" class="btn btn-danger btn-sm" />
                </div>
            </div>
            <x-card class="shadow-sm rounded-0" bodyClass="text-bg-light shadow-sm border border-light p-3"
                headerClass="text-uppercase" titleClass="text-start fs-5">
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
                    <x-horizontal-input name="kode_barang" label="Kode Barang"
                        value="{{ old('kode_barang', $barang->kode_barang ?? '') }}" />
                    <x-horizontal-input name="sn" label="Serial Number"
                        value="{{ old('sn', $barang->serial_number ?? '') }}" />
                    <x-horizontal-input name="nama_barang" label="Nama Barang"
                        value="{{ old('nama_barang', $barang->nama_barang ?? '') }}" />
                    <x-horizontal-input name="jenis_barang" label="Jenis Barang"
                        value="{{ old('jenis_barang', $barang->jenis ?? '') }}" />
                    <x-horizontal-input name="merek" label="Merek" value="{{ old('merek', $barang->merek ?? '') }}" />
                    <x-horizontal-input name="model" label="Tipe Model"
                        value="{{ old('model', $barang->tipe_model ?? '') }}" />
                    <div class="mb-3 row align-items-center">
                        <x-form-label for="satuan" value="Satuan" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-4">
                            <x-form-select name="satuan" :options="$options" text="Pilih Satuan"
                                selected="{{ old('satuan', $barang->satuan ?? '') }}" />
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <x-form-label for="keterangan" value="Keterangan" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-4">
                            <x-text-area name="keterangan" value="{{ old('keterangan', $barang->keterangan ?? '') }}" />
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <x-form-label class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-4 d-grid d-lg-block gap-2">
                            <x-base-button type="submit" class="text-light"
                                variant="{{ isset($barang) ? 'success' : 'primary' }}"
                                label="{{ isset($barang) ? 'Ubah' : 'Simpan' }}"
                                icon="{{ isset($barang) ? 'bi bi-pencil-square' : 'bi bi-floppy-fill' }}" />

                            <x-base-button type="reset" class="stext-light" variant="outline-danger" label="Hapus"
                                icon="bi bi-trash3-fill" />
                        </div>
                    </div>
                </x-form>
            </x-card>
        </div>
    </div>
@endsection
