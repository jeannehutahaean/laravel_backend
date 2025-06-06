<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'latitude',
        'longitude',
        'timestamp',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
