@extends('layouts.app')
@section('title','Inventario')

@section('content')
<h2>Movimientos de inventario</h2>

<form id="f" class="grid" style="grid-template-columns: 1fr 1fr 1fr 1fr auto; gap:.5rem">
    <input type="number" min="1" name="product_id" placeholder="ID Producto" required>
    <select name="type" required>
        <option value="IN">IN (Entrada)</option>
        <option value="OUT">OUT (Salida)</option>
    </select>
    <input type="number" min="1" name="quantity" placeholder="Cantidad" required>
    <input type="text" name="reason" placeholder="Motivo (compra/venta/ajuste)">
    <button type="submit">Registrar</button>
</form>

<table class="table" id="tbl">
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Tipo</th>
            <th>Cantidad</th>
            <th>Motivo</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
@endsection

@section('scripts')
<script>
    (async function() {
        const tbody = document.querySelector('#tbl tbody');

        async function load() {
            const data = await Api.request('/inventory');
            tbody.innerHTML = '';
            data.data.forEach(m => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
        <td>${m.id}</td>
        <td>${m.product.sku} - ${m.product.name}</td>
        <td>${m.type}</td>
        <td>${m.quantity}</td>
        <td>${m.reason || ''}</td>
        <td>${new Date(m.created_at).toLocaleString()}</td>`;
                tbody.appendChild(tr);
            });
        }

        document.querySelector('#f').addEventListener('submit', async (e) => {
            e.preventDefault();
            const fd = new FormData(e.target);
            const payload = Object.fromEntries(fd.entries());
            payload.quantity = parseInt(payload.quantity);
            try {
                await Api.request('/inventory', {
                    method: 'POST',
                    body: JSON.stringify(payload)
                });
                e.target.reset();
                load();
            } catch (err) {
                alert(err.message);
            }
        });

        await load();
    })();
</script>
@endsection