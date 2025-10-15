@extends('layouts.app')
@section('title','Iniciar sesión')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

<div class="login-card">
    <h2 class="login-title">Iniciar sesión</h2>

    {{-- Pasar errores del servidor al JS externo sin mostrarlos aquí --}}
    @if($errors->any())
    <div id="login-errors" data-errors='@json($errors->all())' hidden></div>
    @endif

    {{-- Mensaje opcional (por ejemplo después de logout) --}}
    @if(session('status'))
    <div id="login-status" data-status='@json(session("status"))' hidden></div>
    @endif

    <form id="loginForm" method="POST" action="{{ route('web.login.post') }}" class="login-form">
        @csrf

        <label class="form-label">Email
            <input type="email" name="email" value="{{ old('email') }}" required class="form-input" autocomplete="username">
        </label>

        <label class="form-label">Contraseña
            <input type="password" name="password" required class="form-input" autocomplete="current-password">
        </label>

        <button type="submit" class="btn-primary">Entrar</button>
    </form>
</div>

{{-- Solo referencias a archivos, nada de JS embebido --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/login.js') }}"></script>
@endsection