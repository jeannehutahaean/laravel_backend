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
        $routes = ShipmentRoute::orderBy('route_order')->get(); // Hapus orderBy shipment_id karena sudah tidak relevan
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
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
            'route_order'   => 'required|integer',
        ]);

        ShipmentRoute::create([
            'shipment_id'   => null, // Karena belum terhubung ke shipment
            'location_name' => $request->location_name,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'route_order'   => $request->route_order,
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
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
            'route_order'   => 'required|integer',
        ]);

        $route->update([
            'location_name' => $request->location_name,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'route_order'   => $request->route_order,
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
