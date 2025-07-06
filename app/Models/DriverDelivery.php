<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverDelivery extends Model
{
    protected $table = 'shipments';

    protected $fillable = [
        'status_detail',
        'started',
        'start_time',
        'estimated_arrival',
        'current_latitude',
        'current_longitude',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'estimated_arrival' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function route()
    {
        return $this->belongsTo(ShipmentRoute::class, 'shipment_route_id');
    }
}
