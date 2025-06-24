@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Rute</h1>

    <form method="POST" action="{{ route('routes.update', $route->id) }}">
        @csrf @method('PUT')
        <div class="mb-4">
            <label>Shipment ID</label>
            <input type="number" name="shipment_id" value="{{ $route->shipment_id }}" required class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label>Nama Lokasi</label>
            <input type="text" name="location_name" value="{{ $route->location_name }}" required class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label>Urutan Rute</label>
            <input type="number" name="route_order" value="{{ $route->route_order }}" required class="w-full border p-2 rounded">
        </div>

        <input type="hidden" name="latitude" id="latitude" value="{{ $route->latitude }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ $route->longitude }}">

        <div class="mb-4">
            <label>Pilih Lokasi di Peta</label>
            <div id="map" class="w-full h-96 border rounded"></div>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
    </form>
</div>

@include('routes.map-script', ['lat' => $route->latitude, 'lng' => $route->longitude])
@endsection
