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
        'shipment_route_id',
        'destination',
        'start_time',
        'estimated_arrival',
        'actual_arrival',
        'goods_type',
        'status',
        'current_latitude',
        'current_longitude',
        'start_latitude',
        'start_longitude',
        'end_latitude',
        'end_longitude',
    ];

public function getTravelDurationAttribute()
{
    if (!$this->start_time || !$this->actual_arrival) return null;

    $start = \Carbon\Carbon::parse($this->start_time);
    $end = \Carbon\Carbon::parse($this->actual_arrival);
    $diff = $start->diff($end);

    return sprintf('%d jam %d menit', $diff->h + ($diff->days * 24), $diff->i);
}

    /**
     * Eager load relasi default (jika ingin otomatis terbaca saat query).
     */
    protected $with = ['driver', 'vehicle', 'route'];

    /**
     * Relasi ke model Driver (pengemudi).
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'driver_id');
    }

    /**
     * Relasi ke model Vehicle (kendaraan).
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id','id');
    }

    /**
     * Relasi ke model ShipmentRoute (rute pengiriman).
     */
    public function route()
    {
        return $this->belongsTo(ShipmentRoute::class, 'shipment_route_id', 'id');
    }

    /**
     * Hitung total jam perjalanan (jika actual dan start tersedia).
     */
    public function getTotalDurationHoursAttribute()
    {
        if ($this->actual_arrival && $this->start_time) {
            return round((strtotime($this->actual_arrival) - strtotime($this->start_time)) / 3600, 2);
        }
        return null;
    }

    /**
     * Cek apakah shipment aktif.
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
