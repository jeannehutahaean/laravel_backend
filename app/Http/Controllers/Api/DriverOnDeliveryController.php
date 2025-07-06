<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriverDelivery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DriverOnDeliveryController extends Controller
{
    public function start($id)
    {
        $shipment = DriverDelivery::where('id', $id)
            ->where('driver_id', Auth::user()->driver_id)
            ->firstOrFail();

        $shipment->update([
            'status_detail' => 'active',
            'started' => 1,
            'start_time' => now(),
        ]);

        return response()->json(['message' => 'Pengiriman dimulai.']);
    }

    public function cancel($id)
    {
        $shipment = DriverDelivery::where('id', $id)
            ->where('driver_id', Auth::user()->driver_id)
            ->firstOrFail();

        $shipment->update([
            'status_detail' => 'cancelled',
        ]);

        return response()->json(['message' => 'Pengiriman dibatalkan.']);
    }

    public function pause($id)
    {
        $shipment = DriverDelivery::where('id', $id)
            ->where('driver_id', Auth::user()->driver_id)
            ->firstOrFail();

        $shipment->update([
            'status_detail' => 'active-paused',
        ]);

        return response()->json(['message' => 'Pengiriman dijeda.']);
    }

    public function updateLocation($id, Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $shipment = DriverDelivery::where('id', $id)
            ->where('driver_id', Auth::user()->driver_id)
            ->where('status_detail', 'active')
            ->firstOrFail();

        $shipment->update([
            'current_latitude' => $request->latitude,
            'current_longitude' => $request->longitude,
        ]);

        return response()->json(['message' => 'Lokasi diperbarui']);
    }
    
    public function current()
    {
        $shipment = DriverDelivery::with(['vehicle', 'route'])
            ->where('driver_id', Auth::user()->driver_id)
            ->whereIn('status_detail', ['waiting', 'accepted', 'active', 'active-paused'])
            ->latest()
            ->first();

        if (!$shipment) {
            return response()->json(null);
        }

        return response()->json([
            'id' => (string) $shipment->id,
            'vehicleNumber' => $shipment->vehicle->plate_number ?? '-',
            'routeName' => $shipment->route->location_name ?? '-',
            'goodsType' => $shipment->goods_type ?? '-',
            'startTime' => optional($shipment->start_time)->toIso8601String(),
            'estimatedArrival' => optional($shipment->estimated_arrival)->toIso8601String(),
            'status' => $shipment->status_detail,
        ]);
    }
}
