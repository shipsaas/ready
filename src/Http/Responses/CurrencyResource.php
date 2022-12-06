<?php

namespace SaasReady\Http\Responses;

use Illuminate\Http\Resources\Json\JsonResource;
use SaasReady\Models\Currency;

/**
 * @mixin Currency
 */
class CurrencyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
        ];
    }
}
