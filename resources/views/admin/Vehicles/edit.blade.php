@extends('admin.layouts.app')
@section('title', 'Edit Kendaraan')
@section('content')
<h1>Edit Kendaraan</h1>
<form method="POST" action="{{ route('admin.vehicles.update', $vehicle->id) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="plate_number" class="form-label">Plat Nomor</label>
        <input type="text" name="plate_number" class="form-control" value="{{ $vehicle->plate_number }}" required>
    </div>
    <div class="mb-3">
        <label for="model" class="form-label">Model</label>
        <input type="text" name="model" class="form-control" value="{{ $vehicle->model }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
