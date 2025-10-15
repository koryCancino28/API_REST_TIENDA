@extends('layouts.app')
@section('title','Productos')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/products.css') }}">
@endsection

@section('content')
<div class="actions">
    <h2 class="page-title">Productos</h2>
    <div class="actions-right">
        <a href="{{ route('web.dashboard') }}" class="btn btn-ghost" id="btnBack">Volver</a>
        {{-- AHORA ES BOTÓN, NO LINK: ABRE MODAL DE REGISTRO --}}
        <button class="btn btn-primary" id="btnNew" type="button">Nuevo</button>
    </div>
</div>

<table class="table products-table" id="tbl"
    data-edit-base="{{ url('/products') }}" aria-describedby="Lista de productos">
    <thead>
        <tr>
            <th>ID</th>
            <th>SKU</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th class="col-actions" aria-label="Acciones"></th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

{{-- Modal (reutilizable para CREAR y EDITAR) --}}
<div id="productModal" class="modal" hidden aria-hidden="true" role="dialog" aria-labelledby="modalTitle">
    <div class="modal-backdrop" data-close-modal></div>
    <div class="modal-card" role="document">
        <div class="modal-header">
            <h3 id="modalTitle">Registrar producto</h3>
            <button class="modal-close" type="button" data-close-modal aria-label="Cerrar">&times;</button>
        </div>

        <form id="modalForm" class="modal-body">
            <div class="grid grid-2">
                <label>SKU
                    <input name="sku" required>
                </label>
                <label>Nombre
                    <input name="name" required>
                </label>
            </div>
            <label>Descripción
                <textarea name="description" rows="3"></textarea>
            </label>
            <div class="grid grid-2">
                <label>Precio
                    <input name="price" type="number" step="0.01" min="0" required>
                </label>
                <label>Stock
                    <input name="stock" type="number" min="0" value="0" required>
                </label>
            </div>
        </form>

        <div class="modal-footer">
            <button class="btn btn-ghost" type="button" data-close-modal>Cancelar</button>
            <button class="btn btn-primary" type="button" id="btnSaveModal">Guardar</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/products.index.js') }}"></script>
@endsection