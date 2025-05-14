@extends('admin.layouts.app')

@section('title', 'Tambah Rute')

@section('content')
<h1>Tambah Rute</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.routes.store') }}">
    @csrf
    <div class="mb-3">
        <label>Shipment ID</label>
        <input type="number" name="shipment_id" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Latitude</label>
        <input type="text" name="latitude" id="lat" class="form-control" required readonly>
    </div>
    <div class="mb-3">
        <label>Longitude</label>
        <input type="text" name="longitude" id="lng" class="form-control" required readonly>
    </div>
    <div class="mb-3">
        <label>Timestamp</label>
        <input type="datetime-local" name="timestamp" class="form-control" required>
    </div>

    <div id="map" style="height: 400px;" class="mb-3"></div>

    <button type="submit" class="btn btn-success">Simpan</button>
</form>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([-6.2, 106.8], 10); // Default Jakarta
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    var marker;

    map.on('click', function(e) {
        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }
        document.getElementById('lat').value = e.latlng.lat.toFixed(6);
        document.getElementById('lng').value = e.latlng.lng.toFixed(6);
    });
</script>
@endpush
