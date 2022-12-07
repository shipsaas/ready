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
            'code' => $this->code,
            'symbol' => $this->symbol,
            'name' => $this->name,
            'decimal_separator' => $this->decimal_separator,
            'thousands_separator' => $this->thousands_separator,
            'space_after_symbol' => $this->space_after_symbol,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
