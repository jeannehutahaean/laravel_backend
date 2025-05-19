@extends('admin.layouts.app')
@section('title', 'Edit Kendaraan')
@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Kendaraan</h1>
    
    <form method="POST" action="{{ route('admin.vehicles.update', $vehicle->id) }}" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')
        
        <!-- Tabel Form dengan Tailwind -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <tbody>
                    <tr class="border-b border-gray-200">
                        <td class="py-4 px-4 w-1/3 align-middle">
                            <label for="plate_number" class="block font-semibold text-gray-700">Plat Nomor</label>
                        </td>
                        <td class="py-4 px-4">
                            <input type="text" name="plate_number" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   value="{{ $vehicle->plate_number }}" 
                                   required>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="py-4 px-4 w-1/3 align-middle">
                            <label for="model" class="block font-semibold text-gray-700">Model</label>
                        </td>
                        <td class="py-4 px-4">
                            <select name="model" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                    required>
                                <option value="" disabled>Pilih Model Kendaraan</option>
                                <option value="Avanza" {{ $vehicle->model == 'Avanza' ? 'selected' : '' }}>Avanza</option>
                                <option value="Xenia" {{ $vehicle->model == 'Xenia' ? 'selected' : '' }}>Xenia</option>
                                <option value="Innova" {{ $vehicle->model == 'Innova' ? 'selected' : '' }}>Innova</option>
                                <option value="Fortuner" {{ $vehicle->model == 'Fortuner' ? 'selected' : '' }}>Fortuner</option>
                                <option value="Hiace" {{ $vehicle->model == 'Hiace' ? 'selected' : '' }}>Hiace</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Button Update dengan Tailwind -->
        <div class="mt-6 text-right">
            <button type="submit" 
                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 
                           text-white font-bold py-3 px-6 rounded-full 
                           shadow-md hover:shadow-lg 
                           transition-all duration-300 transform hover:-translate-y-1 
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Update
            </button>
        </div>
    </form>
</div>
@endsection