<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Location extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "uuid" => $this->uuid,
            "trackable_id" => $this->trackable_id,
            "trackable_type" => $this->trackable_type,
            "accuracy" => $this->accuracy,
            "altitude" => $this->altitude,
            "latitude" => $this->location->getLat(),
            "longitude" => $this->location->getLng(),
            "speed" => round(measurer()->transformMetersToKilometers($this->speed)),
            "odometer" => $this->odometer,
            "heading" => round($this->heading),
            "battery" => round((float) $this->battery_level * 100),
            "activity" => $this->activity_type,
            "confidence" => $this->activity_confidence,
            "moving" => (bool) $this->is_moving,
            "charging" => (bool) $this->battery_is_charging,
            "event" => is_null($this->event) ? 'default' : $this->event,
            "generated_at" => is_null($this->generated_at) ? null : $this->generated_at->format('Y-m-d H:i:s'),
            "created_at" => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
