<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShipmentRoute;

class ShipmentRouteController extends Controller
{
    // Tampilkan semua rute
    public function index()
    {
        $routes = ShipmentRoute::orderBy('created_at', 'asc')->get(); // Urutkan berdasarkan waktu dibuat
        return view('admin.routes.index', compact('routes'));
    }

    // Form tambah rute
    public function create()
    {
        return view('admin.routes.create');
    }

    // Simpan rute baru
    public function store(Request $request)
    {
        $request->validate([
            'location_name' => 'required|string|max:255',
            'start_latitude' => 'required|numeric',
            'start_longitude' => 'required|numeric',
            'end_latitude' => 'required|numeric',
            'end_longitude' => 'required|numeric',
            'is_final_destination' => 'nullable|boolean',
        ]);

        ShipmentRoute::create([
            'location_name' => $request->location_name,
            'start_latitude' => $request->start_latitude,
            'start_longitude' => $request->start_longitude,
            'end_latitude' => $request->end_latitude,
            'end_longitude' => $request->end_longitude,
            'is_final_destination' => $request->is_final_destination ?? 0,
        ]);

        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil ditambahkan!');
    }

    // Form edit rute
    public function edit($id)
    {
        $route = ShipmentRoute::findOrFail($id);
        return view('admin.routes.edit', compact('route'));
    }

    // Update data rute
    public function update(Request $request, $id)
    {
        $route = ShipmentRoute::findOrFail($id);

        $request->validate([
            'location_name' => 'required|string|max:255',
            'start_latitude' => 'required|numeric',
            'start_longitude' => 'required|numeric',
            'end_latitude' => 'required|numeric',
            'end_longitude' => 'required|numeric',
            'is_final_destination' => 'nullable|boolean',
        ]);

        $route->update([
            'location_name' => $request->location_name,
            'start_latitude' => $request->start_latitude,
            'start_longitude' => $request->start_longitude,
            'end_latitude' => $request->end_latitude,
            'end_longitude' => $request->end_longitude,
            'is_final_destination' => $request->is_final_destination ?? 0,
        ]);

        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil diperbarui!');
    }

    // Hapus rute
    public function destroy($id)
    {
        ShipmentRoute::destroy($id);
        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil dihapus!');
    }
}
