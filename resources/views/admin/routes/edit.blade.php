@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Rute</h2>

    <div id="map" style="height: 400px; width: 100%;" class="my-4 rounded shadow"></div>

    <form action="{{ route('admin.routes.update', $route->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Latitude</label>
            <input type="text" name="latitude" id="latitude" class="form-control" value="{{ $route->latitude }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Longitude</label>
            <input type="text" name="longitude" id="longitude" class="form-control" value="{{ $route->longitude }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Waktu (timestamp)</label>
            <input type="datetime-local" name="timestamp" class="form-control" value="{{ \Carbon\Carbon::parse($route->timestamp)->format('Y-m-d\TH:i') }}" required>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>

{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    const lat = {{ $route->latitude }};
    const lng = {{ $route->longitude }};

    const map = L.map('map', { scrollWheelZoom: false }).setView([lat, lng], 8);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);

    let marker = L.marker([lat, lng]).addTo(map);

    map.on('click', function(e) {
        const newLat = e.latlng.lat.toFixed(7);
        const newLng = e.latlng.lng.toFixed(7);

        if (marker) map.removeLayer(marker);
        marker = L.marker([newLat, newLng]).addTo(map);

        document.getElementById('latitude').value = newLat;
        document.getElementById('longitude').value = newLng;
    });

    setTimeout(() => map.invalidateSize(), 200);
</script>
@endsection
