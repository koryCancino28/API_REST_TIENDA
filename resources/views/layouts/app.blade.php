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
    <style>
        .table {
            width: 100%;
            border-collapse: collapse
        }

        .table th,
        .table td {
            border-bottom: 1px solid #eee;
            padding: .6rem
        }
    </style>
</head>

<body>
    <nav class="container-fluid">
        <ul>
            <li><strong>Tienda</strong></li>
        </ul>
        <ul>
            @auth
            <li><a href="{{ route('web.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('web.products.index') }}">Productos</a></li>
            <li><a href="{{ route('web.inventory.index') }}">Inventario</a></li>
            <li>
                <form method="POST" action="{{ route('web.logout') }}">
                    @csrf
                    <button type="submit" class="secondary">Salir</button>
                </form>
            </li>
            @endauth
        </ul>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <script>
        // Helper global: fetch con token
        window.Api = {
            base: document.querySelector('meta[name="api-base"]').content,
            token: document.querySelector('meta[name="api-token"]').content,
            async request(path, options = {}) {
                const headers = options.headers || {};
                if (this.token) headers.Authorization = `Bearer ${this.token}`;
                headers['Content-Type'] = headers['Content-Type'] || 'application/json';
                const res = await fetch(`${this.base}${path}`, {
                    ...options,
                    headers
                });
                if (!res.ok) {
                    const txt = await res.text();
                    throw new Error(`HTTP ${res.status}: ${txt}`);
                }
                return res.status !== 204 ? res.json() : null;
            }
        };
    </script>

    @yield('scripts')
</body>

</html>