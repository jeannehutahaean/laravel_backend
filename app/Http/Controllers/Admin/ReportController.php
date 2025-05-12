<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipment;

class ReportController extends Controller
{
    public function index()
    {
        $totalShipments = Shipment::count();
        $onTime = Shipment::where('status', 'completed')
            ->whereColumn('actual_arrival', '<=', 'estimated_arrival')
            ->count();
        $late = Shipment::where('status', 'completed')
            ->whereColumn('actual_arrival', '>', 'estimated_arrival')
            ->count();
        $avgDeliveryTime = Shipment::whereNotNull('actual_arrival')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, start_time, actual_arrival)) as avg_minutes')
            ->value('avg_minutes');

        return view('admin.reports.index', [
            'totalShipments' => $totalShipments,
            'onTime' => $onTime,
            'late' => $late,
            'avgDeliveryTime' => $avgDeliveryTime,
        ]);
    }
}
