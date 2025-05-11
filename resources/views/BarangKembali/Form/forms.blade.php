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
                <div class="row">
                    <div class="col-12 col-xl-8">
                        <x-form url="{{ isset($barang_kembali) ? '/retur/update' : '/retur/store' }}"
                            method="{{ isset($barang_kembali) ? 'put' : null }}"
                            parameters="{{ $barang_kembali->id_retur ?? '' }}">

                            <div class="mb-3 row align-items-center">
                                <x-form-label for="tanggal" value="Tanggal" class="form-label col-sm-3 col-form-label" />
                                <div class="col-sm-7">
                                    <x-form-input autofocus :readonly="isset($barang_kembali) && $barang_kembali->id_retur" type="date" name="tanggal" label="Tanggal"
                                        value="{{ old('tanggal', $barang_kembali->tanggal ?? '') }}" />
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <x-form-label for="kode_retur" value="Kode Retur"
                                    class="form-label col-sm-3 col-form-label" />
                                <div class="col-sm-7">
                                    <x-form-input name="kode_retur" label="Kode Retur"
                                        value="{{ old('kode_retur', $barang_kembali->kode_retur ?? '') }}" />
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <x-form-label for="barang" value="Barang" class="col-sm-3 col-form-label form-label" />
                                <div class="col-sm-7">
                                    @php
                                        $optionBarang = [];
                                        foreach ($barang as $item) {
                                            $optionBarang[$item->id_barang] = $item->nama_barang;
                                        }
                                    @endphp
                                    <x-form-select class="select2" name="barang" text="---Pilih Barang---"
                                        :options="$optionBarang"
                                        selected="{{ old('barang', $barang_kembali->id_barang ?? '') }}" />
                                </div>
                                <input type="text" class="d-none" name="id_barang" id="id_barang"
                                    value="{{ $barang_kembali->id_barang ?? '' }}">
                            </div>

                            <div class="mb-3 row align-items-center">

                                <div class="col-sm-3 col-form-label ">
                                    <x-form-label for="pelanggan" value="Pelanggan" class="form-label d-block mb-0" />
                                    <em class="text-muted small-sm text-truncate">Select if from customer</em>
                                </div>
                                <div class="col-sm-7">
                                    @php
                                        $optionPelanggan = [];
                                        foreach ($pelanggan as $item) {
                                            $optionPelanggan[$item->id_pelanggan] = $item->nama;
                                        }
                                    @endphp
                                    <x-form-select class="select2" name="pelanggan" text="---Pilih Pelanggan---"
                                        :options="$optionPelanggan"
                                        selected="{{ old('pelanggan', $barang_kembali->id_pelanggan ?? '') }}" />
                                </div>
                                <input type="text" class="d-none" name="id_pelanggan" id="id_pelanggan"
                                    value="{{ $barang_kembali->id_pelanggan ?? '' }}">
                            </div>

                            <div class="mb-3 row align-items-center">
                                <div class="col-sm-3 col-form-label">
                                    <x-form-label for="supplier" value="Supplier" class="form-label d-block mb-0" />
                                    <em class="text-muted small-sm text-truncate">Select if from supplier</em>
                                </div>
                                <div class="col-sm-7">
                                    @php
                                        $optionSupplier = [];
                                        foreach ($supplier as $item) {
                                            $optionSupplier[$item->id_supplier] = $item->nama;
                                        }
                                    @endphp
                                    <x-form-select class="select2" name="supplier" text="---Pilih Supplier---"
                                        :options="$optionSupplier"
                                        selected="{{ old('supplier', $barang_kembali->id_supplier ?? '') }}" />
                                </div>
                                <input type="text" class="d-none" name="id_supplier" id="id_supplier"
                                    value="{{ $barang_kembali->id_supplier ?? '' }}">
                            </div>

                            <div class="mb-3 row align-items-center">
                                <x-form-label for="jumlah" value="Jumlah Retur"
                                    class="col-sm-3 col-form-label form-label" />
                                <div class="col-sm-7">
                                    <x-form-input name="jumlah" label="Jumlah Retur"
                                        value="{{ old('jumlah', $barang_kembali->jumlah ?? '') }}" />
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <x-form-label for="tipe_retur" value="Tipe Retur"
                                    class="col-sm-3 col-form-label form-label" />
                                <div class="col-sm-7">
                                    <x-form-select class="select2" name="tipe_retur" text="---Pilih Tipe Retur---"
                                        :options="['masuk' => 'Masuk', 'keluar' => 'Keluar']"
                                        selected="{{ old('tipe_retur', $barang_kembali->tipe_retur ?? '') }}" />
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <x-form-label for="status" value="Status Retur"
                                    class="col-sm-3 col-form-label form-label" />
                                <div class="col-sm-7">
                                    <x-form-select class="select2" name="status" text="---Pilih Status Retur---"
                                        :options="[
                                            'diganti' => 'Diganti',
                                            'tidak_diganti' => 'Tidak Diganti',
                                            'diperbaiki' => 'Diperbaiki',
                                        ]"
                                        selected="{{ old('status', $barang_kembali->status_pergantian ?? '') }}" />
                                </div>
                            </div>

                            {{-- <x-horizontal-input type="file" name="gambar" label="Gambar" accept="image/*" /> --}}

                            <div class="mb-3 row align-items-center">
                                <x-form-label value="Gambar" class="col-sm-3 col-form-label form-label" />
                                <div class="col-sm-7 d-flex gap-2 justify-content-between position-relative"
                                    id="gambar-container">
                                    @for ($i = 0; $i < 3; $i++)
                                        @php
                                            $getId = 'gambar-' . $i;
                                        @endphp
                                        <x-form-label for="{{ $getId }}" style="cursor: pointer">
                                            <img id="preview-{{ $i }}"
                                                src="{{ asset('assets/image/plussimage.svg') }}"
                                                alt="Gambar-{{ $i + 1 }}"
                                                class="rounded-2 border border-secondary shadow-sm img-fluid">
                                        </x-form-label>
                                        <input type="file" class="d-none gambar-input" name="gambar[]"
                                            id="{{ $getId }}" accept="image/*" multiple>
                                    @endfor
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <x-form-label for="alasan" value="Alasan" class="col-sm-3 col-form-label form-label" />
                                <div class="col-sm-7">
                                    <x-text-area name="alasan"
                                        value="{{ old('alasan', $barang_kembali->alasan ?? '') }}" />
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <x-form-label class="col-sm-3 col-form-label form-label" />
                                <div class="col-sm-7 d-grid d-lg-block gap-2">
                                    <x-base-button type="submit" class="text-light rounded-2 shadow-sm"
                                        variant="{{ isset($barang_kembali) ? 'success' : 'primary' }}"
                                        label="{{ isset($barang_kembali) ? 'Ubah' : 'Simpan' }}"
                                        icon="{{ isset($barang_kembali) ? 'bi bi-pencil-square' : 'bi bi-floppy-fill' }}" />

                                    <x-base-button type="reset" class="stext-light rounded-2" variant="outline-danger"
                                        label="Hapus" icon="bi bi-trash3-fill" />
                                </div>
                            </div>
                        </x-form>
                    </div>
                    @if (isset($barang_kembali))
                        <div class="col-12 col-xl-4">
                            <div class="d-flex flex-column gap-2 rounded-3 border border-dark-subtle shadow-sm p-2">
                                <h6 class="text-center text-uppercase fw-bold">Current Image</h6>
                                <div class="d-flex flex-wrap justify-content-center">
                                    @foreach (explode(',', $barang_kembali->path) as $img)
                                        <img src="{{ asset($barang_kembali->path ? $img : 'assets/image/no-image.svg') }}"
                                            alt="Gambar"
                                            class="rounded-2 border border-secondary shadow-sm img-fluid img-edit-view">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
            </x-card>
        </div>
    </div>
@endsection
