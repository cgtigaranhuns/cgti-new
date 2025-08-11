<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CGTI - Coordenação de Gestão de Tecnologia da Informação')</title>
    <meta name="description"
        content="@yield('description', 'Coordenação de Gestão de Tecnologia da Informação do IFPE Campus Garanhuns')">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('image/favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('styles')
</head>

<body>
    <div id="app">
        <!-- Barra do Governo Federal -->
        @include('partials.barra-governo')

        <!-- Header -->
        @include('partials.header')

        <!-- Navigation -->
        @include('partials.navigation')

        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>

    @stack('scripts')
</body>

</html>