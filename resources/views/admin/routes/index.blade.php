@extends('admin.layouts.app')

@section('title', 'Manajemen Rute Pengiriman')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Rute Pengiriman</h1>
            <div class="mt-2 flex items-center">
                <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-4 mr-4">
                    <p class="text-sm font-medium text-gray-600">Total Rute</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $routes->count() }}</p>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.routes.create') }}"
           class="mt-4 md:mt-0 inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
               <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
           </svg>
           Tambah Rute
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-100 border-l-4 border-green-500 text-green-700">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Table Section -->
    <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Start Koordinat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">End Koordinat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Final?</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($routes as $route)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $route->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $route->location_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $route->start_latitude }}, {{ $route->start_longitude }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $route->end_latitude }}, {{ $route->end_longitude }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($route->is_final_destination)
                                <span class="text-green-600 font-semibold">Ya</span>
                            @else
                                <span class="text-gray-600">Tidak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-2">
                                <button onclick="showEditModal('{{ $route->id }}')"
                                    class="inline-flex items-center px-3 py-1.5 rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700">
                                    Edit
                                </button>
                                <button onclick="showDeleteModal('{{ $route->id }}')"
                                        class="inline-flex items-center px-3 py-1.5 rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg border border-gray-200 p-6 w-full max-w-md mx-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Konfirmasi Edit</h3>
        <p class="mb-6 text-gray-600">Apakah Anda yakin ingin mengedit rute ini?</p>
        <div class="flex justify-end space-x-4">
            <button onclick="hideEditModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-md hover:bg-gray-100">Batal</button>
            <a id="editConfirmLink" href="#" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">Edit</a>
        </div>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg border border-gray-200 p-6 w-full max-w-md mx-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Konfirmasi Hapus</h3>
        <p class="mb-6 text-gray-600">Apakah Anda yakin ingin menghapus rute ini?</p>
        <div class="flex justify-end space-x-4">
            <button onclick="hideDeleteModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-md hover:bg-gray-100">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    function showEditModal(id) {
        const modal = document.getElementById('editModal');
        document.getElementById('editConfirmLink').href = `/admin/routes/${id}/edit`;
        modal.classList.remove('hidden');
    }

    function hideEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function showDeleteModal(id) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = `/admin/routes/${id}`;
        modal.classList.remove('hidden');
    }

    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
