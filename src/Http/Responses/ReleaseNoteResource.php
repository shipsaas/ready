<?php

namespace SaasReady\Http\Responses;

use Illuminate\Http\Resources\Json\JsonResource;
use SaasReady\Models\ReleaseNote;

/**
 * @mixin ReleaseNote
 */
class ReleaseNoteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'version' => $this->version,
            'note' => $this->note,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
