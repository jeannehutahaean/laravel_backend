<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        // Statistik ringkasan
        $totalShipments = DB::table('shipments')->count();
        $inTransit = DB::table('shipments')->where('status_detail', 'active')->count();
        $late = DB::table('shipments')
            ->where('punctual_status', 'terlambat')
            ->count();

        // Estimasi penyimpangan rute (jika current lokasi ≠ lokasi tujuan rute yang seharusnya)
        $deviationCount = DB::table('shipments')
            ->join('shipment_routes', 'shipments.shipment_route_id', '=', 'shipment_routes.id')
            ->where(function ($query) {
                $query->whereRaw('shipments.current_latitude IS NOT NULL')
                    ->whereRaw('shipments.current_longitude IS NOT NULL')
                    ->whereRaw('(ROUND(shipments.current_latitude, 4) != ROUND(shipment_routes.end_latitude, 4) OR ROUND(shipments.current_longitude, 4) != ROUND(shipment_routes.end_longitude, 4))');
            })
            ->count();

        $summary = [
            'total' => $totalShipments,
            'in_transit' => $inTransit,
            'late' => $late,
            'deviation' => $deviationCount,
        ];

        // Notifikasi aktivitas shipment
        $notifications = DB::table('shipments')
            ->join('drivers', 'shipments.driver_id', '=', 'drivers.driver_id')
            ->join('vehicles', 'shipments.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('shipment_routes', 'shipments.shipment_route_id', '=', 'shipment_routes.id')
            ->select(
                'shipments.id as order_id',
                'shipments.start_time as departure_time',
                'shipments.estimated_arrival as planned_time',
                'shipments.status_detail',
                'drivers.driver_name as driver_name',
                'shipments.current_latitude as latitude',
                'shipments.current_longitude as longitude',
                'shipments.created_at',
                DB::raw("'on_trip' as activity_status"),
                DB::raw("CONCAT(shipments.current_latitude, ', ', shipments.current_longitude) as last_position"),
                DB::raw("CASE 
                    WHEN shipments.punctual_status = 'terlambat' THEN 'late'
                    WHEN (shipments.current_latitude IS NOT NULL AND 
                          (ROUND(shipments.current_latitude,4) != ROUND(shipment_routes.end_latitude,4) 
                          OR ROUND(shipments.current_longitude,4) != ROUND(shipment_routes.end_longitude,4))) 
                         THEN 'deviation'
                    ELSE '' 
                END AS status"),
                DB::raw("CASE 
                    WHEN shipments.punctual_status = 'terlambat' THEN 'Pengiriman mengalami keterlambatan'
                    WHEN (shipments.current_latitude IS NOT NULL AND 
                          (ROUND(shipments.current_latitude,4) != ROUND(shipment_routes.end_latitude,4) 
                          OR ROUND(shipments.current_longitude,4) != ROUND(shipment_routes.end_longitude,4))) 
                         THEN 'Penyimpangan dari rute yang ditentukan'
                    ELSE NULL
                END AS message")
            )
            ->orderByDesc('shipments.created_at')
            ->get();

        return view('admin.notifications.index', compact('summary', 'notifications'));
    }
}
