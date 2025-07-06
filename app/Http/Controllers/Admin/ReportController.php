<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Driver;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with(['driver', 'vehicle'])->get();

        $totalShipments = $shipments->count();

        // Filter hanya shipment dengan status completed
        $completedShipments = $shipments->filter(function ($s) {
            return $s->status_detail === 'completed';
        });

        // Tepat waktu & Terlambat dari shipment completed
        $onTime = $completedShipments->filter(function ($s) {
            return $s->estimated_arrival && $s->actual_arrival &&
                   strtotime($s->actual_arrival) <= strtotime($s->estimated_arrival);
        })->count();

        $late = $completedShipments->filter(function ($s) {
            return $s->estimated_arrival && $s->actual_arrival &&
                   strtotime($s->actual_arrival) > strtotime($s->estimated_arrival);
        })->count();

        // Hitung rata-rata durasi pengiriman dari shipment completed
        $totalDeliveryTime = 0;
        $countDelivered = 0;

        foreach ($completedShipments as $shipment) {
            if ($shipment->start_time && $shipment->actual_arrival) {
                $start = strtotime($shipment->start_time);
                $end = strtotime($shipment->actual_arrival);
                $duration = ($end - $start) / 60; // dalam menit
                $totalDeliveryTime += $duration;
                $countDelivered++;

                $shipment->duration_hours = floor($duration / 60);
                $shipment->duration_minutes = floor($duration % 60);
            } else {
                $shipment->duration_hours = null;
                $shipment->duration_minutes = null;
            }
        }

        $avgDeliveryTime = $countDelivered > 0 ? round($totalDeliveryTime / $countDelivered) : 0;

        // Total jam perjalanan (dari kolom "duration" hanya pada shipment completed)
        $totalDurationInHours = $completedShipments->filter(function ($shipment) {
            return !is_null($shipment->duration);
        })->map(function ($shipment) {
            preg_match('/(\d+)\s*jam(?:\s*(\d+)\s*menit)?/', $shipment->duration, $matches);
            $jam = isset($matches[1]) ? (int)$matches[1] : 0;
            $menit = isset($matches[2]) ? (int)$matches[2] : 0;
            return $jam + ($menit / 60);
        })->sum();

        // Tambahkan estimasi durasi pada semua shipment
        foreach ($shipments as $shipment) {
            if ($shipment->start_time && $shipment->actual_arrival) {
                $start = strtotime($shipment->start_time);
                $end = strtotime($shipment->actual_arrival);
                $duration = ($end - $start) / 60;
                $shipment->duration_hours = floor($duration / 60);
                $shipment->duration_minutes = floor($duration % 60);
            } else {
                $shipment->duration_hours = null;
                $shipment->duration_minutes = null;
            }
        }

        // Informasi per driver (hanya dari shipment completed)
        $drivers = Driver::with(['shipments' => function ($query) {
            $query->where('status_detail', 'completed');
        }])->get()->map(function ($driver) {
            $totalDuration = 0;
            $count = 0;

            foreach ($driver->shipments as $shipment) {
                if ($shipment->start_time && $shipment->actual_arrival) {
                    $totalDuration += (strtotime($shipment->actual_arrival) - strtotime($shipment->start_time)) / 3600;
                    $count++;
                }
            }

            $driver->total_hours = round($totalDuration, 2);
            $driver->avg_hours = $count > 0 ? round($totalDuration / $count, 2) : 0;

            return $driver;
        });

        return view('admin.reports.index', compact(
            'totalShipments',
            'onTime',
            'late',
            'avgDeliveryTime',
            'totalDurationInHours',
            'shipments',
            'drivers'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:waiting,accepted,active,completed',
        ]);

        $shipment->status_detail = $validated['status'];
        $shipment->save();

        return redirect()->back()->with('success', 'Status pengiriman berhasil diperbarui.');
    }
}
