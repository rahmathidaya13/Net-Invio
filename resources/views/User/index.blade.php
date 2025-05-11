@extends('layouts.app')
@section('title', 'Daftar Pengguna')
@section('icon', 'fas fa-users')
@section('breadcrumb', Str::upper('Daftar Pengguna'))
@section('content')
<x-bread-crumbs :items="[['text' => 'Daftar Pengguna', 'url' => '/user/list']]" />
    <div class="row">
        <div class="col-12 col-lg-12">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <h5 class="alert-heading"><i class="fas fa-ban"></i> Alert!</h5>
                    <ul class="align-items-center">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-info fw-bold " role="alert" style="font-size: 16px;">
                    <i class="far fa-check-circle text-success mr-2"></i>
                    <span> {{ $message }}</span>
                </div>
            @endif
            <div class="d-lg-flex flex-wrap flex-column flex-lg-row justify-content-lg-between mt-3 mb-3">
                <div class="d-flex flex-row flex-lg-column align-items-center order-2 order-lg-2 mb-lg-0 mb-3 col-lg-3">
                    <div class="input-group input-group-sm ">
                        <input autofocus autocomplete="off" type="search" name="keyword" id="keyword" class="form-control"
                            placeholder="Masukan pencarian...">
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center order-1 order-lg-1">
                    <span class="me-3">Tampilkan hasil: </span>
                    <div class="input-group input-group-sm" style="width: 85px">
                        <select class="form-select form-select-sm" name="limit" id="limit">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <x-table theadColor="success" tbodyId="table_user" class=" "
                            :header="['No', 'Nama', 'Email', 'Role', 'Otorisasi', 'Aksi']">
                            @include('User.partials.table', ['user' => $user])
                        </x-table>
                    </div>
                    <div class="d-flex flex-wrap justify-content-lg-between align-items-center flex-column flex-lg-row p-3">
                        @include('User.partials.informasi', ['user' => $user])
                        @include('User.partials.pagination', ['user' => $user])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
