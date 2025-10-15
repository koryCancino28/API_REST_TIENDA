@extends('layouts.app')
@section('title','Editar producto')

@section('content')
<h2>Editar producto #{{ $id }}</h2>
<form id="f">
    <div class="grid">
        <label>SKU <input name="sku"></label>
        <label>Nombre <input name="name"></label>
    </div>
    <label>Descripción <textarea name="description"></textarea></label>
    <div class="grid">
        <label>Precio <input name="price" type="number" step="0.01" min="0"></label>
        <label>Stock <input name="stock" type="number" min="0"></label>
    </div>
    <button type="submit">Actualizar</button>
    <a href="{{ route('web.products.index') }}" role="button" class="secondary">Volver</a>
</form>
@endsection

@section('scripts')
<script>
    (async function() {
        const id = {
            $id
        };
        const f = document.querySelector('#f');
        // carga
        const res = await Api.request(`/products/${id}`);
        const p = res.data;
        f.sku.value = p.sku;
        f.name.value = p.name;
        f.description.value = p.description || '';
        f.price.value = p.price;
        f.stock.value = p.stock;

        f.addEventListener('submit', async (e) => {
            e.preventDefault();
            const payload = {
                sku: f.sku.value,
                name: f.name.value,
                description: f.description.value,
                price: parseFloat(f.price.value),
                stock: parseInt(f.stock.value || 0)
            };
            try {
                await Api.request(`/products/${id}`, {
                    method: 'PUT',
                    body: JSON.stringify(payload)
                });
                location.href = "{{ route('web.products.index') }}";
            } catch (err) {
                alert(err.message);
            }
        });
    })();
</script>
@endsection