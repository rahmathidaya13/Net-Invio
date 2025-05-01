@extends('layouts.app')
@section('title', 'Form User')
@section('icon', 'fas fa-user-plus')
@section('breadcrumb', Str::upper('Form User'))
@section('content')
    <div class="row">
        <div class="col-12 col-lg-12">
            @if ($message = Session::get('success'))
                <x-alert type="info" :message="$message" />
            @endif

            <div class="card">
                <div class="card-body p-5">
                    <x-form url="{{ isset($user) ? '/user/update' : '/user/store' }}"
                        parameters="{{ isset($user) ? $user->id : null }}" method="{{ isset($user) ? 'put' : null }}">

                        {{-- input field --}}
                        <x-horizontal-input type="text" name="name" label="Nama" :value="$user->name ?? ''" />
                        <x-horizontal-input :readonly="$user->email ?? false" type="text" name="email" label="Email"
                            :value="$user->email ?? ''" />
                        <x-horizontal-input :readonly="$user->password ?? false" type="password" name="password" label="Password" />
                        <x-horizontal-input :readonly="$user->password ?? false" type="password" name="password_confirmation"
                            label="Password Confirmation" />

                        {{-- check box field --}}
                        <div class="mb-3 row align-items-center">
                            <x-form-label value="Hak Akses" class="col-sm-2 col-form-label" />
                            <div class="col-sm-4 d-flex align-items-center gap-2 flex-wrap">
                                <x-form-check-box name="can_view" label="Can View" :checked="old('can_view', $user->can_view ?? false)" />
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
                            <label for="button" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-4">
                                <x-base-button type="reset" variant="outline-secondary" label="Hapus" />
                                <x-base-button type="submit" label="{{ isset($user) ? 'Edit' : 'Simpan' }}"
                                    variant="{{ isset($user) ? 'success' : 'primary ' }}"
                                    icon="{{ isset($user) ? 'fas fa-edit' : 'fas fa-save' }}" />
                            </div>
                        </div>
                    </x-form>

                </div>
            </div>
        </div>
    </div>
@endsection
