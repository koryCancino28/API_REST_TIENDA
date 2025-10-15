<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>@yield('title','Tienda')</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="api-base" content="{{ url('/api/v1') }}">
    <meta name="api-token" content="{{ session('api_token') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    @yield('head')
</head>

<body>
    <nav class="container-fluid">
        <ul>
            <li><strong>Tienda</strong></li>
        </ul>
        <ul>
            {{-- Nada aquí: el icono de usuario aparece solo en el dashboard --}}
        </ul>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>