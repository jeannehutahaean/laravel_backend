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
            <!-- Total Pengiriman -->
            <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-6">
                <p class="text-sm font-medium text-gray-600">Total Pengiriman</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalShipments }}</p>
            </div>

            <!-- Tepat Waktu -->
            <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-6">
                <p class="text-sm font-medium text-gray-600">Tepat Waktu</p>
                <p class="text-3xl font-bold text-green-700 mt-2">{{ $onTime }}</p>
            </div>

            <!-- Terlambat -->
            <div class="bg-white rounded-lg border-2 border-gray-200 shadow-sm p-6">
                <p class="text-sm font-medium text-gray-600">Terlambat</p>
                <p class="text-3xl font-bold text-red-700 mt-2">{{ $late }}</p>
            </div>

            <!-- Rata-rata Waktu -->
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                                No. Order
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                                Tanggal Dibuat
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                                Deskripsi Produk
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                                Kuantitas Pengiriman
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                                Total Jam Perjalanan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                                Status & Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Order 1 - Draft -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                ON-3000
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                26 Okt 2022<br>
                                <span class="text-gray-500">15:40 WIB</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                Paket Elektronik
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                10
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                2 jam 30 menit
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex flex-col space-y-2">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800 border border-gray-300">
                                        Draft
                                    </span>
                                    <div class="flex space-x-2 mt-2">
                                        <button onclick="confirmDelivery('ON-3000')" 
                                                class="px-4 py-1.5 bg-blue-600 text-white text-xs rounded-full hover:bg-blue-700 transition flex items-center shadow-sm hover:shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Konfirmasi
                                        </button>
                                        <button onclick="cancelDelivery('ON-3000')" 
                                                class="px-4 py-1.5 bg-red-600 text-white text-xs rounded-full hover:bg-gray-700 transition flex items-center shadow-sm hover:shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Batalkan
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Order 2 - Confirmed -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                ON-2999
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                19 Sep 2022<br>
                                <span class="text-gray-500">14:30 WIB</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                Paket Makanan
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                8
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                1 jam 45 menit
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex flex-col space-y-2">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Dikonfirmasi
                                    </span>
                                    <div class="flex space-x-2 mt-2">
                                        <button onclick="cancelDelivery('ON-2999')" 
                                                class="px-4 py-1.5 bg-red-600 text-white text-xs rounded-full hover:bg-red-700 transition flex items-center shadow-sm hover:shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Batalkan
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Order 3 - Cancelled -->
                        <tr class="hover:bg-gray-50 bg-red-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                ON-2998
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                19 Sep 2022<br>
                                <span class="text-gray-500">14:15 WIB</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                Paket Pakaian
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                15
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">
                                3 jam 15 menit
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex flex-col space-y-2">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                        Dibatalkan
                                    </span>
                                    <div class="flex space-x-2 mt-2">
                                        <button onclick="confirmDelivery('ON-2998')" 
                                                class="px-4 py-1.5 bg-blue-600 text-white text-xs rounded-full hover:bg-blue-700 transition flex items-center shadow-sm hover:shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Konfirmasi Ulang
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelivery(orderId) {
            if(confirm(`Apakah Anda yakin ingin mengkonfirmasi pengiriman ${orderId}?`)) {
                // Kirim request confirm ke server
                fetch(`/admin/shipments/${orderId}/confirm`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('Pengiriman berhasil dikonfirmasi');
                        location.reload();
                    } else {
                        alert('Gagal mengkonfirmasi pengiriman');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengkonfirmasi pengiriman');
                });
            }
        }

        function cancelDelivery(orderId) {
            if(confirm(`Apakah Anda yakin ingin membatalkan pengiriman ${orderId}?`)) {
                // Kirim request cancel ke server
                fetch(`/admin/shipments/${orderId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('Pengiriman berhasil dibatalkan');
                        location.reload();
                    } else {
                        alert('Gagal membatalkan pengiriman');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat membatalkan pengiriman');
                });
            }
        }
    </script>
@endsection