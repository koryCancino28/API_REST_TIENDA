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
        <button class="btn btn-primary" id="btnNew" type="button">Nuevo</button>
    </div>
</div>

<table class="table products-table" id="tbl" aria-describedby="Lista de productos">
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

{{-- Modal EDITAR --}}
<div id="productModal" class="modal" hidden aria-hidden="true" role="dialog" aria-labelledby="modalTitleEdit">
    <div class="modal-backdrop" data-close-modal></div>
    <div class="modal-card" role="document">
        <div class="modal-header">
            <h3 id="modalTitleEdit">Editar producto</h3>
        </div>

        <form id="modalFormEdit" class="modal-body">
            <div class="grid grid-2">
                <label>SKU <input name="sku" required></label>
                <label>Nombre <input name="name" required></label>
            </div>
            <label>Descripción <textarea name="description" rows="3"></textarea></label>
            <div class="grid grid-2">
                <label>Precio <input name="price" type="number" step="0.01" min="0" required></label>
                <label>Stock <input name="stock" type="number" min="0" required></label>
            </div>
        </form>

        <div class="modal-footer">
            <button class="btn btn-ghost" type="button" data-close-modal>Cancelar</button>
            <button class="btn btn-primary" type="button" id="btnSaveEdit">Guardar</button>
        </div>
    </div>
</div>

{{-- Modal CREAR --}}
<div id="productCreateModal" class="modal" hidden aria-hidden="true" role="dialog" aria-labelledby="modalTitleCreate">
    <div class="modal-backdrop" data-close-modal></div>
    <div class="modal-card" role="document">
        <div class="modal-header">
            <h3 id="modalTitleCreate">Nuevo producto</h3>
        </div>

        <form id="modalFormCreate" class="modal-body">
            <div class="grid grid-2">
                <label>SKU <input name="sku" required></label>
                <label>Nombre <input name="name" required></label>
            </div>
            <label>Descripción <textarea name="description" rows="3"></textarea></label>
            <div class="grid grid-2">
                <label>Precio <input name="price" type="number" step="0.01" min="0" required></label>
                <label>Stock <input name="stock" type="number" min="0" value="0" required></label>
            </div>
        </form>

        <div class="modal-footer">
            <button class="btn btn-ghost" type="button" data-close-modal>Cancelar</button>
            <button class="btn btn-primary" type="button" id="btnSaveCreate">Guardar</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/products.index.js') }}"></script>
@endsection