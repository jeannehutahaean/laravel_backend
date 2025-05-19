@extends('admin.layouts.app')
@section('title', 'Manajemen Kendaraan')
@section('content')

<h1 class="text-2xl font-semibold mb-4 text-white">Daftar Kendaraan</h1>

<a href="{{ route('admin.vehicles.create') }}"
   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded mb-4 w-48 text-center">
   + Tambah Kendaraan
</a>

@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Plat Nomor</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Model</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-gray-800">
            @foreach ($vehicles as $vehicle)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->plate_number }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->model }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}"
                       class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-5 rounded w-32 text-center mb-2">
                        Edit
                    </a>
                    <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}"
                          method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Yakin hapus?')"
                                class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-5 rounded w-32 text-center">
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
