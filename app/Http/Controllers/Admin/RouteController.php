<?php
// app/Http/Controllers/Admin/RouteController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShipmentRoute;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = ShipmentRoute::orderBy('route_order')->get();
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'route_order' => 'required|integer',
        ]);

        ShipmentRoute::create([
            'shipment_id' => 1, // default sementara, ubah jika dinamis
            'location_name' => $request->location_name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'route_order' => $request->route_order,
        ]);

        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil ditambahkan');
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
            'location_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'route_order' => 'required|integer',
        ]);

        $route->update([
            'location_name' => $request->location_name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'route_order' => $request->route_order,
        ]);

        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil diperbarui');
    }

    public function destroy($id)
    {
        ShipmentRoute::destroy($id);
        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil dihapus');
    }
}
