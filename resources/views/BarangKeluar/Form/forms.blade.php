@extends('layouts.app')
@section('title', isset($barang_keluar) ? 'Ubah Barang Keluar ' : 'Buat Barang Keluar')
@section('icon', isset($barang_keluar) ? 'bi bi-pencil-square' : 'bi bi-plus-square-fill')
@section('breadcrumb', Str::upper(isset($barang_keluar) ? 'Ubah Barang Keluar' : 'Buat Barang Keluar'))
@section('content')
    <x-bread-crumbs :items="[
        ['text' => 'Daftar Barang Keluar', 'url' => '/outbound/list'],
        ['text' => ucwords(isset($barang_keluar) ? 'Ubah Barang Masuk' : 'Buat Barang Keluar')],
    ]" />

    <div class="row">
        <div class="col-12 col-lg-12">
            @if ($message = Session::get('success'))
                <x-alert type="info" message="{{ $message }}" />
            @endif

            <div class="row align-items-center mb-3">
                <div class="col-lg-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    <x-link url="/outbound/list" icon="bi bi-arrow-left-circle" label="Kembali" class="btn btn-danger btn-sm" />
                </div>
            </div>
            <x-card class="shadow-sm rounded-0" bodyClass="text-bg-light shadow-sm border border-light p-4"
                headerClass="text-uppercase text-bg-dark rounded-0 p-3" titleClass="text-start fs-5">
                {{-- title --}}
                <x-slot name="header">
                    <h5 class="card-title text-start mb-0">Form Barang Keluar</h5>
                </x-slot>
                {{-- content --}}

                <x-form url="{{ isset($barang_keluar) ? '/outbound/update' : '/outbound/store' }}"
                    method="{{ isset($barang_keluar) ? 'put' : null }}"
                    parameters="{{ $barang_keluar->id_barang_keluar ?? '' }}">

                    <x-horizontal-input autofocus :readonly="isset($barang_keluar) && $barang_keluar->id_barang_keluar" type="date" name="tanggal" label="Tanggal"
                        value="{{ old('tanggal', $barang_keluar->tanggal ?? '') }}" />

                    <x-horizontal-input name="kode_keluar" label="Kode Barang Keluar"
                        value="{{ old('kode_keluar', $barang_keluar->kode_barang_keluar ?? '') }}" />

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="barang" value="Barang" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            @php
                                $optionStok = [];
                                foreach ($stok as $item) {
                                    $optionStok[$item->id_stok] = $item->barang->nama_barang;
                                }
                            @endphp
                            <x-form-select :disabled="isset($barang_keluar) && $barang_keluar->id_barang_keluar" class="select2" name="barang" text="---Pilih Barang---"
                                :options="$optionStok" selected="{{ old('barang', $barang_keluar->id_stok ?? '') }}" />
                        </div>
                        <input type="text" class="d-none" name="id_barang" id="id_barang"
                            value="{{ $barang_keluar->id_barang ?? '' }}">
                        <input type="text" class="d-none" name="id_stok" id="id_stok"
                            value="{{ $barang_keluar->id_stok ?? '' }}">
                    </div>

                    <x-horizontal-input readonly name="lokasi" label="Dikeluarkan"
                        value="{{ old('lokasi', $barang_keluar->lokasi ?? '') }}" />

                    <x-horizontal-input readonly name="sisa_stok"
                        label="{{ isset($barang_keluar) ? 'Sisa Stok' : 'Stok Tersedia' }}" value="0" />

                    <x-horizontal-input readonly name="no_warehouse" label="No.Warehouse" />

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
                                selected="{{ old('pelanggan', $barang_keluar->id_pelanggan ?? '') }}" />
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="tujuan" value="Tujuan" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            @php
                                $tujuan = ['pemasangan' => 'Pemasangan Baru', 'pergantian' => 'Pergantian Alat'];
                            @endphp
                            <x-form-select name="tujuan" text="---Pilih Tujuan---" :options="$tujuan"
                                selected="{{ old('tujuan', $barang_keluar->tujuan ?? '') }}" />
                        </div>
                    </div>
                    <x-horizontal-input name="jumlah" label="Jumlah Keluar"
                        value="{{ old('jumlah', $barang_keluar->jumlah ?? '0') }} " />

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="satuan" value="Satuan" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-form-select name="satuan" :options="[
                                'pack' => 'Pack',
                                'pcs' => 'Pcs',
                                'unit' => 'Unit',
                                'roll' => 'Roll',
                                'm' => 'Meter',
                                'cm' => 'Centimeter',
                            ]" text="---Pilih Satuan---"
                                selected="{{ old('satuan', $barang_keluar->satuan ?? '') }}" />
                        </div>
                    </div>
                    <x-horizontal-input name="petugas" label="Petugas"
                        value="{{ ucwords(old('petugas', $barang_keluar->petugas ?? '')) }} " />

                    <div class="mb-3 row align-items-center">
                        <x-form-label for="keterangan" value="Keterangan" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-text-area name="keterangan"
                                value="{{ old('keterangan', $barang_keluar->keterangan ?? '') }}" />
                        </div>
                    </div>


                    <div class="mb-3 row align-items-center">
                        <div class="offset-sm-2 d-grid d-lg-block gap-2">
                            <x-base-button type="submit" class="text-light rounded-2 shadow-sm"
                                variant="{{ isset($barang_keluar) ? 'success' : 'primary' }}"
                                label="{{ isset($barang_keluar) ? 'Ubah' : 'Simpan' }}"
                                icon="{{ isset($barang_keluar) ? 'bi bi-pencil-square' : 'bi bi-floppy-fill' }}" />

                            <x-base-button type="reset" class="stext-light rounded-2" variant="outline-danger"
                                label="Hapus" icon="bi bi-trash3-fill" />
                        </div>
                    </div>
                </x-form>
            </x-card>
        </div>
    </div>
@endsection
