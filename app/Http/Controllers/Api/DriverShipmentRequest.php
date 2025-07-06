<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverShipmentRequest extends Model
{
    protected $table = 'shipments';

    protected $fillable = [
        'driver_id',
        'vehicle_id',
        'shipment_route_id',
        'estimated_arrival',
        'goods_type',
        'status_detail',
        'started',
        'start_time',
    ];

    protected $casts = [
        'estimated_arrival' => 'datetime',
        'start_time' => 'datetime',
    ];
}
