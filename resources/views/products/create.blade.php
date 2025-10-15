@extends('layouts.app')
@section('title','Nuevo producto')

@section('content')
<h2>Nuevo producto</h2>
<form id="f">
    <div class="grid">
        <label>SKU <input name="sku" required></label>
        <label>Nombre <input name="name" required></label>
    </div>
    <label>Descripción <textarea name="description"></textarea></label>
    <div class="grid">
        <label>Precio <input name="price" type="number" step="0.01" min="0" required></label>
        <label>Stock <input name="stock" type="number" min="0" value="0" required></label>
    </div>
    <button type="submit">Guardar</button>
    <a href="{{ route('web.products.index') }}" role="button" class="secondary">Volver</a>
</form>
@endsection

@section('scripts')
<script>
    document.querySelector('#f').addEventListener('submit', async (e) => {
        e.preventDefault();
        const fd = new FormData(e.target);
        const body = Object.fromEntries(fd.entries());
        body.price = parseFloat(body.price);
        body.stock = parseInt(body.stock || 0);
        try {
            await Api.request('/products', {
                method: 'POST',
                body: JSON.stringify(body)
            });
            location.href = "{{ route('web.products.index') }}";
        } catch (err) {
            alert(err.message);
        }
    });
</script>
@endsection