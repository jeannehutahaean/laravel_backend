@extends('admin.layouts.app')

@section('title', 'Notifikasi')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Monitoring dan Notifikasi Pengiriman</h1>
            <div class="flex space-x-2">
                <button class="px-4 py-2 bg-green-100 text-green-800 rounded-lg text-sm font-medium hover:bg-green-200 transition">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-6 rounded-lg border-2 shadow text-center">
                <div class="text-gray-500 text-sm font-medium mb-1">Total Pengiriman</div>
                <div class="text-3xl font-bold text-blue-800">0</div>
            </div>
            <div class="bg-white p-6 rounded-lg border-2 shadow text-center">
                <div class="text-gray-500 text-sm font-medium mb-1">Dalam Perjalanan</div>
                <div class="text-3xl font-bold text-green-800">0</div>
            </div>
            <div class="bg-white p-6 rounded-lg border-2 shadow text-center">
                <div class="text-gray-500 text-sm font-medium mb-1">Terlambat</div>
                <div class="text-3xl font-bold text-yellow-800">0</div>
            </div>
            <div class="bg-white p-6 rounded-lg border-2 shadow text-center">
                <div class="text-gray-500 text-sm font-medium mb-1">Penyimpangan</div>
                <div class="text-3xl font-bold text-red-800">7</div>
            </div>
        </div>

        <!-- Search Box -->
        <div class="mb-6">
            <div class="relative max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input 
                    type="text" 
                    id="searchInput"
                    class="block w-full pl-10 pr-3 py-2 border-2 border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Cari berdasarkan driver atau order ID..."
                >
            </div>
        </div>

        <!-- Notifications List -->
        <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Aktivitas Terkini</h2>
                <p class="text-sm text-gray-600">Update terakhir: {{ now()->format('d M Y H:i') }}</p>
            </div>
            
            <div class="divide-y divide-gray-200" id="notificationsContainer">
                @foreach ($notifications as $note)
                @php
                    // Activity Status
                    $activity = $note->activity_status ?? 'on_trip';
                    $activityColors = [
                        'rest' => 'bg-purple-100 text-purple-800',
                        'refuel' => 'bg-blue-100 text-blue-800',
                        'eating' => 'bg-green-100 text-green-800',
                        'trouble' => 'bg-red-100 text-red-800',
                        'on_trip' => 'bg-yellow-100 text-yellow-800'
                    ];
                    $activityIcons = [
                        'rest' => 'fas fa-bed',
                        'refuel' => 'fas fa-gas-pump',
                        'eating' => 'fas fa-utensils',
                        'trouble' => 'fas fa-exclamation-triangle',
                        'on_trip' => 'fas fa-truck-moving'
                    ];
                    
                    // Delivery Status
                    $status = $note->status ?? '';
                    $statusColors = [
                        'late' => 'bg-red-100 text-red-800',
                        'deviation' => 'bg-orange-100 text-orange-800',
                        'default' => 'bg-gray-100 text-gray-800'
                    ];
                    $statusTexts = [
                        'late' => 'Terlambat',
                        'deviation' => 'Penyimpangan',
                        'default' => 'Normal'
                    ];
                @endphp
                
                <div class="p-4 hover:bg-gray-50 transition cursor-pointer notification-card" 
                     data-driver="{{ strtolower($note->driver_name ?? '') }}"
                     data-order="{{ strtolower($note->order_id ?? '') }}">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="h-10 w-10 rounded-full {{ $activityColors[$activity] }} flex items-center justify-center">
                                <i class="{{ $activityIcons[$activity] }}"></i>
                            </div>
                        </div>
                        
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-gray-900">
                                    {{ $note->driver_name ?? 'N/A' }} 
                                    <span class="ml-2 text-xs px-2 py-1 rounded-full {{ $statusColors[$status] ?? $statusColors['default'] }}">
                                        {{ $statusTexts[$status] ?? $statusTexts['default'] }}
                                    </span>
                                </h3>
                                <span class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($note->created_at)->diffForHumans() }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-500 mt-1">
                                Order ID: <span class="font-medium">{{ $note->order_id ?? 'N/A' }}</span>
                            </p>
                            
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500">Berangkat</p>
                                    <p class="font-medium">
                                        {{ isset($note->departure_time) ? \Carbon\Carbon::parse($note->departure_time)->format('d M H:i') : 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Rencana</p>
                                    <p class="font-medium">
                                        {{ isset($note->planned_time) ? \Carbon\Carbon::parse($note->planned_time)->format('d M H:i') : 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Lokasi</p>
                                    <p class="font-medium">{{ $note->last_position ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Status</p>
                                    <p class="font-medium {{ $activityColors[$activity] }} px-2 py-1 rounded-full inline-block">
                                        <i class="{{ $activityIcons[$activity] }} mr-1"></i>
                                        @if($activity === 'rest') Istirahat
                                        @elseif($activity === 'refuel') Pengisian BBM
                                        @elseif($activity === 'eating') Makan
                                        @elseif($activity === 'trouble') Trouble Mobil
                                        @else Dalam Perjalanan
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            @if($status)
                            <div class="mt-3 p-3 rounded-lg {{ $status === 'late' ? 'bg-red-50' : 'bg-orange-50' }}">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="{{ $status === 'late' ? 'fas fa-clock text-red-500' : 'fas fa-map-marked-alt text-orange-500' }}"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium {{ $status === 'late' ? 'text-red-800' : 'text-orange-800' }}">
                                            {{ $status === 'late' ? 'Keterlambatan Terdeteksi' : 'Penyimpangan Rute' }}
                                        </h3>
                                        <div class="mt-1 text-sm {{ $status === 'late' ? 'text-red-700' : 'text-orange-700' }}">
                                            <p>
                                                {{ $note->message ?? ($status === 'late' ? 'Pengiriman mengalami keterlambatan' : 'Penyimpangan dari rute yang ditentukan') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                
                @if($notifications->isEmpty())
                <div class="p-12 text-center">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <i class="fas fa-bell-slash text-3xl"></i>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Tidak ada aktivitas yang perlu diperhatikan saat ini.
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const notificationCards = document.querySelectorAll('.notification-card');
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                notificationCards.forEach(card => {
                    const driverName = card.getAttribute('data-driver');
                    const orderId = card.getAttribute('data-order');
                    
                    if (driverName.includes(searchTerm) || orderId.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection