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
        $ongoingShipments = Shipment::where('status', 'ongoing')->count();
        $completedShipments = Shipment::where('status', 'completed')->count();
        $delayedShipments = Shipment::where('status', 'delayed')->count();

        // Data pengiriman untuk peta + tabel
        $shipments = Shipment::with(['driver', 'vehicle', 'latestTracking'])->get();

        return view('admin.dashboard', compact(
            'vehicleCount',
            'ongoingShipments',
            'completedShipments',
            'delayedShipments',
            'shipments'
        ));
    }
}
