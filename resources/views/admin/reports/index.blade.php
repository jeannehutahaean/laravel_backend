@extends('admin.layouts.app')

@section('title', 'Laporan Performa Pengiriman')

@section('content')
    <h1>Laporan Performa Pengiriman</h1>

    <ul>
        <li>Total Pengiriman: {{ $totalShipments }}</li>
        <li>Tepat Waktu: {{ $onTime }}</li>
        <li>Terlambat: {{ $late }}</li>
        <li>Rata-rata Waktu Pengiriman: {{ round($avgDeliveryTime, 2) }} menit</li>
    </ul>
@endsection
