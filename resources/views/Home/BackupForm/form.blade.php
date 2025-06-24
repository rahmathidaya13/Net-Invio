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

            <div class="row d-flex justify-content-center text-bg-light border rounded-3 border-secondary-subtle shadow-sm p-3">
                <div class="col-xl-12">
                    <x-form url="/restore/store">
                        <div class="mb-2 d-flex justify-content-center">
                            <img id="preview" src="{{ asset('assets/icon/no-image.svg') }}" width="250" height="250"
                                alt="preview">
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-xl-5">
                                <x-form-input name="restore" type="file" accept=".sql" :value="old('restore')" />
                                <x-base-button icon="fas fa-undo-alt" class="mt-3 text-white rounded-0" :block="true" label="Restore"
                                    variant="info" />
                            </div>
                        </div>
                    </x-form>
                </div>
            </div>


        </div>
    </div>
@endsection
