<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoutePoint extends Model
{
    use HasFactory;

    // Beri tahu Laravel bahwa model ini menggunakan tabel 'trackings'
    protected $table = 'trackings';

    // Kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'shipment_id',
        'latitude',
        'longitude',
        'timestamp',
    ];

    // Aktifkan timestamps (created_at dan updated_at)
    public $timestamps = true;
}
