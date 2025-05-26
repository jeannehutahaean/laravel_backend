<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        // Data notifikasi dengan struktur yang sederhana dan sesuai
        $notifications = collect([
            (object)[
                'id' => 1,
                'order_id' => 'ORD-001',
                'driver_name' => 'John Doe',
                'departure_time' => Carbon::now()->subHours(3),
                'planned_time' => Carbon::now()->subHours(2),
                'last_position' => 'Jl. Sudirman KM 5',
                'status' => 'late',
                'created_at' => now()->subMinutes(15),
            ],
            (object)[
                'id' => 2,
                'order_id' => 'ORD-002',
                'driver_name' => 'Jane Smith',
                'departure_time' => Carbon::now()->subHours(5),
                'planned_time' => Carbon::now()->subHours(4),
                'last_position' => 'Jl. Thamrin KM 3',
                'status' => 'deviation',
                'created_at' => now()->subHour(),
            ],
        ]);

        return view('admin.notifications.index', compact('notifications'));
    }
}