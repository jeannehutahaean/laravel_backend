<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriverHistory;

class DriverHistoryController extends Controller
{
    public function index(Request $request)
    {
        $driverId = $request->user()->driver_id;

        $histories = DriverHistory::with('finalRoute')
            ->where('driver_id', $driverId)
            ->where('status_detail', 'completed')
            ->orderByDesc('start_time')
            ->get();

        $result = $histories->map(function ($shipment) {
            return [
                'id' => (string) $shipment->id,
                'date' => optional($shipment->start_time)->format('Y-m-d'),
                'duration' => $shipment->duration ?? '-',
                'status' => ucwords($shipment->punctual_status ?? 'Belum Sampai'),
                'destinationName' => optional($shipment->finalRoute)->location_name ?? '-'
            ];
        });

        return response()->json($result);
    }
}
