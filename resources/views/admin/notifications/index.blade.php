@extends('admin.layouts.app')

@section('title', 'Notifikasi')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Monitoring dan Notifikasi Pengiriman</h1>
            <div class="flex space-x-2">
                <form method="GET" action="{{ route('admin.notifications.index') }}">
                    <button type="submit" class="px-4 py-2 bg-green-100 text-green-800 rounded-lg text-sm font-medium hover:bg-green-200 transition">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                    </button>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <x-summary-card label="Total Pengiriman" value="{{ $summary['total'] ?? 0 }}" color="text-blue-800" />
            <x-summary-card label="Dalam Perjalanan" value="{{ $summary['in_transit'] ?? 0 }}" color="text-green-800" />
            <x-summary-card label="Terlambat" value="{{ $summary['late'] ?? 0 }}" color="text-yellow-800" />
            <x-summary-card label="Penyimpangan" value="{{ $summary['deviation'] ?? 0 }}" color="text-red-800" />
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
                @forelse ($notifications as $note)
                    @include('admin.notifications.partials.card', ['note' => $note])
                @empty
                    <div class="p-12 text-center">
                        <div class="mx-auto h-12 w-12 text-gray-400">
                            <i class="fas fa-bell-slash text-3xl"></i>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Tidak ada aktivitas yang perlu diperhatikan saat ini.
                        </p>
                    </div>
                @endforelse
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
