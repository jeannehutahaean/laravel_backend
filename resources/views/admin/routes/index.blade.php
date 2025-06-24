@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Rute</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.routes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">
        + Tambah Rute
    </a>

    <table class="w-full table-auto border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Shipment ID</th>
                <th class="p-2 border">Nama Lokasi</th>
                <th class="p-2 border">Koordinat</th>
                <th class="p-2 border">Urutan</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($routes as $route)
            <tr class="text-center">
                <td class="border p-2">{{ $route->id }}</td>
                <td class="border p-2">{{ $route->shipment_id }}</td>
                <td class="border p-2">{{ $route->location_name }}</td>
                <td class="border p-2">{{ $route->latitude }}, {{ $route->longitude }}</td>
                <td class="border p-2">{{ chr(64 + $route->route_order) }}</td>
                <td class="border p-2">
                    <a href="{{ route('admin.routes.edit', $route->id) }}" class="text-blue-600 hover:underline">Edit</a> |
                    <form method="POST" action="{{ route('admin.routes.destroy', $route->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin ingin hapus?')" class="text-red-600 hover:underline">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
