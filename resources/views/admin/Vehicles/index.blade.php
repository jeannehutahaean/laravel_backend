@extends('admin.layouts.app')
@section('title', 'Manajemen Kendaraan')
@section('content')

<h1 class="text-2xl font-semibold mb-4 text-white">Daftar Kendaraan</h1>

<a href="{{ route('admin.vehicles.create') }}"
   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded mb-4 w-48 text-center">
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
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"><b>Plat Nomor</b></th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"><b>Model</b></th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"><b>Aksi</b></th>
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
                    <button onclick="showDeleteModal('{{ $vehicle->id }}')"
                            class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-5 rounded w-32 text-center">
                        Hapus
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm w-full">
        <h3 class="text-lg font-semibold mb-4">Konfirmasi Hapus</h3>
        <p class="mb-6">Apakah Anda yakin ingin menghapus kendaraan ini?</p>
        <div class="flex justify-end space-x-3">
            <button onclick="hideDeleteModal()"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                Tidak
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function showDeleteModal(vehicleId) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = `/admin/vehicles/${vehicleId}`;
        modal.classList.remove('hidden');
    }

    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>

@endsection