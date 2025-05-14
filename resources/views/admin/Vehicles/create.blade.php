@extends('admin.layouts.app')
@section('title', 'Tambah Kendaraan')
@section('content')
<h1>Tambah Kendaraan</h1>
<form method="POST" action="{{ route('admin.vehicles.store') }}">
    @csrf
    <div class="mb-3">
        <label for="plate_number" class="form-label">Plat Nomor</label>
        <input type="text" name="plate_number" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="model" class="form-label">Model</label>
        <input type="text" name="model" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
</form>
@endsection
