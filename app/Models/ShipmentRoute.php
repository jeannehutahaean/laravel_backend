<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShipmentRoute extends Model
{
    use HasFactory;

    protected $table = 'shipment_routes';

    protected $fillable = [
        'location_name',
        'start_latitude',
        'start_longitude',
        'end_latitude',
        'end_longitude',
        'is_final_destination',
    ];

    public $timestamps = true;
}
