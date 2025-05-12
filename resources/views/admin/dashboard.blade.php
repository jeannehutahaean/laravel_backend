@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard Monitoring</h1>
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
                            <td>{{ $shipment->driver->name }}</td>
                            <td>{{ $shipment->vehicle->model }}</td>
                            <td>{{ $shipment->latestTracking->latitude }}, {{ $shipment->latestTracking->longitude }}</td>
                            <td>{{ $shipment->status }}</td>
                            <td>{{ $shipment->estimated_arrival }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

