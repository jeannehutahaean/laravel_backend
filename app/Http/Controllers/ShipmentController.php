<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentController extends Model
{
    use HasFactory;

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'driver_id',
        'vehicle_id',
        'destination',
        'start_time',
        'estimated_arrival',
        'goods_type',
        'status',
    ];

    // Jika Anda memiliki relasi dengan model lain (misalnya, relasi dengan User untuk driver_id),
    // Anda bisa menambahkannya di sini.
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
