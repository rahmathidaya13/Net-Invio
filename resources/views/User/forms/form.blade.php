@extends('layouts.app')
@section('title', 'Buat Pengguna Baru')
@section('icon', 'fas fa-user-plus')
@section('breadcrumb', Str::upper('Pengguna Baru'))
@section('content')
    <x-bread-crumbs :items="[['text' => 'Daftar Pengguna', 'url' => '/user/list'], ['text' => 'Tambah Pengguna']]" />

    <div class="row">
        <div class="col-12 col-lg-12">
            @if ($message = Session::get('success'))
                <x-alert type="info" :message="$message" />
            @endif
            <div class="row align-items-center mb-3">
                <div class="col-lg-6 mb-2 mb-lg-0 d-flex flex-wrap align-items-center gap-1 justify-content-start">
                    <x-link url="/user/list" icon="bi bi-arrow-left-circle" label="Kembali"
                        class="btn btn-outline-danger btn-sm" />
                </div>
            </div>
            <div class="card overflow-hidden">
                <div class="card-header text-bg-dark p-3 ">
                    <h5 class="card-title text-start mb-0 text-uppercase">Form Users</h5>
                </div>
                <div class="card-body p-4">
                    <x-form url="{{ isset($user) ? '/user/update' : '/user/store' }}"
                        parameters="{{ isset($user) ? $user->id : null }}" method="{{ isset($user) ? 'put' : null }}">

                        {{-- input field --}}
                        <div class="row mb-3">
                            <x-form-label value="Nama" for="name" class="col-sm-2 col-form-label form-label" />
                            <div class="col-sm-5">
                                <x-form-input name="name" label="Nama" :value="$user->name ?? ''" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <x-form-label value="Email" for="email" class="col-sm-2 col-form-label form-label" />
                            <div class="col-sm-5">
                                <x-form-input :readonly="$user->email ?? false" name="email" label="Email" :value="$user->email ?? ''" />
                            </div>
                        </div>

                        @if (empty($user->password))
                            <div class="row mb-3">
                                <x-form-label value="Password" for="password" class="col-sm-2 col-form-label form-label" />
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password')
                                            is-invalid
                                        @enderror"
                                            name="password" id="password"
                                            value="{{ old('password', $user->password ?? false) }}">
                                        <span class="input-group-text rounded-0"> <i class="bi bi-eye-fill "
                                                id="showPass"></i>
                                        </span>
                                        @error('password')
                                            <div class="invalid-feedback d-block" role="alert">
                                                {{ $message ?? '' }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <x-form-label value="Password Confirmation" for="password_confirmation"
                                    class="col-sm-2 col-form-label form-label" />
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password_confirmation')
                                            is-invalid
                                        @enderror"
                                            name="password_confirmation" id="password_confirmation"
                                            value="{{ old('password_confirmation', $user->password ?? false) }}">
                                        <span class="input-group-text rounded-0"> <i class="bi bi-eye-fill "
                                                id="showPassConfirm"></i>
                                        </span>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback d-block" role="alert">
                                                {{ $message ?? '' }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- check box field --}}
                        <div class="mb-3 row align-items-center">
                            <x-form-label value="Hak Akses" class="col-sm-2 col-form-label form-label" />
                            <div class="col-sm-4 d-flex align-items-center gap-2 flex-wrap">
                                <x-form-check-box name="can_view" label="Can View" :checked="old('can_view', $user->can_view ?? true)" />
                                <x-form-check-box name="can_add" label="Can Add" :checked="old('can_add', $user->can_add ?? false)" />
                                <x-form-check-box name="can_edit" label="Can Edit" :checked="old('can_edit', $user->can_edit ?? false)" />
                                <x-form-check-box name="can_delete" label="Can Delete" :checked="old('can_delete', $user->can_delete ?? false)" />
                                @error('akses')
                                    <div class="text-danger small">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <div class="offset-sm-2 d-grid d-lg-block gap-2">
                                <x-base-button type="submit" class="text-light rounded-2 shadow-sm"
                                    variant="{{ isset($user) ? 'success' : 'primary' }}"
                                    label="{{ isset($user) ? 'Ubah' : 'Simpan' }}"
                                    icon="{{ isset($user) ? 'bi bi-pencil-square' : 'bi bi-floppy-fill' }}" />

                                <x-base-button type="reset" class="stext-light rounded-2" variant="outline-danger"
                                    label="Hapus" icon="bi bi-trash3-fill" />
                            </div>
                        </div>
                    </x-form>

                </div>
            </div>
        </div>
    </div>
@endsection
