<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\DriverShipment;

class DriverTrackingMapController extends Controller
{
    public function currentRoute()
    {
        $driverId = Auth::user()->driver_id;

        $shipment = DriverShipment::where('driver_id', $driverId)
            ->whereIn('status_detail', ['active', 'active-paused'])
            ->with(['route', 'vehicle'])
            ->first();

        if (!$shipment || !$shipment->route || !$shipment->vehicle) {
            return response()->json(['message' => 'Data pengiriman tidak lengkap.'], 404);
        }

        // Hitung durasi
        $createdAt = $shipment->created_at;
        $duration = now()->diff($createdAt)->format('%H:%I:%S');

        return response()->json([
            'shipment_id' => $shipment->id,
            'goods_type' => $shipment->goods_type,
            'status_detail' => $shipment->status_detail,
            'plate_number' => $shipment->vehicle->plate_number,
            'start_time' => $shipment->start_time,
            'created_at' => $shipment->created_at,
            'estimated_arrival' => $shipment->estimated_arrival,
            'duration' => $duration,

            'current_latitude' => $shipment->current_latitude,
            'current_longitude' => $shipment->current_longitude,
            'start_latitude' => $shipment->route->start_latitude,
            'start_longitude' => $shipment->route->start_longitude,
            'end_latitude' => $shipment->route->end_latitude,
            'end_longitude' => $shipment->route->end_longitude,
            'location_name' => $shipment->route->location_name,
        ]);
    }
}
