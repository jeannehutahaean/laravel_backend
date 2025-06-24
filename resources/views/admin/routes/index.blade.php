@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Daftar Rute Pengiriman</h2>

    <div id="map" style="height: 500px; width: 100%;" class="my-4 rounded shadow"></div>

    <a href="{{ route('admin.routes.create') }}" class="btn btn-primary mb-3">+ Tambah Rute Baru</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Waktu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($routes as $route)
            <tr>
                <td>{{ $route->id }}</td>
                <td>{{ $route->latitude }}</td>
                <td>{{ $route->longitude }}</td>
                <td>{{ $route->created_at }}</td>
                <td>
                    <a href="{{ route('admin.routes.edit', $route->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.routes.destroy', $route->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus rute ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Include Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    const routes = @json($routes);
    const map = L.map('map', {
        scrollWheelZoom: false, // 🔧 nonaktifkan zoom saat scroll
        zoomControl: true
    }).setView([-6.914744, 107.609810], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    routes.forEach(route => {
        L.marker([route.latitude, route.longitude])
            .addTo(map)
            .bindPopup(`ID: ${route.id}<br>Waktu: ${route.created_at}`);
    });

    // 🔧 perbaikan ukuran saat map baru dimuat
    setTimeout(() => {
        map.invalidateSize();
    }, 200);
</script>
@endsection
