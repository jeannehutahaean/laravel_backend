<?php
class Shipment extends Model {
    protected $fillable = [
        'driver_id', 'vehicle_id', 'destination', 'start_time',
        'estimated_arrival', 'actual_arrival', 'goods_type', 'status'
    ];
}
?>