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
        $vehicleCount = Vehicle::count();
        $ongoingShipments = Shipment::where('status', 'ongoing')->count();
        $completedShipments = Shipment::where('status', 'completed')->count();
        $delayedShipments = Shipment::where('status', 'delayed')->count();

        // Tambahkan query ini untuk menampilkan data real-time di dashboard
        $shipments = Shipment::with(['driver', 'vehicle', 'latestTracking'])->get();

        return view('admin.dashboard', compact(
            'vehicleCount',
            'ongoingShipments',
            'completedShipments',
            'delayedShipments',
            'shipments' // Pastikan dikirim ke view
        ));
    }
}
