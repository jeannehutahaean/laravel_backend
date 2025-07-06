<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (string) $this->id,
            'vehicleNumber' => $this->vehicle->plate_number,
            'destinationName' => optional($this->route->first())->location_name,
            'eta' => $this->estimated_arrival->toIso8601String(),
            'completedAt' => optional($this->actual_arrival)->toIso8601String(),
            'type' => $this->goods_type,
            'punctualStatus' => $this->punctual_status ? ucwords($this->punctual_status) : 'Belum Sampai',
            'status' => $this->status_detail,
            'date' => optional($this->start_time)->format('Y-m-d'),
            'duration' => $this->duration,
            'startTime' => optional($this->start_time)->toIso8601String(),
            'locationTrack' => [
                'lat' => $this->current_latitude,
                'lng' => $this->current_longitude,
                'timestamp' => optional($this->updated_at)->toIso8601String(),
            ],
            'startLocation' => [
                'lat' => $this->route->first()?->start_latitude,
                'lng' => $this->route->first()?->start_longitude,
            ],
            'endLocation' => [
                'lat' => $this->route->first()?->end_latitude,
                'lng' => $this->route->first()?->end_longitude,
            ],
        ];
    }
}
