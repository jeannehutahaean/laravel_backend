<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'model',
    ];

    // Nonaktifkan created_at dan updated_at
    public $timestamps = false;

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
