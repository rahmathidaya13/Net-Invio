@extends('layouts.app')
@section('title', 'Tambah Barang')
@section('icon', 'bi bi-plus-square')
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
                    {{-- this button --}}
                    <x-link url="/barang/list" icon="bi bi-arrow-left-circle" label="Kembali"
                        class="btn btn-primary btn-sm" />
                </div>
            </div>
            <x-card class="shadow-sm rounded-0" bodyClass="text-bg-light shadow-sm border border-light p-3"
                headerClass="text-uppercase" title="Form Barang" titleClass="text-start fs-5">
                <x-form url="/barang/store">
                    <div class="form-group mb-3 flex-row">
                        <x-form-label for="kode_barang" value="Kode Barang" />
                        <x-form-input autofocus name="kode_barang" type="text" value="{{ old('kode_barang') }}" />
                    </div>
                </x-form>
            </x-card>
        </div>
    </div>
@endsection
