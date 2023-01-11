<?php

namespace SaasReady\Http\Responses;

use Illuminate\Http\Resources\Json\JsonResource;
use SaasReady\Models\DynamicSetting;

/** @mixin DynamicSetting */
class DynamicSettingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'settings' => $this->settings,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
