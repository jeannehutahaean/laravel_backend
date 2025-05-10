<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;

class TrackingController extends Controller
{
    public function store(Request $request)
    {
        Tracking::create([
            'shipment_id' => $request->shipment_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'timestamp' => now()
        ]);

        return response()->json(['message' => 'Tracking updated']);
    }
}
