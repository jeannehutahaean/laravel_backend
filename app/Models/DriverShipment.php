<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverShipment extends Model
{
    protected $table = 'shipments';

    protected $fillable = [
        'driver_id', 'vehicle_id', 'shipment_route_id',
        'start_time', 'estimated_arrival', 'goods_type',
        'status_detail', 'started', 'punctual_status', 'created_at'
    ];

    public function vehicle()
    {
        return $this->belongsTo(DriverVehicle::class, 'vehicle_id');
    }
        
    public function route()
    {
        return $this->belongsTo(DriverShipmentRoute::class, 'shipment_route_id');
    }

}
