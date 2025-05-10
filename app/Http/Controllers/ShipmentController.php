<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;

class ShipmentController extends Controller
{
    public function start(Request $request)
    {
        return Shipment::create([
            'driver_id' => auth()->id(),
            'vehicle_id' => $request->vehicle_id,
            'destination' => $request->destination,
            'start_time' => now(),
            'estimated_arrival' => $request->eta,
            'goods_type' => $request->goods_type,
            'status' => 'ongoing'
        ]);
    }
}
