<?php

namespace SaasReady\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use SaasReady\Models\Country;

/**
 * @mixin Country
 */
class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'code' => $this->code,
            'name' => $this->name,
            'dial_code' => $this->dial_code,
            'currency' => new CurrencyResource($this->whenLoaded('currency')),
            'is_active' => $this->is_active,
            'risk_level' => $this->risk_level,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->isHighRisk(),
        ];
    }
}
