<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DriverHistoryDetail;
use Illuminate\Http\Request;

class DriverHistoryDetailController extends Controller
{
    public function show($id, Request $request)
    {
        $driverId = $request->user()->driver_id;

        $shipment = DriverHistoryDetail::with(['route', 'vehicle'])
            ->where('id', $id)
            ->where('driver_id', $driverId)
            ->where('status_detail', 'completed')
            ->first();

        if (!$shipment) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $shipment->id,
            'driver_id' => $shipment->driver_id,
            'vehicle_id' => $shipment->vehicle_id,
            'plate_number' => optional($shipment->vehicle)->plate_number ?? '-',
            'start_time' => $shipment->start_time,
            'actual_arrival' => $shipment->actual_arrival,
            'goods_type' => $shipment->goods_type,
            'status_detail' => $shipment->status_detail,
            'punctual_status' => $shipment->punctual_status,
            'duration' => $shipment->duration,
            'location_name' => optional($shipment->route)->location_name ?? '-',
            'start_latitude' => optional($shipment->route)->start_latitude,
            'start_longitude' => optional($shipment->route)->start_longitude,
            'end_latitude' => optional($shipment->route)->end_latitude,
            'end_longitude' => optional($shipment->route)->end_longitude,
        ]);
    }
}
