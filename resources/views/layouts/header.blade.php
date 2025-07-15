<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Net-Invio adalah solusi sistem manajemen persediaan barang yang membantu mengelola stok barang dengan mudah dan efisien.">
    <meta name="keywords"
        content="Inventory, Manajemen Persediaan, Stok Barang, Sistem Inventory, Net-Invio, Manajemen Barang, Gudang, Barang, Aplikasi Inventory">
    <meta name="author" content="Net-Invio">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta property="og:site_name" content="Net-Invio" />
    <meta property="og:title" content="Net-Invio" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/icon/logo.png') }}" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="sb-nav-fixed text-bg-light">
