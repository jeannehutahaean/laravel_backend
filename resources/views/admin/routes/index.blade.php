@extends('admin.layouts.app')

@section('title', 'Manajemen Rute')

@section('content')
    <h1>Daftar Rute</h1>
    <a href="#" class="btn btn-primary mb-2">+ Tambah Rute</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tujuan</th>
                <th>Estimasi Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($routes as $route)
                <tr>
                    <td>{{ $route->destination }}</td>
                    <td>{{ $route->estimated_time }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
