<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverVehicle extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['plate_number', 'model'];
}
