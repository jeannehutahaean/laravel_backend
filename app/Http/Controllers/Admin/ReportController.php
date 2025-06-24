<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Shipment;

class ReportController extends Controller
{
    public function index()
    {
        // Ambil semua shipment
        $shipments = Shipment::all();

        // Total semua pengiriman
        $totalShipments = $shipments->count();

        // Pengiriman tepat waktu (actual <= estimated)
        $onTime = $shipments->where('actual_arrival', '!=', null)
                            ->filter(function ($shipment) {
                                return $shipment->actual_arrival <= $shipment->estimated_arrival;
                            })->count();

        // Pengiriman terlambat (actual > estimated)
        $late = $shipments->where('actual_arrival', '!=', null)
                          ->filter(function ($shipment) {
                              return $shipment->actual_arrival > $shipment->estimated_arrival;
                          })->count();

        // Rata-rata waktu pengiriman dalam menit
        $avgDeliveryTime = $shipments->whereNotNull('actual_arrival')->reduce(function ($carry, $shipment) {
            $start = strtotime($shipment->start_time);
            $end = strtotime($shipment->actual_arrival);
            return $carry + ($end - $start) / 60; // menit
        }, 0);

        $countDelivered = $shipments->whereNotNull('actual_arrival')->count();
        $avgDeliveryTime = $countDelivered > 0 ? round($avgDeliveryTime / $countDelivered) : 0;

        return view('admin.reports.index', compact(
            'totalShipments',
            'onTime',
            'late',
            'avgDeliveryTime',
            'shipments'
        ));
    }
}
