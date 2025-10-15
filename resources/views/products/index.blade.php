@extends('layouts.app')
@section('title','Productos')

@section('content')
<h2>Productos</h2>

<form id="searchForm" class="grid" style="grid-template-columns:1fr auto; gap: .5rem">
    <input type="search" id="q" placeholder="Buscar por nombre o SKU">
    <a href="{{ route('web.products.create') }}" role="button">Nuevo</a>
</form>

<table class="table" id="tbl">
    <thead>
        <tr>
            <th>ID</th>
            <th>SKU</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th></th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

@endsection

@section('scripts')
<script>
    (async function() {
        const tbody = document.querySelector('#tbl tbody');
        const load = async (search = '') => {
            const data = await Api.request(`/products${search?`?search=${encodeURIComponent(search)}`:''}`);
            tbody.innerHTML = '';
            data.data.forEach(p => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
        <td>${p.id}</td>
        <td>${p.sku}</td>
        <td>${p.name}</td>
        <td>${p.price.toFixed(2)}</td>
        <td>${p.stock}</td>
        <td>
          <a href="{{ url('/products') }}/${p.id}/edit">Editar</a>
          <button data-id="${p.id}" class="outline danger btn-del">Eliminar</button>
        </td>`;
                tbody.appendChild(tr);
            });
            bindDelete();
        };

        function bindDelete() {
            document.querySelectorAll('.btn-del').forEach(btn => {
                btn.onclick = async () => {
                    if (!confirm('¿Eliminar producto?')) return;
                    const id = btn.getAttribute('data-id');
                    await Api.request(`/products/${id}`, {
                        method: 'DELETE'
                    });
                    load(document.querySelector('#q').value);
                };
            });
        }
        document.querySelector('#searchForm').addEventListener('submit', e => {
            e.preventDefault();
            load(document.querySelector('#q').value);
        });

        await load();
    })();
</script>
@endsection