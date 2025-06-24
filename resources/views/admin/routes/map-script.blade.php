<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css" />

<script>
    const defaultLat = {{ $lat ?? -6.2 }};
    const defaultLng = {{ $lng ?? 106.8 }};

    const map = L.map('map').setView([defaultLat, defaultLng], 13);
    const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    marker.on('dragend', function(e) {
        const { lat, lng } = marker.getLatLng();
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });

    // MAPBOX Search
    mapboxgl.accessToken = 'YOUR_MAPBOX_ACCESS_TOKEN';
    const geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl,
        placeholder: "Cari lokasi..."
    });

    geocoder.on('result', function(e) {
        const lng = e.result.center[0];
        const lat = e.result.center[1];
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], 15);
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });

    document.getElementById('map').appendChild(geocoder.onAdd(map));
</script>
