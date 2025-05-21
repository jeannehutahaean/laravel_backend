@extends('admin.layouts.app')

@section('title', 'Edit Kendaraan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Kendaraan</h1>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm overflow-hidden">
        <form method="POST" action="{{ route('admin.vehicles.update', $vehicle->id) }}" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Form Grid -->
            <div class="space-y-6">
                <!-- Plat Nomor Field -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="plate_number" class="block text-sm font-medium text-gray-700">
                            Plat Nomor <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <input type="text" name="plate_number" id="plate_number" 
                               class="block w-full px-4 py-2 border-2 border-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                               value="{{ $vehicle->plate_number }}" 
                               required>
                        @error('plate_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Model Field -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="model" class="block text-sm font-medium text-gray-700">
                            Model <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <select name="model" id="model" 
                                class="block w-full px-4 py-2 border-2 border-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                required>
                            <option value="" disabled>Pilih Model Kendaraan</option>
                            <option value="Avanza" {{ $vehicle->model == 'Avanza' ? 'selected' : '' }}>Avanza</option>
                            <option value="Xenia" {{ $vehicle->model == 'Xenia' ? 'selected' : '' }}>Xenia</option>
                            <option value="Innova" {{ $vehicle->model == 'Innova' ? 'selected' : '' }}>Innova</option>
                            <option value="Fortuner" {{ $vehicle->model == 'Fortuner' ? 'selected' : '' }}>Fortuner</option>
                            <option value="Hiace" {{ $vehicle->model == 'Hiace' ? 'selected' : '' }}>Hiace</option>
                        </select>
                        @error('model')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.vehicles.index') }}" 
                   class="px-4 py-2 border-2 border-gray-200 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection