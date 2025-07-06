@extends('layouts.app')
@section('title', 'Halaman Profile')
@section('icon', 'bi bi-person-bounding-box')
@section('breadcrumb', Str::upper('Profile'))
@section('content')
    <x-bread-crumbs :items="[['text' => 'Profile', 'url' => '/profile']]" />
    <div class="row">
        <div class="col-xl-12 col-12">
            @if ($message = Session::get('success'))
                <x-alert type="success" message="{{ $message }}" />
            @endif
            <x-card class="shadow-sm overflow-hidden" bodyClass="text-bg-light shadow-sm p-4"
                headerClass="text-uppercase text-bg-dark rounded-0 p-3" titleClass="text-start fs-5">
                {{-- title --}}
                <x-slot name="header">
                    <h5 class="card-title text-start mb-0">Detail Profile</h5>
                </x-slot>
                {{-- content --}}
                <div class="row">
                    <div class="col-xl-3 text-center mb-3">
                        <div class="position-relative">
                            <img id="preview"
                                src="{{ asset(isset($user) && $user->profile->image ? '/assets/profile/' . $user->profile->image : 'assets/image/no-image.svg') }}"
                                alt="Foto Profil" class="shadow img-profile img-fluid mb-1">
                            <label for="pic_profile"
                                class="btn d-block d-xl-block rounded-0 shadow-sm {{ isset($user) && $user->profile->image ? 'btn-success' : 'btn-primary' }}">
                                {{ isset($user) && $user->profile->image ? 'Change Image' : 'Upload Image' }}
                                <x-form-input name="pic_profile" class="d-none" type="file" accept="image/*" />
                            </label>

                        </div>
                    </div>
                    <div class="col-xl-6 text-bg-light shadow-sm border p-3">
                        <x-form url="/profile/update" :parameters="$user->id" method="put">
                            <div class="mb-3">
                                <x-form-label for="name" value="Nama" />
                                <x-form-input name="name" :value="old('name', $user->name)" />
                            </div>
                            <div class="mb-3">
                                <x-form-label for="birthdate" value="Tanggal Lahir" />
                                <x-form-input type="date" name="birthdate" :value="old('birthdate', $user->profile->birthdate ?? '')" />
                            </div>
                            <div class="mb-3">
                                <x-form-label for="gender" value="Jenis Kelamin" />
                                <x-form-select name="gender" :options="[
                                    'laki-laki' => 'Laki-laki',
                                    'perempuan' => 'Perempuan',
                                ]" :selected="old('gender', $user->profile->gender ?? '')"
                                    text="Pilih Jenis Kelamin" />
                            </div>
                            <div class="mb-3">
                                <x-form-label for="email" value="Email" />
                                <x-form-input readonly name="email" :value="old('email', $user->email)" />
                            </div>
                            <div class="mb-3">
                                <x-form-label for="phone" value="No.Handphone" />
                                <x-form-input name="phone" :value="old('phone', $user->profile->phone ?? '')" />
                            </div>
                            <div class="mb-3">
                                <x-form-label for="position" value="Jabatan" />
                                <x-form-input name="position" :value="old('position', $user->profile->position ?? '')" />
                            </div>

                            <div class="mb-3">
                                <x-form-label for="address" value="Alamat" />
                                {{-- <x-form-input name="phone" :value="old('phone')" /> --}}
                                <x-text-area name="address" :value="old('address', $user->profile->address ?? '')" />
                            </div>
                            <div id="picture_profile"></div>
                            <div class="mb-3">
                                <x-base-button type="submit" class="text-light rounded-2 shadow-sm" variant="success"
                                    label="Perbarui" icon="bi bi-arrow-clockwise" />
                                <x-base-button type="reset" class=" rounded-2" variant="outline-danger" label="Hapus"
                                    icon="bi bi-trash3-fill" />
                            </div>

                        </x-form>

                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endsection
