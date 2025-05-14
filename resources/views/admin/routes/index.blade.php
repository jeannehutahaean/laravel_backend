@extends('admin.layouts.app')

@section('title', 'Manajemen Rute')

@section('content')
<h1>Manajemen Rute</h1>
<a href="{{ route('admin.routes.create') }}" class="btn btn-primary mb-3">+ Tambah Rute</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Shipment ID</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Timestamp</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($routes as $route)
        <tr>
            <td>{{ $route->id }}</td>
            <td>{{ $route->shipment_id }}</td>
            <td>{{ $route->latitude }}</td>
            <td>{{ $route->longitude }}</td>
            <td>{{ $route->timestamp }}</td>
            <td>
                <a href="{{ route('admin.routes.edit', $route->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.routes.destroy', $route->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus rute ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
