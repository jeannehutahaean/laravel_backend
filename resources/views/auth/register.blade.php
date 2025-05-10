@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Register</h2>
    @if ($errors->any())
        <div style="color: red">{{ $errors->first() }}</div>
    @endif
    <form action="/register" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nama Lengkap" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required><br>
        <button type="submit">Daftar</button>
        <p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
    </form>
</div>
@endsection
