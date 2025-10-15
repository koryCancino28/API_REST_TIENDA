@extends('layouts.app')
@section('title','Dashboard')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endsection

@section('content')
{{-- Botón flotante de usuario (solo dashboard) --}}
<div class="user-fab" aria-haspopup="true" aria-expanded="false" aria-controls="userPanel" title="Cuenta">
    {{-- ícono usuario (SVG embebido es OK; no es JS) --}}
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Z" stroke="currentColor" stroke-width="1.8" />
        <path d="M20 21a8 8 0 1 0-16 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
    </svg>
</div>

{{-- Mini-modal esquina superior derecha --}}
<div id="userPanel" class="user-panel" role="dialog" aria-modal="false" aria-labelledby="userPanelTitle" hidden>
    <div class="user-panel-header">
        {{-- 1 Ícono/Avatar --}}
        <div class="user-avatar" aria-hidden="true">
            {{ strtoupper(mb_substr(auth()->user()->name,0,1)) }}
        </div>

        {{-- 2 Usuario --}}
        <div class="user-info">
            <div id="userPanelTitle" class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-email">{{ auth()->user()->email }}</div>
        </div>
    </div>

    {{-- 3 Cerrar sesión (estilo enlace subrayado) --}}
    <div class="user-panel-actions">
        <form method="POST" action="{{ route('web.logout') }}">
            @csrf
            <button type="submit" class="link-logout">Cerrar sesión</button>
        </form>
    </div>
</div>


<h2 class="dash-title">Dashboard</h2>

<div class="cards-grid">
    <a class="card" href="{{ route('web.products.index') }}">
        <div class="card-ico" aria-hidden="true">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                <path d="M3 7h18M3 12h18M3 17h18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            </svg>
        </div>
        <div class="card-body">
            <h3>Gestionar Productos</h3>
            <p>Crear, editar, eliminar y buscar productos.</p>
        </div>
    </a>

    <a class="card" href="{{ route('web.inventory.index') }}">
        <div class="card-ico" aria-hidden="true">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                <path d="M4 7h16v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z" stroke="currentColor" stroke-width="1.8" />
                <path d="M9 7V5a3 3 0 0 1 6 0v2" stroke="currentColor" stroke-width="1.8" />
            </svg>
        </div>
        <div class="card-body">
            <h3>Inventario</h3>
            <p>Entradas y salidas de stock (IN / OUT).</p>
        </div>
    </a>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endsection