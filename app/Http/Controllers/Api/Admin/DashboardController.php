<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Shipment;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik pengiriman
        $vehicleCount = Vehicle::count();
        $ongoingShipments = Shipment::whereIn('status_detail', ['active', 'active-paused'])->count();
        $completedShipments = Shipment::where('status_detail', 'completed')->count();
        $delayedShipments = Shipment::where('punctual_status', 'terlambat')->count();

        // Data pengiriman untuk peta + tabel
        $shipments = Shipment::with(['driver', 'vehicle'])->get();

    return view('admin.dashboard', compact(
            'vehicleCount',
            'ongoingShipments',
            'completedShipments',
            'delayedShipments',
            'shipments'
        ));
    }
}
