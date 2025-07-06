<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DriverShipmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class DriverShipmentController extends Controller
{
    public function store(Request $request)
    {
        $driverId = $request->user()->driver_id;

        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:vehicles,id',
            'shipment_route_id' => 'required|exists:shipment_routes,id',
            'estimated_arrival' => 'required|date',
            'goods_type' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $shipment = DriverShipmentRequest::create([
            'driver_id' => $driverId,
            'vehicle_id' => $request->vehicle_id,
            'shipment_route_id' => $request->shipment_route_id,
            'estimated_arrival' => $request->estimated_arrival,
            'goods_type' => $request->goods_type,
            'status_detail' => 'waiting',
            'started' => 0,
            'start_time' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Pengajuan pengiriman berhasil dikirim',
            'shipment_id' => $shipment->id
        ], 201);
    }
}
