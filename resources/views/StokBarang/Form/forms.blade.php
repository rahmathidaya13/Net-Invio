@extends('layouts.app')
@section('title', isset($stok) ? 'Ubah Data stok' : 'Tambah Data stok')
@section('icon', isset($stok) ? 'bi bi-pencil-square' : 'bi bi-plus-square-fill')
@section('breadcrumb', Str::upper(isset($stok) ? 'Ubah Data stok' : 'Tambah Data stok'))
@section('content')
    <x-bread-crumbs :items="[
        ['text' => 'Daftar Stok Barang', 'url' => '/stok/list'],
        ['text' => ucwords(isset($stok) ? 'Ubah Data stok' : 'Tambah Data stok')],
    ]" />

    <div class="row">
        <div class="col-12 col-lg-12">
            @if ($message = Session::get('success'))
                <x-alert type="info" message="{{ $message }}" />
            @endif

            <div class="row align-items-center mb-3">
                <div class="col-lg-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    <x-link url="/stok/list" icon="bi bi-arrow-left-circle" label="Kembali" class="btn btn-danger btn-sm" />
                </div>
            </div>
            <x-card class="shadow-sm overflow-hidden" bodyClass="text-bg-light shadow-sm p-4"
                headerClass="text-uppercase text-bg-dark rounded-0 p-3" titleClass="text-start fs-5">
                {{-- title --}}
                <x-slot name="header">
                    <h5 class="card-title text-start mb-0">Form Stok Barang</h5>
                </x-slot>
                {{-- content --}}

                <x-form url="{{ isset($stok) ? '/stok/update' : '/stok/store' }}" method="{{ isset($stok) ? 'put' : null }}"
                    parameters="{{ $stok->id_stok ?? '' }}">
                    <x-horizontal-input autofocus type="date" name="tanggal" label="Tanggal"
                        value="{{ old('tanggal', $stok->tanggal ?? '') }}" />

                    <x-horizontal-input name="no_warehouse" label="No.Warehouse" placeholder="example:WH-0001"
                        value="{{ old('no_warehouse', $stok->no_warehouse ?? '') }}" />

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="nama_barang" value="Nama Barang" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            @php
                                $option = [];
                                foreach ($barang as $item) {
                                    $option[$item->id_barang] = $item->nama_barang;
                                }
                            @endphp
                            <x-form-select class="select2" name="nama_barang" text="Pilih Barang" :options="$option"
                                selected="{{ old('nama_barang', $stok->id_barang ?? '') }}" />
                        </div>
                    </div>
                    <x-horizontal-input name="jumlah" label="Jumlah Barang" placeholder="0"
                        value="{{ old('jumlah', $stok->jumlah_barang ?? '') }}" />

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="lokasi" value="Lokasi/Tempat" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-form-select name="lokasi" text="---Pilih Lokasi/Tempat---" :options="['gudang-1' => 'Gudang 1', 'gudang-2' => 'Gudang 2']"
                                selected="{{ old('lokasi', $stok->lokasi ?? '') }}" />
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="keterangan" value="Keterangan" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-text-area name="keterangan" value="{{ old('keterangan', $stok->keterangan ?? '-') }}" />
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <div class="offset-sm-2 d-grid d-lg-block gap-2">
                            <x-base-button type="submit" class="text-light rounded-2 shadow-sm"
                                variant="{{ isset($stok) ? 'success' : 'primary' }}"
                                label="{{ isset($stok) ? 'Ubah' : 'Simpan' }}"
                                icon="{{ isset($stok) ? 'bi bi-pencil-square' : 'bi bi-floppy-fill' }}" />

                            <x-base-button type="reset" class="stext-light rounded-2" variant="outline-danger"
                                label="Hapus" icon="bi bi-trash3-fill" />
                        </div>
                    </div>
                </x-form>
            </x-card>
        </div>
    </div>
@endsection
