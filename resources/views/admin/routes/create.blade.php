@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Tambah Rute</h1>

    <form method="POST" action="{{ route('admin.routes.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block font-medium mb-1">Shipment ID</label>
            <input type="number" name="shipment_id" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Nama Lokasi</label>
            <input type="text" name="location_name" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Urutan Rute (1 = A, 2 = B...)</label>
            <input type="number" name="route_order" required class="w-full border p-2 rounded">
        </div>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <div class="mb-4">
            <label class="block font-medium mb-1">Pilih Lokasi di Peta</label>
            <div id="map" class="w-full h-96 border rounded"></div>
        </div>

        <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Simpan
        </button>
    </form>
</div>

{{-- Include script peta --}}
@include('admin.routes.map-script')
@endsection
