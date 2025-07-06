<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverHistoryDetail extends Shipment
{
    protected $table = 'shipments';

    public function route(): BelongsTo
    {
        return $this->belongsTo(ShipmentRoute::class, 'shipment_route_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
