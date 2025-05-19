@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-center text-2xl font-bold">Dashboard Monitoring</h1>
    <div class="my-4"></div>

    <div class="row">
        <div class="col-md-12">
            <div id="map" style="height: 400px;" class="mb-3"></div>
        </div>

        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Driver</th>
                        <th>Vehicle</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>ETA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shipments as $shipment)
                        <tr>
                            <td>{{ $shipment->driver->name ?? '-' }}</td>
                            <td>{{ $shipment->vehicle->model ?? '-' }}</td>
                            <td>
                                @if ($shipment->latestTracking)
                                    {{ $shipment->latestTracking->latitude }}, {{ $shipment->latestTracking->longitude }}
                                @else
                                    Tidak tersedia
                                @endif
                            </td>
                            <td>{{ ucfirst($shipment->status) }}</td>
                            <td>{{ $shipment->estimated_arrival }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Tambahkan Leaflet dari CDN --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        let map = L.map('map').setView([-6.2, 106.8], 6); // default: Indonesia barat

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        let markers = [];

        function loadVehicleLocations() {
            fetch("{{ route('admin.dashboard') }}")
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const tableRows = doc.querySelectorAll("tbody tr");

                    // Bersihkan marker lama
                    markers.forEach(marker => map.removeLayer(marker));
                    markers = [];

                    tableRows.forEach(row => {
                        const latLngText = row.children[2].textContent.trim();
                        if (!latLngText.includes(',')) return;
                        const [lat, lng] = latLngText.split(',').map(Number);

                        const driver = row.children[0].textContent.trim();
                        const vehicle = row.children[1].textContent.trim();
                        const status = row.children[3].textContent.trim();

                        const marker = L.marker([lat, lng]).addTo(map);
                        marker.bindPopup(`<b>${driver}</b><br>${vehicle}<br>Status: ${status}`);
                        markers.push(marker);
                    });
                });
        }

        // Pertama kali
        loadVehicleLocations();

        // Auto refresh tiap 30 detik
        setInterval(loadVehicleLocations, 30000);
    </script>
@endsection
