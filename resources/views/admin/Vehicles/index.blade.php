@extends('admin.layouts.app')

@section('title', 'Manajemen Kendaraan')

@section('content')
    <h1>Daftar Kendaraan</h1>
    <a href="#" class="btn btn-primary mb-2">+ Tambah Kendaraan</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Plat Nomor</th>
                <th>Model</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->plate_number }}</td>
                    <td>{{ $vehicle->model }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

