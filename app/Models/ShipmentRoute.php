<?php
// app/Models/ShipmentRoute.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShipmentRoute extends Model
{
    use HasFactory;

    protected $table = 'shipment_routes';

    protected $fillable = [
        'shipment_id',
        'location_name',
        'latitude',
        'longitude',
        'route_order',
    ];

    public $timestamps = false;

}
