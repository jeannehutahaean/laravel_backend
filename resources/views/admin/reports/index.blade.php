@extends('admin.layouts.app')

@section('title', 'Laporan Performa Pengiriman')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Laporan Pengiriman</h2>
    </div>

    {{-- Statistik Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-6">
            <p class="text-sm font-medium text-gray-600">Total Pengiriman</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalShipments }}</p>
        </div>

        <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-6">
            <p class="text-sm font-medium text-gray-600">Tepat Waktu</p>
            <p class="text-3xl font-bold text-green-700 mt-2">{{ $onTime }}</p>
            <p class="text-xs text-gray-500 mt-1">* Hanya yang completed</p>
        </div>

        <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-6">
            <p class="text-sm font-medium text-gray-600">Terlambat</p>
            <p class="text-3xl font-bold text-red-700 mt-2">{{ $late }}</p>
            <p class="text-xs text-gray-500 mt-1">* Hanya yang completed</p>
        </div>

        <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-6">
            <p class="text-sm font-medium text-gray-600">Rata-rata Waktu</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">
                {{ floor($avgDeliveryTime / 60) }} jam {{ $avgDeliveryTime % 60 }} menit
            </p>
            <p class="text-xs text-gray-500 mt-1">* Dari pengiriman completed</p>
        </div>

        <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-6">
            <p class="text-sm font-medium text-gray-600">Total Jam Perjalanan</p>
            <p class="text-3xl font-bold text-blue-700 mt-2">{{ number_format($totalDurationInHours, 2) }} jam</p>
            <p class="text-xs text-gray-500 mt-1">* Dari pengiriman completed</p>
        </div>
    </div>

    {{-- Tabel Pengiriman --}}
    <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">No. Order</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">Tanggal Dibuat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">Driver</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">Kendaraan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">Jenis Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">Total Jam Perjalanan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($shipments as $shipment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-200">
                                {{ 'ON-' . str_pad($shipment->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 border-r border-gray-200">
                                {{ \Carbon\Carbon::parse($shipment->created_at)->translatedFormat('d M Y') }}<br>
                                <span class="text-gray-500">{{ \Carbon\Carbon::parse($shipment->created_at)->format('H:i') }} WIB</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 border-r border-gray-200">
                                {{ $shipment->driver->driver_name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 border-r border-gray-200">
                                {{ $shipment->vehicle->model ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 border-r border-gray-200">
                                {{ $shipment->goods_type ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 border-r border-gray-200">
                                @if($shipment->status_detail === 'completed' && !is_null($shipment->duration_hours))
                                    {{ $shipment->duration_hours }} jam {{ $shipment->duration_minutes }} menit
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex flex-col space-y-2">
                                    @php
                                        $status = strtolower($shipment->status_detail ?? 'unknown');
                                        $bg = match($status) {
                                            'waiting' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'accepted' => 'bg-green-100 text-green-800 border-green-200',
                                            'active' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'active-paused' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            'done', 'completed' => 'bg-gray-100 text-gray-700 border-gray-200',
                                            default => 'bg-gray-200 text-gray-800 border-gray-300',
                                        };
                                    @endphp
                                    <form method="POST" action="{{ route('admin.report.updateStatus', $shipment->id) }}">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="text-xs rounded-full border px-2 py-1 {{ $bg }}">
                                            @foreach(['waiting', 'accepted', 'active','active-paused', 'completed'] as $option)
                                                <option value="{{ $option }}" {{ $shipment->status_detail === $option ? 'selected' : '' }}>
                                                    {{ ucfirst(str_replace('-', ' ', $option)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
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
