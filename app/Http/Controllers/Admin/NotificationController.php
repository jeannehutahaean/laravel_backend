<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        // Statistik ringkasan
        $totalShipments = DB::table('shipments')->count();
        $inTransit = DB::table('shipments')->where('status', 'ongoing')->count();
        $late = DB::table('shipments')->where('status', 'delayed')->count();

        // Hitung penyimpangan lokasi dari rute
        $deviationCount = DB::table('trackings')
            ->join('shipment_routes', 'trackings.shipment_id', '=', 'shipment_routes.shipment_id')
            ->select('trackings.shipment_id')
            ->groupBy('trackings.shipment_id')
            ->havingRaw('COUNT(DISTINCT trackings.latitude, trackings.longitude) > COUNT(DISTINCT shipment_routes.latitude, shipment_routes.longitude)')
            ->get()->count();

        $summary = [
            'total' => $totalShipments,
            'in_transit' => $inTransit,
            'late' => $late,
            'deviation' => $deviationCount,
        ];

        // Notifikasi aktivitas shipment
        $notifications = DB::table('shipments')
            ->join('drivers', 'shipments.driver_id', '=', 'drivers.id')
            ->join('vehicles', 'shipments.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('trackings', function ($join) {
                $join->on('shipments.id', '=', 'trackings.shipment_id')
                    ->whereRaw('trackings.timestamp = (SELECT MAX(t2.timestamp) FROM trackings t2 WHERE t2.shipment_id = shipments.id)');
            })
            ->select(
                'shipments.id as order_id',
                'shipments.start_time as departure_time',
                'shipments.estimated_arrival as planned_time',
                'shipments.status',
                'drivers.name as driver_name',
                'trackings.latitude',
                'trackings.longitude',
                'trackings.timestamp as tracking_time',
                'shipments.created_at',
                DB::raw("'on_trip' as activity_status"),
                DB::raw("CONCAT(trackings.latitude, ', ', trackings.longitude) as last_position"),
                DB::raw("CASE 
                    WHEN shipments.actual_arrival > shipments.estimated_arrival THEN 'late'
                    WHEN (trackings.latitude IS NOT NULL AND NOT EXISTS (
                        SELECT 1 FROM shipment_routes sr 
                        WHERE sr.shipment_id = shipments.id AND sr.latitude = trackings.latitude AND sr.longitude = trackings.longitude
                    )) THEN 'deviation'
                    ELSE '' 
                END AS status"),
                DB::raw("CASE 
                    WHEN shipments.actual_arrival > shipments.estimated_arrival THEN 'Pengiriman mengalami keterlambatan'
                    WHEN (trackings.latitude IS NOT NULL AND NOT EXISTS (
                        SELECT 1 FROM shipment_routes sr 
                        WHERE sr.shipment_id = shipments.id AND sr.latitude = trackings.latitude AND sr.longitude = trackings.longitude
                    )) THEN 'Penyimpangan dari rute yang ditentukan'
                    ELSE NULL
                END AS message")
            )
            ->orderByDesc('shipments.created_at')
            ->get();

        return view('admin.notifications.index', compact('summary', 'notifications'));
    }
}
