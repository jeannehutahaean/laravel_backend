<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShipmentRoute;

class ShipmentRouteController extends Controller
{
    public function index()
    {
        $routes = ShipmentRoute::orderBy('shipment_id')->orderBy('route_order')->get();
        return view('admin.routes.index', compact('routes')); // ✅ Perbaikan disini
    }

    public function create()
    {
        return view('admin.routes.create'); // ✅ Sesuaikan juga jika create/edit ada di folder 'admin/routes'
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipment_id' => 'required|integer',
            'location_name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'route_order' => 'required|integer',
        ]);

        ShipmentRoute::create($request->all());

        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $route = ShipmentRoute::findOrFail($id);
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, $id)
    {
        $route = ShipmentRoute::findOrFail($id);

        $request->validate([
            'shipment_id' => 'required|integer',
            'location_name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'route_order' => 'required|integer',
        ]);

        $route->update($request->all());

        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil diperbarui!');
    }

    public function destroy($id)
    {
        ShipmentRoute::destroy($id);
        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil dihapus!');
    }
}
