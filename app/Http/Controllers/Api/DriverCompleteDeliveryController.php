<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriverDelivery;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DriverCompleteDeliveryController extends Controller
{
    public function complete($id)
    {
        $driverId = Auth::id();

        $shipment = DriverDelivery::where('id', $id)
            ->where('driver_id', $driverId)
            ->where('status_detail', 'active')
            ->first();

        if (!$shipment) {
            return response()->json([
                'message' => 'Pengiriman tidak ditemukan atau tidak aktif.'
            ], 404);
        }

        $now = Carbon::now();

        // Tentukan punctual_status
        $isLate = $now->gt(Carbon::parse($shipment->estimated_arrival));
        $shipment->punctual_status = $isLate ? 'terlambat' : 'tepat waktu';

        // Hitung durasi (dari created_at ke actual_arrival)
        $createdAt = Carbon::parse($shipment->created_at);
        $duration = $createdAt->diff($now);
        $durationStr = $duration->h . ' jam ' . $duration->i . ' menit';

        // Update shipment
        $shipment->actual_arrival = $now;
        $shipment->status_detail = 'completed';
        $shipment->duration = $durationStr;
        $shipment->save();

        return response()->json([
            'message' => 'Pengiriman berhasil diselesaikan.',
            'data' => [
                'id' => $shipment->id,
                'status_detail' => $shipment->status_detail,
                'actual_arrival' => $shipment->actual_arrival,
                'punctual_status' => $shipment->punctual_status,
                'duration' => $shipment->duration,
            ]
        ]);
    }
}
