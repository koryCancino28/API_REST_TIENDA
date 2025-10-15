@extends('layouts.app')
@section('title','Iniciar sesión')

@section('content')
<article style="max-width:480px;margin:3rem auto">
    <h2>Iniciar sesión</h2>
    @if($errors->any())
    <div role="alert" class="contrast">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    <form method="POST" action="{{ route('web.login.post') }}">
        @csrf
        <label>Email
            <input type="email" name="email" value="{{ old('email','admin@demo.com') }}" required>
        </label>
        <label>Contraseña
            <input type="password" name="password" value="secret" required>
        </label>
        <button type="submit">Entrar</button>
    </form>
</article>
@endsection