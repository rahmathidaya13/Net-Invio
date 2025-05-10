@extends('layouts.app')
@section('title', isset($pelanggan) ? 'Ubah Data Pelanggan' : 'Tambah Data Pelanggan')
@section('icon', isset($pelanggan) ? 'bi bi-pencil-square' : 'bi bi-plus-square-fill')
@section('breadcrumb', Str::upper(isset($pelanggan) ? 'Ubah Data Pelanggan' : 'Tambah Data Pelanggan'))
@section('content')
    <x-bread-crumbs :items="[
        ['text' => 'Daftar Pelanggan', 'url' => '/pelanggan/list'],
        ['text' => ucwords(isset($pelanggan) ? 'Ubah Data Pelanggan' : 'Tambah Data Pelanggan')],
    ]" />
    <div class="row">
        <div class="col-12 col-lg-12">
            @if ($message = Session::get('success'))
                <x-alert type="info" message="{{ $message }}" />
            @endif

            <div class="row align-items-center mb-3">
                <div class="col-lg-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    <x-link url="/pelanggan/list" icon="bi bi-arrow-left-circle" label="Kembali"
                        class="btn btn-danger btn-sm" />
                </div>
            </div>
            <x-card class="shadow-sm rounded-0" bodyClass="text-bg-light shadow-sm border border-light p-4"
                headerClass="text-uppercase text-bg-dark rounded-0 p-3" titleClass="text-start fs-5">
                {{-- title --}}
                <x-slot name="header">
                    <h5 class="card-title text-start mb-0">Form Pelanggan</h5>
                </x-slot>
                {{-- content --}}

                <x-form url="{{ isset($pelanggan) ? '/pelanggan/update' : '/pelanggan/store' }}"
                    method="{{ isset($pelanggan) ? 'put' : null }}" parameters="{{ $pelanggan->id_pelanggan ?? '' }}">
                    <x-horizontal-input autofocus type="date" name="tanggal" label="Tanggal"
                        value="{{ old('tanggal', $pelanggan->tanggal ?? '') }}" />



                    <x-horizontal-input placeholder="NIK/SIM" name="nid" label="No.Identitas"
                        value="{{ old('nid', $pelanggan->no_identitas ?? '') }}" />

                    <x-horizontal-input placeholder="jhonedoe" name="nama_pelanggan" label="Nama Pelanggan"
                        value="{{ old('nama_pelanggan', $pelanggan->nama ?? '') }}" />
                    <div class="mb-3 row align-items-center">
                        <x-form-label for="jk" value="Jenis Kelamin" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-form-select name="jk" :options="['laki-laki' => 'Laki-laki', 'perempuan' => 'Perempuan']" text="Pilih Jenis Kelamin"
                                selected="{{ old('jk', $pelanggan->jenis_kelamin ?? '') }}" />
                        </div>
                    </div>

                    <x-horizontal-input type="email" placeholder="@example.com" name="email" label="Email"
                        value="{{ old('email', $pelanggan->email ?? '') }}" />

                    <x-horizontal-input placeholder="0812000..." name="nohp" label="No.Handphone"
                        value="{{ old('nohp', $pelanggan->nohp ?? '') }}" />
                    <div class="mb-3 row align-items-center">
                        <x-form-label for="alamat" value="Alamat" class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5">
                            <x-text-area name="alamat" value="{{ old('alamat', $pelanggan->alamat ?? '') }}" />
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <x-form-label class="col-sm-2 col-form-label form-label" />
                        <div class="col-sm-5 d-grid d-lg-block gap-2">
                            <x-base-button type="submit" class="text-light rounded-2 shadow-sm"
                                variant="{{ isset($pelanggan) ? 'success' : 'primary' }}"
                                label="{{ isset($pelanggan) ? 'Ubah' : 'Simpan' }}"
                                icon="{{ isset($pelanggan) ? 'bi bi-pencil-square' : 'bi bi-floppy-fill' }}" />

                            <x-base-button type="reset" class="stext-light rounded-2" variant="outline-danger"
                                label="Hapus" icon="bi bi-trash3-fill" />
                        </div>
                    </div>
                </x-form>
            </x-card>
        </div>
    </div>
@endsection
