<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class Driver extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'drivers';
    protected $primaryKey = 'driver_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'driver_name',
        'driver_username',
        'driver_email',
        'driver_password',
        'driver_no_ktp',
        'driver_no_kk',
        'driver_photo_ktp',
        'driver_photo_kk',
        'driver_photo_profile',
        'driver_address',
        'driver_birthplace',
        'driver_birthdate',
    ];

    protected $hidden = [
        'driver_password',
        'remember_token',
    ];

    /**
     * Relasi ke tabel shipments
     */
    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'driver_id','driver_id');
    }

    /**
     * Menghitung total durasi jam perjalanan driver (dalam jam)
     */
    public function totalTravelHours()
    {
        return $this->shipments
            ->filter(fn($shipment) => $shipment->start_time && $shipment->end_time)
            ->sum(function ($shipment) {
                $start = Carbon::parse($shipment->start_time);
                $end = Carbon::parse($shipment->end_time);
                return $start->diffInMinutes($end) / 60; // dalam jam
            });
    }

    /**
     * Menghitung rata-rata durasi perjalanan driver (dalam menit)
     */
    public function averageTravelTime()
    {
        $filtered = $this->shipments
            ->filter(fn($shipment) => $shipment->start_time && $shipment->end_time);

        $totalShipments = $filtered->count();

        if ($totalShipments === 0) return 0;

        $totalMinutes = $filtered->sum(function ($shipment) {
            $start = Carbon::parse($shipment->start_time);
            $end = Carbon::parse($shipment->end_time);
            return $start->diffInMinutes($end);
        });

        return round($totalMinutes / $totalShipments);
    }
}
