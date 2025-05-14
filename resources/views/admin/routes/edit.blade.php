@extends('admin.layouts.app')

@section('title', 'Edit Rute')

@section('content')
<h1>Edit Rute</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.routes.update', $route->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Shipment ID</label>
        <input type="number" name="shipment_id" class="form-control" value="{{ old('shipment_id', $route->shipment_id) }}" required>
    </div>
    <div class="mb-3">
        <label>Latitude</label>
        <input type="text" name="latitude" id="lat" class="form-control" value="{{ old('latitude', $route->latitude) }}" required readonly>
    </div>
    <div class="mb-3">
        <label>Longitude</label>
        <input type="text" name="longitude" id="lng" class="form-control" value="{{ old('longitude', $route->longitude) }}" required readonly>
    </div>
    <div class="mb-3">
        <label>Timestamp</label>
        <input type="datetime-local" name="timestamp" class="form-control"
               value="{{ \Carbon\Carbon::parse($route->timestamp)->format('Y-m-d\TH:i') }}" required>
    </div>

    <div id="map" style="height: 400px;" class="mb-3"></div>

    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
</form>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    var lat = {{ $route->latitude }};
    var lng = {{ $route->longitude }};
    var map = L.map('map').setView([lat, lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var marker = L.marker([lat, lng], {draggable: true}).addTo(map);

    marker.on('dragend', function(e) {
        var position = marker.getLatLng();
        document.getElementById('lat').value = position.lat.toFixed(6);
        document.getElementById('lng').value = position.lng.toFixed(6);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('lat').value = e.latlng.lat.toFixed(6);
        document.getElementById('lng').value = e.latlng.lng.toFixed(6);
    });
</script>
@endpush
