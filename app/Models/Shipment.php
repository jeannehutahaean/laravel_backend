<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'vehicle_id',
        'destination',
        'start_time',
        'estimated_arrival',
        'actual_arrival',
        'goods_type',
        'status',
    ];

    public function driver()
{
    return $this->belongsTo(Driver::class);
}

public function vehicle()
{
    return $this->belongsTo(Vehicle::class);
}

public function latestTracking()
{
    return $this->hasOne(Tracking::class)->latestOfMany();
}

}
