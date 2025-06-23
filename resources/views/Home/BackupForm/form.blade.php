@extends('layouts.app')
@section('title', 'Restore Database')
@section('icon', 'fas fa-database')
@section('breadcrumb', Str::upper('Restore Database'))
@section('content')
    <x-bread-crumbs :items="[['text' => 'Restore']]" />
    <div class="row">
        <div class="col-12 col-xl-12">
            @if ($message = Session::get('success'))
                <x-alert type="success" message="{{ $message }}" />
            @endif

            @if ($message = Session::get('error'))
                <x-alert type="danger" message="{{ $message }}" />
            @endif

            <div class="row align-items-center mb-3">
                <div class="col-xl-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    <x-link url="/home" icon="bi bi-arrow-left-circle" label="Kembali" class="btn btn-danger btn-sm" />
                </div>
            </div>

            <x-card class="shadow-sm overflow-hidden" bodyClass="text-bg-light shadow-sm p-4"
                headerClass="text-uppercase text-bg-dark p-3" titleClass="text-start fs-5">
                {{-- title --}}
                <x-slot name="header">
                    <h5 class="card-title text-start mb-0">Form Restore</h5>
                </x-slot>
                {{-- content --}}
                <x-form url="/restore/store">
                    <div class="col-xl-5 mb-2 d-flex justify-content-center">
                        <img id="preview" src="{{ asset('assets/icon/no-image.svg') }}" width="250" height="250"
                            alt="">
                    </div>
                    <div class="mb-3 row align-items-center">
                        <div class="col-xl-5">
                            <x-form-input name="restore" type="file" accept=".sql" :value="old('restore')" />
                            <x-base-button class="btn-primary mt-3" :block="true" label="Restore" variant="primary" />
                        </div>
                    </div>
                </x-form>
            </x-card>
        </div>
    </div>
@endsection
