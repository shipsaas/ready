<?php

namespace SaasReady\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use SaasReady\Models\Event;

/**
 * @mixin Event
 */
class EventResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'category' => $this->category,
            'properties' => $this->properties,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),

            'model' => $this->whenLoaded('model'),
            'user' => $this->whenLoaded('user'),
        ];
    }
}
