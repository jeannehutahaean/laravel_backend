<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = [
            ['message' => 'Kendaraan A terlambat 15 menit', 'time' => now()],
            ['message' => 'Kendaraan B menyimpang dari rute', 'time' => now()],
        ];

        return view('admin.notifications', compact('notifications'));
    }
}
