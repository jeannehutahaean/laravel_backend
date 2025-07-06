<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|unique:vehicles',
            'model' => 'required|string|max:100',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil ditambahkan');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'plate_number' => 'required|unique:vehicles,plate_number,' . $vehicle->id,
            'model' => 'required|string|max:100',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil diperbarui');
    }

    public function destroy(Vehicle $vehicle)
    {
        
        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil dihapus');
    }
}
