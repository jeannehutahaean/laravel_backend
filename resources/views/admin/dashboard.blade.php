@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flight-tracker-container">
    <!-- Main Content -->
    <div class="tracker-content">
        <!-- Left Sidebar Toggle Button -->
        <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Map Container (Full Width) -->
        <div class="map-container">
            <div id="map"></div>
            <div class="map-controls">
            </div>
        </div>

        <!-- Left Sidebar - Active Shipments (Overlay) -->
        <div class="left-sidebar" id="leftSidebar">
            <div class="sidebar-header">
                <h3>Live Shipment Tracker</h3>
                <button class="close-btn" onclick="toggleSidebar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Stats Section -->
            <div class="stats-section">
                <div class="stat-item">
                    <span class="stat-number">{{ $ongoingShipments }}</span>
                    <span class="stat-label">Active Shipments</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $completedShipments }}</span>
                    <span class="stat-label">Completed</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $delayedShipments }}</span>
                    <span class="stat-label">Delayed</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $vehicleCount }}</span>
                    <span class="stat-label">Total Vehicles</span>
                </div>
            </div>
            
            <div class="shipment-section-header">
                <h4>Active Shipments</h4>
                <span class="shipment-count">{{ $ongoingShipments }} active</span>
            </div>
            
            <div class="shipment-list">
                @foreach($activeShipments as $shipment)
                    @if($shipment->current_latitude && $shipment->current_longitude)
                    <div class="shipment-item" 
                         data-shipment-id="{{ $shipment->id }}"
                         onclick="focusShipment({{ $shipment->id }})">
                        <div class="shipment-header">
                            <div class="shipment-id">SH{{ str_pad($shipment->id, 4, '0', STR_PAD_LEFT) }}</div>
                            <div class="status-badge status-{{ $shipment->status_detail }}">
                                {{ ucfirst($shipment->status_detail) }}
                            </div>
                        </div>
                        <div class="shipment-details">
                            <div class="route-info">
                                <span class="route-from">{{ $shipment->route->location_name ?? 'Unknown' }}</span>
                            </div>
                            <div class="driver-info">
                                <i class="fas fa-user"></i>
                                {{ $shipment->driver->driver_name ?? 'Unknown Driver' }}
                            </div>
                            <div class="vehicle-info">
                                <i class="fas fa-truck"></i>
                                {{ $shipment->vehicle->plate_number ?? 'Unknown' }}
                            </div>
                            <div class="time-info">
                                <i class="fas fa-clock"></i>
                                {{ \Carbon\Carbon::parse($shipment->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($shipment->estimated_arrival)->format('H:i') }}
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Right Sidebar - Shipment Details (Overlay) -->
        <div class="right-sidebar" id="rightSidebar">
            <div class="sidebar-header">
                <h3>Shipment Details</h3>
                <button class="close-btn" onclick="closeDetails()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="details-content" id="detailsContent">
                <div class="no-selection">
                    <i class="fas fa-mouse-pointer"></i>
                    <p>Click on a shipment marker to view details</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.flight-tracker-container {
    height: 100vh;
    display: flex;
    flex-direction: column;
    background: #f8f9fa;
    color: #333333;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.tracker-content {
    display: flex;
    flex: 1;
    overflow: hidden;
    position: relative;
}

.sidebar-toggle {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.95);
    border: 2px solid #e0e0e0;
    color: #333333;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

.sidebar-toggle:hover {
    background: rgba(245, 245, 245, 0.95);
    border-color: #007bff;
    color: #007bff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

.left-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 380px;
    height: 100vh;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-right: 2px solid #e0e0e0;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: transform 0.3s ease;
    box-shadow: 2px 0 20px rgba(0, 0, 0, 0.1);
    z-index: 999;
}

.left-sidebar.hidden {
    transform: translateX(-100%);
}

.right-sidebar {
    position: fixed;
    top: 0;
    right: 0;
    width: 350px;
    height: 100vh;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-left: 2px solid #e0e0e0;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transform: translateX(100%);
    transition: transform 0.3s ease;
    box-shadow: -2px 0 20px rgba(0, 0, 0, 0.1);
    z-index: 999;
}

.right-sidebar.active {
    transform: translateX(0);
}

.sidebar-header {
    padding: 20px;
    background: linear-gradient(135deg, rgba(248, 249, 250, 0.9), rgba(233, 236, 239, 0.9));
    border-bottom: 2px solid #e0e0e0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    backdrop-filter: blur(10px);
}

.sidebar-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333333;
}

.stats-section {
    background: rgba(248, 249, 250, 0.8);
    border-bottom: 2px solid #e0e0e0;
    padding: 15px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    backdrop-filter: blur(10px);
}

.stat-item {
    text-align: center;
    padding: 15px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.stat-number {
    display: block;
    font-size: 24px;
    font-weight: 700;
    color: #007bff;
    margin-bottom: 5px;
}

.stat-label {
    display: block;
    font-size: 12px;
    color: #6c757d;
    font-weight: 500;
}

.shipment-section-header {
    padding: 15px 20px;
    background: rgba(248, 249, 250, 0.8);
    border-bottom: 1px solid #e0e0e0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    backdrop-filter: blur(10px);
}

.shipment-section-header h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #333333;
}

.shipment-count {
    background: #007bff;
    color: #ffffff;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.close-btn {
    background: none;
    border: none;
    color: #6c757d;
    font-size: 18px;
    cursor: pointer;
    padding: 5px;
    border-radius: 4px;
    transition: all 0.2s;
}

.close-btn:hover {
    background: rgba(248, 249, 250, 0.8);
    color: #333333;
}

.shipment-list {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
}

.shipment-item {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    backdrop-filter: blur(10px);
}

.shipment-item:hover {
    background: rgba(248, 249, 250, 0.9);
    border-color: #007bff;
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
}

.shipment-item.selected {
    background: rgba(248, 249, 250, 0.9);
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
}

.shipment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.shipment-id {
    font-weight: 700;
    font-size: 16px;
    color: #007bff;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-active {
    background: #28a745;
    color: #ffffff;
}

.status-waiting {
    background: #ffc107;
    color: #333333;
}

.status-completed {
    background: #17a2b8;
    color: #ffffff;
}

.shipment-details {
    font-size: 13px;
    color: #6c757d;
}

.shipment-details > div {
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.shipment-details i {
    width: 12px;
    color: #007bff;
}

.route-info {
    font-weight: 600;
    color: #333333;
}

.route-from, .route-to {
    max-width: 80px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.map-container {
    flex: 1;
    width: 100%;
    height: 100vh;
    position: relative;
    overflow: hidden;
}

#map {
    width: 100%;
    height: 100%;
    /* Menggunakan default Leaflet styling */
}

.map-controls {
    position: fixed;
    top: 20px;
    right: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 998;
}

.map-btn {
    background: rgba(255, 255, 255, 0.95);
    border: 2px solid #e0e0e0;
    color: #333333;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

.map-btn:hover {
    background: rgba(245, 245, 245, 0.95);
    border-color: #007bff;
    color: #007bff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

.details-content {
    padding: 20px;
    flex: 1;
    overflow-y: auto;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
}

.no-selection {
    text-align: center;
    color: #6c757d;
    padding: 40px 20px;
}

.no-selection i {
    font-size: 48px;
    margin-bottom: 15px;
    color: #e0e0e0;
}

.detail-section {
    margin-bottom: 25px;
}

.detail-section h4 {
    color: #007bff;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #e0e0e0;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    color: #6c757d;
    font-size: 13px;
}

.detail-value {
    color: #333333;
    font-weight: 600;
    font-size: 13px;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
    margin-top: 10px;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #007bff, #0056b3);
    transition: width 0.3s ease;
}

/* Scrollbar Styling */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(248, 249, 250, 0.8);
}

::-webkit-scrollbar-thumb {
    background: rgba(224, 224, 224, 0.8);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 123, 255, 0.8);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .left-sidebar, .right-sidebar {
        width: 320px;
    }
    
    .stats-section {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    
    .stat-item {
        padding: 12px;
    }
}

@media (max-width: 768px) {
    .left-sidebar {
        width: 100%;
        height: 60vh;
    }
    
    .right-sidebar {
        width: 100%;
        height: 100vh;
    }
    
    .sidebar-toggle {
        top: 10px;
        left: 10px;
        padding: 10px;
    }
    
    .map-controls {
        top: 10px;
        right: 10px;
    }
    
    .stats-section {
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        padding: 10px;
    }
    
    .stat-number {
        font-size: 20px;
    }
}
</style>
@endsection

@section('scripts')
    {{-- Leaflet CDN --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    
    <script>
    // Initialize map dengan default Leaflet styling
    const map = L.map('map', {
        zoomControl: false,
        attributionControl: false
    }).setView([-6.2, 106.8], 6);

    // Default OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add zoom control to bottom right
    L.control.zoom({
        position: 'bottomright'
    }).addTo(map);

    const shipments = @json($activeShipments);
    const shipmentMarkers = {};
    const shipmentLayers = {};
    let selectedShipment = null;

    // Create custom icons
    const createCustomIcon = (color, isSelected = false) => {
        const size = isSelected ? 35 : 25;
        return L.divIcon({
            html: `<div style="
                width: ${size}px;
                height: ${size}px;
                background: ${color};
                border: 3px solid #ffffff;
                border-radius: 50%;
                position: relative;
                box-shadow: 0 0 ${isSelected ? '20px' : '10px'} rgba(0, 123, 255, ${isSelected ? '0.4' : '0.2'});
            ">
                <div style="
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    width: 8px;
                    height: 8px;
                    background: #ffffff;
                    border-radius: 50%;
                "></div>
            </div>`,
            className: 'custom-marker',
            iconSize: [size, size],
            iconAnchor: [size/2, size/2]
        });
    };

    // Add markers for all active shipments
    shipments.forEach(shipment => {
        if (shipment.current_latitude && shipment.current_longitude) {
            const lat = parseFloat(shipment.current_latitude);
            const lng = parseFloat(shipment.current_longitude);
            
            const marker = L.marker([lat, lng], {
                icon: createCustomIcon('#007bff', false)
            }).addTo(map);

            marker.on('click', () => {
                focusShipment(shipment.id);
            });

            shipmentMarkers[shipment.id] = marker;
        }
    });

    // OpenRouteService API
    const ORS_API_KEY = "5b3ce3597851110001cf6248ed0a5ec959824be3b1a20720f39ddceb";

    async function getRouteCoords(start, end) {
        try {
            const url = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=${ORS_API_KEY}&start=${start[1]},${start[0]}&end=${end[1]},${end[0]}`;
            const response = await fetch(url);
            
            if (!response.ok) return null;
            
            const data = await response.json();
            const coords = data.features[0].geometry.coordinates;
            return coords.map(coord => [coord[1], coord[0]]);
        } catch (error) {
            console.error('Error fetching route:', error);
            return null;
        }
    }

    function clearAllLayers() {
        Object.values(shipmentLayers).forEach(layers => {
            layers.forEach(layer => map.removeLayer(layer));
        });
        
        // Reset all markers
        Object.values(shipmentMarkers).forEach(marker => {
            marker.setIcon(createCustomIcon('#007bff', false));
        });
        
        // Clear selection
        document.querySelectorAll('.shipment-item').forEach(item => {
            item.classList.remove('selected');
        });
    }

    async function focusShipment(id) {
        clearAllLayers();
        
        const shipment = shipments.find(s => s.id === id);
        if (!shipment) return;

        selectedShipment = shipment;
        
        // Highlight selected marker
        if (shipmentMarkers[id]) {
            shipmentMarkers[id].setIcon(createCustomIcon('#dc3545', true));
        }
        
        // Highlight selected shipment in list
        document.querySelectorAll('.shipment-item').forEach(item => {
            if (item.dataset.shipmentId == id) {
                item.classList.add('selected');
            }
        });

        const layers = [];
        const route = shipment.route || {};
        const currentLat = parseFloat(shipment.current_latitude);
        const currentLng = parseFloat(shipment.current_longitude);

        // Add route visualization
        if (route.start_latitude && route.start_longitude && route.end_latitude && route.end_longitude) {
            // Route from start to current position (completed - green)
            const startPath = await getRouteCoords(
                [parseFloat(route.start_latitude), parseFloat(route.start_longitude)],
                [currentLat, currentLng]
            );
            
            if (startPath) {
                const completedRoute = L.polyline(startPath, {
                    color: '#28a745',
                    weight: 4,
                    opacity: 0.8
                }).addTo(map);
                layers.push(completedRoute);
            }

            // Route from current to end (remaining - blue)
            const remainingPath = await getRouteCoords(
                [currentLat, currentLng],
                [parseFloat(route.end_latitude), parseFloat(route.end_longitude)]
            );
            
            if (remainingPath) {
                const remainingRoute = L.polyline(remainingPath, {
                    color: '#007bff',
                    weight: 4,
                    opacity: 0.8,
                    dashArray: '10, 5'
                }).addTo(map);
                layers.push(remainingRoute);
            }
        }

        shipmentLayers[id] = layers;
        
        // Center map on current position
        map.setView([currentLat, currentLng], 12);
        
        // Show details in right sidebar
        showShipmentDetails(shipment);
    }

    function showShipmentDetails(shipment) {
        const rightSidebar = document.getElementById('rightSidebar');
        const detailsContent = document.getElementById('detailsContent');
        
        const startTime = new Date(shipment.start_time);
        const estimatedArrival = new Date(shipment.estimated_arrival);
        const now = new Date();
        const totalDuration = estimatedArrival - startTime;
        const elapsed = now - startTime;
        const progress = Math.min(Math.max((elapsed / totalDuration) * 100, 0), 100);

        detailsContent.innerHTML = `
            <div class="detail-section">
                <h4>Shipment Information</h4>
                <div class="detail-row">
                    <span class="detail-label">Shipment ID</span>
                    <span class="detail-value">SH${String(shipment.id).padStart(4, '0')}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-value">
                        <span class="status-badge status-${shipment.status_detail}">
                            ${shipment.status_detail.charAt(0).toUpperCase() + shipment.status_detail.slice(1)}
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Goods Type</span>
                    <span class="detail-value">${shipment.goods_type}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Punctuality</span>
                    <span class="detail-value">${shipment.punctual_status}</span>
                </div>
            </div>

            <div class="detail-section">
                <h4>Driver Information</h4>
                <div class="detail-row">
                    <span class="detail-label">Name</span>
                    <span class="detail-value">${shipment.driver?.driver_name || 'Unknown'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Username</span>
                    <span class="detail-value">${shipment.driver?.driver_username || 'Unknown'}</span>
                </div>
            </div>

            <div class="detail-section">
                <h4>Vehicle Information</h4>
                <div class="detail-row">
                    <span class="detail-label">Model</span>
                    <span class="detail-value">${shipment.vehicle?.model || 'Unknown'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Plate Number</span>
                    <span class="detail-value">${shipment.vehicle?.plate_number || 'Unknown'}</span>
                </div>
            </div>

            <div class="detail-section">
                <h4>Route Information</h4>
                <div class="detail-row">
                    <span class="detail-label">From</span>
                    <span class="detail-value">${shipment.route?.location_name || 'Unknown'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Current Position</span>
                    <span class="detail-value">${shipment.current_latitude}, ${shipment.current_longitude}</span>
                </div>
            </div>

            <div class="detail-section">
                <h4>Timeline</h4>
                <div class="detail-row">
                    <span class="detail-label">Start Time</span>
                    <span class="detail-value">${startTime.toLocaleString()}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Est. Arrival</span>
                    <span class="detail-value">${estimatedArrival.toLocaleString()}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Progress</span>
                    <span class="detail-value">${Math.round(progress)}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: ${progress}%"></div>
                </div>
            </div>
        `;
        
        rightSidebar.classList.add('active');
    }

    function closeDetails() {
        const rightSidebar = document.getElementById('rightSidebar');
        rightSidebar.classList.remove('active');
        clearAllLayers();
        selectedShipment = null;
    }

    function resetMapView() {
        map.setView([-6.2, 106.8], 6);
        clearAllLayers();
        closeDetails();
    }

    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            document.exitFullscreen();
        }
    }

    // Toggle sidebar function
    function toggleSidebar() {
        const sidebar = document.getElementById('leftSidebar');
        sidebar.classList.toggle('hidden');
        
        // Trigger map resize after sidebar animation
        setTimeout(() => {
            map.invalidateSize();
        }, 300);
    }

    // Auto-refresh every 30 seconds
    setInterval(() => {
        if (selectedShipment) {
            // Refresh selected shipment data
            focusShipment(selectedShipment.id);
        }
    }, 30000);

    // Initialize map bounds to show all markers
    if (Object.keys(shipmentMarkers).length > 0) {
        const group = new L.featureGroup(Object.values(shipmentMarkers));
        map.fitBounds(group.getBounds().pad(0.1));
    }
    </script>
@endsection