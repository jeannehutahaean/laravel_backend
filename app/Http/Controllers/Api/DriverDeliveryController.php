<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriverShipment;
use App\Models\DriverShipmentRoute;
use App\Models\DriverVehicle;
use Illuminate\Support\Carbon;

class DriverDeliveryController extends Controller
{
    public function getRoutes()
    {
        return DriverShipmentRoute::select('id', 'location_name')->get();
    }

    public function getVehicles()
    {
        return DriverVehicle::select('id', 'plate_number', 'model')->get();
    }

        public function storeShipment(Request $request)
        {
            $validated = $request->validate([
                'goods_type' => 'required|string|max:100',
                'estimated_arrival' => 'required|date',
                'shipment_route_id' => 'required|exists:shipment_routes,id',
                'vehicle_id' => 'required|exists:vehicles,id',
            ]);
        
            $driver = $request->user();
        
            $shipment = DriverShipment::create([
                'driver_id' => $driver->driver_id,
                'vehicle_id' => $validated['vehicle_id'],
                'shipment_route_id' => $validated['shipment_route_id'],
                'start_time' => now(),
                'estimated_arrival' => Carbon::parse($validated['estimated_arrival']),
                'goods_type' => $validated['goods_type'],
                'status_detail' => 'waiting',
                'started' => 0,
                'punctual_status' => 'belum sampai',
            ]);
        
            return response()->json([
                'message' => 'Pengiriman berhasil dibuat',
                'shipment_id' => $shipment->id,
            ], 201);
        }
        public function current(Request $request)
    {
        $driverId = $request->user()->driver_id;
    
        $shipment = DriverShipment::with(['vehicle', 'route'])
            ->where('driver_id', $driverId)
            ->whereIn('status_detail', ['waiting', 'active', 'active-paused'])
            ->orderByDesc('start_time')
            ->first();
    
        if (!$shipment) {
            return response()->json(null);
        }
    
        return response()->json([
            'id' => (string) $shipment->id,
            'vehicleNumber' => $shipment->vehicle->plate_number,
            'routeName' => optional($shipment->route)->location_name ?? '-',
            'goodsType' => $shipment->goods_type,
            'startTime' => $shipment->start_time,
            'estimatedArrival' => $shipment->estimated_arrival,
            'status' => $shipment->status_detail,
        ]);
    }
}

