<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Dummy data dalam bentuk object
        $notifications = collect([
            (object)[
                'message' => 'Kendaraan A terlambat 30 menit',
                'created_at' => now()->subMinutes(15),
            ],
            (object)[
                'message' => 'Kendaraan B menyimpang dari rute yang ditentukan',
                'created_at' => now()->subHour(),
            ],
        ]);

        return view('admin.notifications.index', compact('notifications'));
    }
}
