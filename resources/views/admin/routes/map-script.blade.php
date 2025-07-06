{{-- Leaflet CSS & JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

{{-- Leaflet Search (menggunakan Nominatim) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    const defaultLat = {{ $lat ?? -6.2 }};
    const defaultLng = {{ $lng ?? 106.8 }};

    const map = L.map('map').setView([defaultLat, defaultLng], 13);

    const marker = L.marker([defaultLat, defaultLng], {
        draggable: true
    }).addTo(map);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    marker.on('dragend', function(e) {
        const { lat, lng } = marker.getLatLng();
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });

    // Pencarian lokasi (gratis pakai Nominatim)
    L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        const latlng = e.geocode.center;
        marker.setLatLng(latlng);
        map.setView(latlng, 15);
        document.getElementById('latitude').value = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;
    })
    .addTo(map);
</script>
