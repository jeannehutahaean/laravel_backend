@extends('layouts.main')

<!-- komentar -->

@section('content')
<div class="container">
    <h2>Selamat Datang, {{ Auth::user()->name }}</h2>
    <p>Ini adalah dashboard.</p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
@endsection
