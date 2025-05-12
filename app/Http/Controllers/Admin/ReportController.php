<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Data dummy untuk laporan performa
        $stats = [
            'on_time' => 12,
            'late' => 3,
            'average_delivery_time' => '2h 30m',
        ];

        return view('admin.reports.index', compact('stats'));
    }
}
