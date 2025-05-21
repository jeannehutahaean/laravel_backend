@extends('admin.layouts.app')

@section('title', 'Manajemen Kendaraan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Kendaraan</h1>
            <div class="mt-2 flex items-center">
                <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-4 mr-4">
                    <p class="text-sm font-medium text-gray-600">Total Kendaraan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $vehicles->count() }}</p>
                </div>
            </div>
        </div>
        
        <a href="{{ route('admin.vehicles.create') }}"
           class="mt-4 md:mt-0 inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
               <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
           </svg>
           Tambah Kendaraan
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Plat Nomor
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Model
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($vehicles as $vehicle)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                            {{ $vehicle->plate_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                            {{ $vehicle->model }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}"
                                   class="inline-flex items-center px-3 py-1 border border-yellow-500 rounded-md shadow-sm text-sm font-medium text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:outline-none">
                                    Edit
                                </a>
                                <button onclick="showDeleteModal('{{ $vehicle->id }}')"
                                        class="inline-flex items-center px-3 py-1 border border-red-500 rounded-md shadow-sm text-sm font-medium text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none">
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

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg border-2 border-gray-200 p-6 max-w-sm w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus</h3>
        <p class="mb-6 text-gray-600">Apakah Anda yakin ingin menghapus kendaraan ini?</p>
        <div class="flex justify-end space-x-3">
            <button onclick="hideDeleteModal()"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                Tidak
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none">
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