@extends('admin.layouts.app')

@section('title', 'Laporan Performa')

@section('content')
    <h1>Laporan Performa Pengiriman</h1>
    <ul>
        <li>Tepat waktu: {{ $report['on_time'] }}</li>
        <li>Terlambat: {{ $report['delayed'] }}</li>
        <li>Rata-rata Waktu: {{ $report['average_time'] }} menit</li>
    </ul>
@endsection