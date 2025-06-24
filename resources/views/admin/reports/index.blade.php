@extends('admin.layouts.app')

@section('title', 'Laporan Performa Pengiriman')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Laporan Pengiriman</h2>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-6">
                <p class="text-sm font-medium text-gray-600">Total Pengiriman</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalShipments }}</p>
            </div>

            <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-6">
                <p class="text-sm font-medium text-gray-600">Tepat Waktu</p>
                <p class="text-3xl font-bold text-green-700 mt-2">{{ $onTime }}</p>
            </div>

            <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-6">
                <p class="text-sm font-medium text-gray-600">Terlambat</p>
                <p class="text-3xl font-bold text-red-700 mt-2">{{ $late }}</p>
            </div>

            <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-6">
                <p class="text-sm font-medium text-gray-600">Rata-rata Waktu</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">
                    {{ floor($avgDeliveryTime/60) }} jam {{ $avgDeliveryTime%60 }} menit
                </p>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">No. Order</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">Tanggal Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">Deskripsi Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">Kuantitas Pengiriman</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">Total Jam Perjalanan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">Status & Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($shipments as $shipment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                {{ 'ON-' . str_pad($shipment->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                {{ \Carbon\Carbon::parse($shipment->created_at)->translatedFormat('d M Y') }}<br>
                                <span class="text-gray-500">{{ \Carbon\Carbon::parse($shipment->created_at)->format('H:i') }} WIB</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                {{ $shipment->goods_type ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                {{ number_format($shipment->quantity ?? 0, 0, ',', '.') }} KG
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                @if($shipment->actual_arrival)
                                    @php
                                        $totalSeconds = \Carbon\Carbon::parse($shipment->start_time)->diffInSeconds(\Carbon\Carbon::parse($shipment->actual_arrival));
                                        $hours = floor($totalSeconds / 3600);
                                        $minutes = floor(($totalSeconds % 3600) / 60);
                                    @endphp
                                    {{ $hours }} jam {{ $minutes }} menit
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex flex-col space-y-2">
                                    @php
                                        $status = strtolower($shipment->status);
                                        $bg = match($status) {
                                            'confirmed' => 'bg-green-100 text-green-800 border-green-200',
                                            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                            default => 'bg-gray-200 text-gray-800 border-gray-300',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $bg }}">
                                        {{ ucfirst($shipment->status) }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada data pengiriman.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
