<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Shipment;
use App\Models\ShipmentRoute;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $vehicleCount = Vehicle::count();
        $ongoingShipments = Shipment::where('status_detail', 'active')->count();
        $completedShipments = Shipment::where('status_detail', 'completed')->count();
        $delayedShipments = Shipment::where('punctual_status', 'terlambat')->count();

        // Ambil data pengiriman aktif dengan relasi
        $activeShipments = Shipment::with(['driver', 'vehicle', 'route'])
            ->where('status_detail', 'active')
            ->whereNotNull('current_latitude')
            ->whereNotNull('current_longitude')
            ->get();

        // Persiapkan data untuk map tracking
        $mapData = [];
        foreach ($activeShipments as $shipment) {
            if ($shipment->route && $shipment->current_latitude && $shipment->current_longitude) {
                $mapData[] = [
                    'shipment_id'     => $shipment->id,
                    'driver_name'     => $shipment->driver->driver_name ?? '-',
                    'driver_username' => $shipment->driver->driver_username ?? '-',
                    'vehicle_name'    => $shipment->vehicle->model ?? '-',
                    'vehicle_plate'   => $shipment->vehicle->plate_number ?? '-',
                    'status_detail'   => $shipment->status_detail,
                    'goods_type'      => $shipment->goods_type,
                    'start_time'      => $shipment->start_time,
                    'estimated_arrival' => $shipment->estimated_arrival,
                    'punctual_status' => $shipment->punctual_status,
                    'current_lat'     => $shipment->current_latitude,
                    'current_lng'     => $shipment->current_longitude,
                    'start_lat'       => $shipment->route->start_latitude,
                    'start_lng'       => $shipment->route->start_longitude,
                    'end_lat'         => $shipment->route->end_latitude,
                    'end_lng'         => $shipment->route->end_longitude,
                    'start_location'  => $shipment->route->location_name,
                    'route_name'      => $shipment->route->location_name,
                ];
            }
        }

        return view('admin.dashboard', compact(
            'vehicleCount',
            'ongoingShipments',
            'completedShipments',
            'delayedShipments',
            'activeShipments',
            'mapData'
        ));
    }
}