<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SIPENTA')</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Utama -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <!-- CSS Khusus Halaman -->
    @stack('styles')

</head>
<body>

<div class="wrapper">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    <div class="main">

        {{-- Navbar --}}
        @include('layouts.navbar')

        {{-- Isi Halaman --}}
        @yield('content')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>