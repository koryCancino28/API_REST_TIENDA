@extends('layouts.app')
@section('title','Dashboard')

@section('content')
<h2>Dashboard</h2>
<p>Bienvenido, {{ auth()->user()->name }}.</p>
<ul>
    <li><a href="{{ route('web.products.index') }}">Gestionar Productos</a></li>
    <li><a href="{{ route('web.inventory.index') }}">Movimientos de Inventario</a></li>
</ul>
@endsection