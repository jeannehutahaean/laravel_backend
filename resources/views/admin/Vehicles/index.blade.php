@extends('admin.layouts.app')
@section('title', 'Manajemen Kendaraan')
@section('content')
<h1>Daftar Kendaraan</h1>
<a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary mb-2">+ Tambah Kendaraan</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Plat Nomor</th>
            <th>Model</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vehicles as $vehicle)
        <tr>
            <td>{{ $vehicle->plate_number }}</td>
            <td>{{ $vehicle->model }}</td>
            <td>
                <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
