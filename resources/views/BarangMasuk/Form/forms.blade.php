@extends('layouts.app')
@section('title', isset($barang_masuk) ? 'Ubah Barang Masuk ' : 'Tambah Barang Masuk')
@section('icon', isset($barang_masuk) ? 'bi bi-pencil-square' : 'bi bi-plus-square-fill')
@section('breadcrumb', Str::upper(isset($barang_masuk) ? 'Ubah Barang Masuk' : 'Tambah Barang Masuk'))
@section('content')
    <x-bread-crumbs :items="[
        ['text' => 'Daftar Barang Masuk', 'url' => '/receiving/list'],
        ['text' => ucwords(isset($barang_masuk) ? 'Ubah Barang Masuk' : 'Tambah Barang Masuk')],
    ]" />

    <div class="row">
        <div class="col-12 col-lg-12">
            @if ($message = Session::get('success'))
                <x-alert type="info" message="{{ $message }}" />
            @endif

            <div class="row align-items-center mb-3">
                <div class="col-lg-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    <x-link url="/receiving/list" icon="bi bi-arrow-left-circle" label="Kembali"
                        class="btn btn-danger btn-sm" />
                </div>
            </div>
            <x-card class="shadow-sm rounded-0" bodyClass="text-bg-light shadow-sm border border-light p-4"
                headerClass="text-uppercase text-bg-dark rounded-0 p-3" titleClass="text-start fs-5">
                {{-- title --}}
                <x-slot name="header">
                    <h5 class="card-title text-start mb-0">Form Barang Masuk</h5>
                </x-slot>
                {{-- content --}}

                <x-form url="{{ isset($barang_masuk) ? '/receiving/update' : '/receiving/store' }}"
                    method="{{ isset($barang_masuk) ? 'put' : null }}"
                    parameters="{{ $barang_masuk->id_barang_masuk ?? '' }}">

                    <x-horizontal-input autofocus type="date" name="tanggal" label="Tanggal"
                        value="{{ old('tanggal', $barang_masuk->tanggal ?? '') }}" />
                    <div class="mb-3 row align-items-center">
                        <x-form-label for="nama_barang" value="Nama Barang" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            @php
                                $optionBarang = [];
                                foreach ($barang as $item) {
                                    $optionBarang[$item->id_barang] = $item->nama_barang;
                                }
                            @endphp
                            <x-form-select class="select2" name="nama_barang" text="---Pilih Barang---" :options="$optionBarang"
                                selected="{{ old('nama_barang', $barang_masuk->id_barang ?? '') }}" />
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="sumber" value="Sumber Pembelian" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            @php
                                $sumber = ['internal' => 'Internal', 'supplier' => 'Supplier'];
                            @endphp
                            <x-form-select name="sumber" text="---Pilih Sumber Pembelian---" :options="$sumber"
                                selected="{{ old('sumber', $barang_masuk->sumber ?? '') }}" />
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="suppliers" value="Supplier" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            @php
                                $optionSupplier = [];
                                foreach ($supplier as $item) {
                                    $optionSupplier[$item->id_supplier] = $item->nama;
                                }
                            @endphp
                            <x-form-select class="select2" name="supplier" text="---Pilih Supplier---" :options="$optionSupplier"
                                selected="{{ old('supplier', $barang_masuk->id_supplier ?? '') }}" />
                        </div>
                    </div>

                    <x-horizontal-input name="pembeli" label="Pembeli"
                        value="{{ old('pembeli', $barang_masuk->pembeli ?? '-') }}" />

                    <x-horizontal-input name="nota" label="Nota"
                        value="{{ old('nota', $barang_masuk->nota ?? '') }}" />

                    <x-horizontal-input name="jumlah" label="Jumlah Barang"
                        value="{{ old('jumlah', $barang_masuk->jumlah ?? '') }}" />

                    <x-horizontal-input name="harga" label="Harga Barang"
                        value="{{ number_format((int) old('harga', $barang_masuk->harga ?? ''), 0, ',', '.') }}" />

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="lokasi" value="Lokasi/Tempat" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-form-select name="lokasi" text="---Pilih Lokasi/Tempat---" :options="['gudang-1' => 'Gudang 1', 'gudang-2' => 'Gudang 2']"
                                selected="{{ old('lokasi', $barang_masuk->lokasi ?? '') }}" />
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <x-form-label for="keterangan" value="Keterangan" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-text-area name="keterangan"
                                value="{{ old('keterangan', $barang_masuk->keterangan ?? '-') }}" />
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <x-form-label class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5 d-grid d-lg-block gap-2">
                            <x-base-button type="submit" class="text-light rounded-2 shadow-sm"
                                variant="{{ isset($barang_masuk) ? 'success' : 'primary' }}"
                                label="{{ isset($barang_masuk) ? 'Ubah' : 'Simpan' }}"
                                icon="{{ isset($barang_masuk) ? 'bi bi-pencil-square' : 'bi bi-floppy-fill' }}" />

                            <x-base-button type="reset" class="stext-light rounded-2" variant="outline-danger"
                                label="Hapus" icon="bi bi-trash3-fill" />
                        </div>
                    </div>
                </x-form>
            </x-card>
        </div>
    </div>
@endsection
