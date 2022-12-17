<?php

namespace SaasReady\Http\Requests\Event;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use SaasReady\Http\Requests\BaseFormRequest;

class EventIndexRequest extends BaseFormRequest
{
    private ?Model $source = null;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'limit' => 'required|int|max:100',
            'page' => 'required|int|min:1',
            'source_type' => 'required|string',
            'source_id' => 'required|int',
            'user_id' => 'nullable|int',
            'load_related_model' => 'nullable|bool',
        ];
    }

    protected function passedValidation()
    {
        if (!class_exists($this->input('source_type'))) {
            throw ValidationException::withMessages([
                'source_type' => 'Source Type is not a valid Eloquent Class',
            ]);
        }

        if (!$this->getRelatedModel()) {
            throw ValidationException::withMessages([
                'source_id' => 'Source is invalid',
            ]);
        }
    }

    public function getLimit(): int
    {
        return $this->input('limit') ?: 10;
    }

    public function getUserId(): int
    {
        return $this->integer('user_id');
    }

    public function getRelatedModel(): Model
    {
        return $this->source
            ??= $this->input('source_type')::find($this->input('source_id'));
    }
}
