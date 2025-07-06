<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverHistory extends Shipment
{
    protected $table = 'shipments';

    /**
     * Shipment belongs to a predefined shipment_route.
     */
    public function finalRoute(): BelongsTo
    {
        return $this->belongsTo(ShipmentRoute::class, 'shipment_route_id');
    }
}
