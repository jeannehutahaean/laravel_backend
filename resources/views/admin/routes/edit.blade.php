@extends('admin.layouts.app')

@section('title', 'Edit Rute Pengiriman')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Update Rute Pengiriman</h1>

    <form method="POST" action="{{ route('admin.routes.update', $route->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium mb-1">Nama Lokasi</label>
            <input type="text" name="location_name" required class="w-full border p-2 rounded"
                   value="{{ old('location_name', $route->location_name) }}"
                   placeholder="Contoh: Toko Harun Salatiga">
        </div>

        <!-- Peta Tunggal -->
        <div class="mb-6">
            <label class="block font-medium mb-2">Peta Rute</label>
            <div class="bg-blue-50 p-3 rounded mb-2">
                <p class="text-sm text-blue-700">
                    <strong>Petunjuk:</strong> Drag marker merah (titik awal) dan biru (titik tujuan) untuk mengubah posisi. 
                    Klik pada peta untuk menambah titik baru jika diperlukan.
                </p>
            </div>
            <div class="relative">
                <button type="button" id="reset_route_btn" class="absolute top-2 right-2 z-10 bg-white hover:bg-gray-100 text-gray-700 px-3 py-1 rounded shadow-md border text-sm font-medium">
                    🔄 Reset Rute
                </button>
                <div id="route_map" class="w-full h-96 rounded shadow-md"></div>
            </div>
            
            <!-- Info Rute -->
            <div id="route_info" class="mt-3 p-3 bg-gray-50 rounded">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <strong>Jarak:</strong> <span id="distance_display">Menghitung...</span>
                    </div>
                    <div>
                        <strong>Estimasi Waktu:</strong> <span id="duration_display">Menghitung...</span>
                    </div>
                </div>
            </div>

            <!-- Hidden inputs -->
            <input type="hidden" name="start_latitude" id="start_latitude" value="{{ $route->start_latitude }}">
            <input type="hidden" name="start_longitude" id="start_longitude" value="{{ $route->start_longitude }}">
            <input type="hidden" name="end_latitude" id="end_latitude" value="{{ $route->end_latitude }}">
            <input type="hidden" name="end_longitude" id="end_longitude" value="{{ $route->end_longitude }}">
            <input type="hidden" name="distance" id="distance" value="{{ $route->distance ?? '' }}">
            <input type="hidden" name="duration" id="duration" value="{{ $route->duration ?? '' }}">
        </div>

        <!-- Checkbox Tujuan Akhir -->
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_final_destination" value="1" class="form-checkbox"
                       {{ $route->is_final_destination ? 'checked' : '' }}>
                <span class="ml-2">Tandai sebagai tujuan akhir</span>
            </label>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" id="submit_btn" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Update Rute
        </button>
    </form>
</div>

<!-- Leaflet & Geocoder -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    const ORS_API_KEY = '5b3ce3597851110001cf6248ed0a5ec959824be3b1a20720f39ddceb';
    const startCoords = [{{ $route->start_latitude }}, {{ $route->start_longitude }}];
    const endCoords = [{{ $route->end_latitude }}, {{ $route->end_longitude }}];

    // Inisialisasi peta
    const routeMap = L.map('route_map').setView(startCoords, 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(routeMap);

    // Marker dan layer untuk rute
    let startMarker = null;
    let endMarker = null;
    let routeLayer = null;
    let clickCount = 2; // Sudah ada 2 marker

    // Custom icons
    const startIcon = L.divIcon({
        html: '<div style="background-color: #ef4444; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
        iconSize: [20, 20],
        iconAnchor: [10, 10],
        className: 'custom-marker'
    });

    const endIcon = L.divIcon({
        html: '<div style="background-color: #3b82f6; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
        iconSize: [20, 20],
        iconAnchor: [10, 10],
        className: 'custom-marker'
    });

    // Fungsi untuk menghitung rute
    async function calculateRoute() {
        if (!startMarker || !endMarker) return;

        const startPos = startMarker.getLatLng();
        const endPos = endMarker.getLatLng();

        try {
            const response = await fetch(`https://api.openrouteservice.org/v2/directions/driving-car?api_key=${ORS_API_KEY}&start=${startPos.lng},${startPos.lat}&end=${endPos.lng},${endPos.lat}`);
            
            if (!response.ok) {
                throw new Error('Gagal menghitung rute');
            }

            const data = await response.json();
            const coordinates = data.features[0].geometry.coordinates;
            const properties = data.features[0].properties;

            // Konversi koordinat untuk Leaflet (swap lng,lat ke lat,lng)
            const leafletCoords = coordinates.map(coord => [coord[1], coord[0]]);

            // Hapus rute lama
            if (routeLayer) {
                routeMap.removeLayer(routeLayer);
            }

            // Tambah rute baru
            routeLayer = L.polyline(leafletCoords, {
                color: '#059669',
                weight: 5,
                opacity: 0.8
            }).addTo(routeMap);

            // Update info rute
            const distance = (properties.segments[0].distance / 1000).toFixed(2);
            const duration = Math.round(properties.segments[0].duration / 60);

            document.getElementById('distance_display').textContent = distance + ' km';
            document.getElementById('duration_display').textContent = duration + ' menit';
            document.getElementById('distance').value = distance;
            document.getElementById('duration').value = duration;

            // Fit peta ke rute
            routeMap.fitBounds(routeLayer.getBounds(), { padding: [20, 20] });

        } catch (error) {
            console.error('Error calculating route:', error);
            document.getElementById('distance_display').textContent = 'Gagal menghitung';
            document.getElementById('duration_display').textContent = 'Gagal menghitung';
        }
    }

    // Inisialisasi marker yang sudah ada
    startMarker = L.marker(startCoords, { 
        icon: startIcon,
        draggable: true 
    }).addTo(routeMap);
    startMarker.bindPopup('Titik Awal');

    endMarker = L.marker(endCoords, { 
        icon: endIcon,
        draggable: true 
    }).addTo(routeMap);
    endMarker.bindPopup('Titik Tujuan');

    // Event listener untuk drag start marker
    startMarker.on('dragend', function(e) {
        const position = e.target.getLatLng();
        document.getElementById('start_latitude').value = position.lat;
        document.getElementById('start_longitude').value = position.lng;
        calculateRoute();
    });

    // Event listener untuk drag end marker
    endMarker.on('dragend', function(e) {
        const position = e.target.getLatLng();
        document.getElementById('end_latitude').value = position.lat;
        document.getElementById('end_longitude').value = position.lng;
        calculateRoute();
    });

    // Event listener untuk klik pada peta (untuk menambah marker baru)
    routeMap.on('click', function(e) {
        if (clickCount < 2) {
            if (clickCount === 0) {
                // Klik pertama - titik awal
                if (startMarker) routeMap.removeLayer(startMarker);
                
                startMarker = L.marker(e.latlng, { 
                    icon: startIcon,
                    draggable: true 
                }).addTo(routeMap);
                
                startMarker.bindPopup('Titik Awal').openPopup();
                
                // Update hidden inputs
                document.getElementById('start_latitude').value = e.latlng.lat;
                document.getElementById('start_longitude').value = e.latlng.lng;
                
                // Event listener untuk drag
                startMarker.on('dragend', function(e) {
                    const position = e.target.getLatLng();
                    document.getElementById('start_latitude').value = position.lat;
                    document.getElementById('start_longitude').value = position.lng;
                    calculateRoute();
                });
                
                clickCount = 1;
                
            } else if (clickCount === 1) {
                // Klik kedua - titik tujuan
                if (endMarker) routeMap.removeLayer(endMarker);
                
                endMarker = L.marker(e.latlng, { 
                    icon: endIcon,
                    draggable: true 
                }).addTo(routeMap);
                
                endMarker.bindPopup('Titik Tujuan').openPopup();
                
                // Update hidden inputs
                document.getElementById('end_latitude').value = e.latlng.lat;
                document.getElementById('end_longitude').value = e.latlng.lng;
                
                // Event listener untuk drag
                endMarker.on('dragend', function(e) {
                    const position = e.target.getLatLng();
                    document.getElementById('end_latitude').value = position.lat;
                    document.getElementById('end_longitude').value = position.lng;
                    calculateRoute();
                });
                
                clickCount = 2;
                
                // Hitung rute
                calculateRoute();
            }
        }
    });

    // Geocoder untuk pencarian
    L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        const latlng = e.geocode.center;
        routeMap.setView(latlng, 15);
    })
    .addTo(routeMap);

    // Tombol reset - menggunakan DOM element biasa
    document.getElementById('reset_route_btn').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (startMarker) routeMap.removeLayer(startMarker);
        if (endMarker) routeMap.removeLayer(endMarker);
        if (routeLayer) routeMap.removeLayer(routeLayer);
        
        startMarker = null;
        endMarker = null;
        routeLayer = null;
        clickCount = 0;
        
        // Reset form
        document.getElementById('start_latitude').value = '';
        document.getElementById('start_longitude').value = '';
        document.getElementById('end_latitude').value = '';
        document.getElementById('end_longitude').value = '';
        document.getElementById('distance').value = '';
        document.getElementById('duration').value = '';
        document.getElementById('distance_display').textContent = '-';
        document.getElementById('duration_display').textContent = '-';
    });

    // Hitung rute awal setelah peta dimuat
    setTimeout(() => {
        routeMap.invalidateSize();
        calculateRoute();
    }, 1000);
</script>
@endsection