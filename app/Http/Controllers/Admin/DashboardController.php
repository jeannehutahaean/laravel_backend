@extends('layouts.admin')

@section('content')
<h1>Dashboard Monitoring Logistik</h1>

<div>
    <h3>Kendaraan</h3>
    <ul>
        @foreach ($vehicles as $vehicle)
            <li>{{ $vehicle->plate_number }} - {{ $vehicle->driver_name }} ({{ $vehicle->status }})</li>
        @endforeach
    </ul>
</div>

<div>
    <h3>Pengiriman Aktif</h3>
    <ul>
        @foreach ($shipments as $shipment)
            <li>{{ $shipment->destination }} - Estimasi: {{ $shipment->estimated_arrival }}</li>
        @endforeach
    </ul>
</div>
@endsection
