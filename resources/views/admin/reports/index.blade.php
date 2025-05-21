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
                                10.000 KG
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
                                        <button onclick="showConfirmModal('ON-3000')" 
                                                class="px-4 py-1.5 bg-blue-600 text-white text-xs rounded-full hover:bg-blue-700 transition flex items-center shadow-sm hover:shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Konfirmasi
                                        </button>
                                        <button onclick="showCancelModal('ON-3000')" 
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
                                8.400 KG
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
                                        <button onclick="showCancelModal('ON-2999')" 
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
                                2.000 KG
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
                                        <button onclick="showReconfirmModal('ON-2998')" 
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

    <!-- Konfirmasi Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all duration-300 scale-95" id="confirmModalContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Pengiriman</h3>
                    <button onclick="hideModal('confirmModal')" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 mb-6" id="confirmModalText">Apakah Anda yakin ingin mengkonfirmasi pengiriman ini?</p>
                <div class="flex justify-end space-x-3">
                    <button onclick="hideModal('confirmModal')" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Batal
                    </button>
                    <button onclick="processConfirmation()" class="px-4 py-2 bg-blue-600 rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Konfirmasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Batalkan Modal -->
    <div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all duration-300 scale-95" id="cancelModalContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Batalkan Pengiriman</h3>
                    <button onclick="hideModal('cancelModal')" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 mb-6" id="cancelModalText">Apakah Anda yakin ingin membatalkan pengiriman ini?</p>
                <div class="flex justify-end space-x-3">
                    <button onclick="hideModal('cancelModal')" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Tidak
                    </button>
                    <button onclick="processCancellation()" class="px-4 py-2 bg-red-600 rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        Ya, Batalkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Konfirmasi Ulang Modal -->
    <div id="reconfirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all duration-300 scale-95" id="reconfirmModalContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Ulang Pengiriman</h3>
                    <button onclick="hideModal('reconfirmModal')" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 mb-6" id="reconfirmModalText">Apakah Anda yakin ingin mengkonfirmasi ulang pengiriman ini?</p>
                <div class="flex justify-end space-x-3">
                    <button onclick="hideModal('reconfirmModal')" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Batal
                    </button>
                    <button onclick="processReconfirmation()" class="px-4 py-2 bg-blue-600 rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Konfirmasi Ulang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div class="flex items-center p-4 rounded-lg shadow-lg bg-white border-l-4 border-green-500 transform transition-all duration-500 translate-x-full">
            <div class="mr-3">
                <svg id="toast-icon" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p id="toast-message" class="text-sm font-medium text-gray-800">Pengiriman berhasil dikonfirmasi</p>
            </div>
            <button onclick="hideToast()" class="ml-4 text-gray-400 hover:text-gray-500">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        let currentOrderId = null;
        let currentAction = null;

        function showConfirmModal(orderId) {
            currentOrderId = orderId;
            currentAction = 'confirm';
            document.getElementById('confirmModalText').textContent = `Apakah Anda yakin ingin mengkonfirmasi pengiriman ${orderId}?`;
            
            const modal = document.getElementById('confirmModal');
            modal.classList.remove('pointer-events-none');
            modal.classList.add('pointer-events-auto');
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            
            setTimeout(() => {
                document.getElementById('confirmModalContent').classList.remove('scale-95');
                document.getElementById('confirmModalContent').classList.add('scale-100');
            }, 10);
        }

        function showCancelModal(orderId) {
            currentOrderId = orderId;
            currentAction = 'cancel';
            document.getElementById('cancelModalText').textContent = `Apakah Anda yakin ingin membatalkan pengiriman ${orderId}?`;
            
            const modal = document.getElementById('cancelModal');
            modal.classList.remove('pointer-events-none');
            modal.classList.add('pointer-events-auto');
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            
            setTimeout(() => {
                document.getElementById('cancelModalContent').classList.remove('scale-95');
                document.getElementById('cancelModalContent').classList.add('scale-100');
            }, 10);
        }

        function showReconfirmModal(orderId) {
            currentOrderId = orderId;
            currentAction = 'reconfirm';
            document.getElementById('reconfirmModalText').textContent = `Apakah Anda yakin ingin mengkonfirmasi ulang pengiriman ${orderId}?`;
            
            const modal = document.getElementById('reconfirmModal');
            modal.classList.remove('pointer-events-none');
            modal.classList.add('pointer-events-auto');
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            
            setTimeout(() => {
                document.getElementById('reconfirmModalContent').classList.remove('scale-95');
                document.getElementById('reconfirmModalContent').classList.add('scale-100');
            }, 10);
        }

        function hideModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = document.getElementById(`${modalId}Content`);
            
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0');
                modal.classList.remove('pointer-events-auto');
                modal.classList.add('pointer-events-none');
            }, 200);
        }

        function showToast(message, isSuccess = true) {
            const toast = document.getElementById('toast');
            const toastIcon = document.getElementById('toast-icon');
            const toastMessage = document.getElementById('toast-message');
            const toastContainer = toast.querySelector('div');
            
            // Set message and icon
            toastMessage.textContent = message;
            
            if (isSuccess) {
                toastIcon.classList.remove('text-red-500');
                toastIcon.classList.add('text-green-500');
                toastContainer.classList.remove('border-red-500');
                toastContainer.classList.add('border-green-500');
                // Success icon
                toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
            } else {
                toastIcon.classList.remove('text-green-500');
                toastIcon.classList.add('text-red-500');
                toastContainer.classList.remove('border-green-500');
                toastContainer.classList.add('border-red-500');
                // Error icon
                toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />';
            }
            
            // Show toast with animation
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.querySelector('div').classList.remove('translate-x-full');
            }, 10);
            
            // Auto hide after 3 seconds
            setTimeout(hideToast, 3000);
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            toast.querySelector('div').classList.add('translate-x-full');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 500);
        }

        function processConfirmation() {
            hideModal('confirmModal');
            sendRequest(currentOrderId, 'confirm');
        }

        function processCancellation() {
            hideModal('cancelModal');
            sendRequest(currentOrderId, 'cancel');
        }

        function processReconfirmation() {
            hideModal('reconfirmModal');
            sendRequest(currentOrderId, 'confirm');
        }

        function sendRequest(orderId, action) {
            const endpoint = action === 'confirm' ? 'confirm' : 'cancel';
            
            fetch(`/admin/shipments/${orderId}/${endpoint}`, {
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
                    let message = action === 'confirm' ? 'Pengiriman berhasil dikonfirmasi' : 'Pengiriman berhasil dibatalkan';
                    showToast(message, true);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message || 'Terjadi kesalahan', false);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat memproses permintaan', false);
            });
        }
    </script>
@endsection