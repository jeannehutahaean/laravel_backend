<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoutePoint;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = RoutePoint::all();
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipment_id' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'timestamp' => 'required|date',
        ]);

        RoutePoint::create($request->all());

        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil ditambahkan');
    }

    public function edit($id)
    {
        $route = RoutePoint::findOrFail($id);
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, $id)
    {
        $route = RoutePoint::findOrFail($id);

        $request->validate([
            'shipment_id' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'timestamp' => 'required|date',
        ]);

        $route->update($request->all());

        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil diperbarui');
    }

    public function destroy($id)
    {
        RoutePoint::destroy($id);
        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil dihapus');
    }
}
