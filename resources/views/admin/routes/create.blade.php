{{-- resources/views/admin/routes/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Rute</h2>
    <form method="POST" action="{{ route('admin.routes.store') }}">
        @csrf
        <div class="mb-3">
            <label>Nama Lokasi</label>
            <input type="text" id="location_name" name="location_name" class="form-control" readonly required>
        </div>
        <div class="mb-3">
            <label>Latitude</label>
            <input type="text" id="latitude" name="latitude" class="form-control" readonly required>
        </div>
        <div class="mb-3">
            <label>Longitude</label>
            <input type="text" id="longitude" name="longitude" class="form-control" readonly required>
        </div>
        <div class="mb-3">
            <label>Urutan Rute</label>
            <input type="number" name="route_order" class="form-control" required>
        </div>
        <div id="map" style="height: 400px;"></div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
    var map = L.map('map').setView([-6.914744, 107.609810], 10); // Bandung
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    var marker;
    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        var latlng = e.geocode.center;
        var name = e.geocode.name;

        if (marker) map.removeLayer(marker);
        marker = L.marker(latlng).addTo(map);

        document.getElementById('latitude').value = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;
        document.getElementById('location_name').value = name;

        map.setView(latlng, 15);
    })
    .addTo(map);
</script>
@endsection
