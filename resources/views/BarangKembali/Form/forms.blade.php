@extends('layouts.app')
@section('title', isset($barang_kembali) ? 'Ubah Barang Kembali ' : 'Buat Barang Kembali')
@section('icon', isset($barang_kembali) ? 'bi bi-pencil-square' : 'bi bi-plus-square-fill')
@section('breadcrumb', Str::upper(isset($barang_kembali) ? 'Ubah Barang Kembali' : 'Buat Barang Kembali'))
@section('content')
    <x-bread-crumbs :items="[
        ['text' => 'Daftar Barang Kembali', 'url' => '/retur/list'],
        ['text' => ucwords(isset($barang_kembali) ? 'Ubah Barang Kembali' : 'Buat Barang Kembali')],
    ]" />

    <div class="row">
        <div class="col-12 col-lg-12">
            @if ($message = Session::get('success'))
                <x-alert type="info" message="{{ $message }}" />
            @endif

            <div class="row align-items-center mb-3">
                <div class="col-lg-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    <x-link url="/retur/list" icon="bi bi-arrow-left-circle" label="Kembali" class="btn btn-danger btn-sm" />
                </div>
            </div>
            <x-card class="shadow-sm rounded-0" bodyClass="text-bg-light shadow-sm border border-light p-4"
                headerClass="text-uppercase text-bg-dark rounded-0 p-3" titleClass="text-start fs-5">
                {{-- title --}}
                <x-slot name="header">
                    <h5 class="card-title text-start mb-0">Form Barang Kembali</h5>
                </x-slot>
                {{-- content --}}

                <x-form url="{{ isset($barang_kembali) ? '/retur/update' : '/retur/store' }}"
                    method="{{ isset($barang_kembali) ? 'put' : null }}"
                    parameters="{{ $barang_kembali->id_barang_kembali ?? '' }}">

                    <x-horizontal-input autofocus :readonly="isset($barang_kembali) && $barang_kembali->id_barang_kembali" type="date" name="tanggal" label="Tanggal"
                        value="{{ old('tanggal', $barang_kembali->tanggal ?? '') }}" />

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="barang" value="Barang" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            @php
                                $optionBarang = [];
                                foreach ($barang as $item) {
                                    $optionBarang[$item->id_barang] = $item->nama_barang;
                                }
                            @endphp
                            <x-form-select class="select2" name="barang" text="---Pilih Barang---" :options="$optionBarang"
                                selected="{{ old('barang', $barang_kembali->id_barang ?? '') }}" />
                        </div>
                        <input type="text" class="d-none" name="id_barang" id="id_barang"
                            value="{{ $barang_kembali->id_barang ?? '' }}">
                    </div>

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="pelanggan" value="Pelanggan" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            @php
                                $optionPelanggan = [];
                                foreach ($pelanggan as $item) {
                                    $optionPelanggan[$item->id_pelanggan] = $item->nama;
                                }
                            @endphp
                            <x-form-select class="select2" name="pelanggan" text="---Pilih Pelanggan---" :options="$optionPelanggan"
                                selected="{{ old('pelanggan', $barang_kembali->id_pelanggan ?? '') }}" />
                        </div>
                        <input type="text" class="d-none" name="id_pelanggan" id="id_pelanggan"
                            value="{{ $barang_kembali->id_pelanggan ?? '' }}">
                    </div>

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="supplier" value="Supplier" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            @php
                                $optionSupplier = [];
                                foreach ($supplier as $item) {
                                    $optionSupplier[$item->id_supplier] = $item->nama;
                                }
                            @endphp
                            <x-form-select class="select2" name="supplier" text="---Pilih Supplier---" :options="$optionSupplier"
                                selected="{{ old('supplier', $barang_kembali->id_supplier ?? '') }}" />
                        </div>
                        <input type="text" class="d-none" name="id_supplier" id="id_supplier"
                            value="{{ $barang_kembali->id_supplier ?? '' }}">
                    </div>

                    <x-horizontal-input name="jumlah" label="Jumlah Retur"
                        value="{{ old('jumlah', $barang_kembali->jumlah ?? '') }}" />

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="tipe_retur" value="Tipe Retur" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-form-select class="select2" name="tipe_retur" text="---Pilih Tipe Retur---" :options="['masuk' => 'Masuk', 'keluar' => 'Keluar']"
                                selected="{{ old('tipe_retur', $barang_kembali->tipe_retur ?? '') }}" />
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <x-form-label for="status" value="Status Retur" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-form-select class="select2" name="status" text="---Pilih Status Retur---" :options="[
                                'diganti' => 'Diganti',
                                'tidak_diganti' => 'Tidak Diganti',
                                'diperbaiki' => 'Diperbaiki',
                            ]"
                                selected="{{ old('status', $barang_kembali->status_pergantian ?? '') }}" />
                        </div>
                    </div>

                    <x-horizontal-input type="file" name="gambar" label="Gambar" accept="image/*" />

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="alasan" value="Alasan" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-text-area name="alasan" value="{{ old('alasan', $barang_kembali->alasan ?? '') }}" />
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <x-form-label class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5 d-grid d-lg-block gap-2">
                            <x-base-button type="submit" class="text-light rounded-2 shadow-sm"
                                variant="{{ isset($barang_kembali) ? 'success' : 'primary' }}"
                                label="{{ isset($barang_kembali) ? 'Ubah' : 'Simpan' }}"
                                icon="{{ isset($barang_kembali) ? 'bi bi-pencil-square' : 'bi bi-floppy-fill' }}" />

                            <x-base-button type="reset" class="stext-light rounded-2" variant="outline-danger"
                                label="Hapus" icon="bi bi-trash3-fill" />
                        </div>
                    </div>
                </x-form>
            </x-card>
        </div>
    </div>
@endsection
