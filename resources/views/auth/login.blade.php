@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Login</h2>
    @if ($errors->any())
        <div style="color: red">{{ $errors->first() }}</div>
    @endif
    <form action="/login" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
        <p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
    </form>
</div>
@endsection
