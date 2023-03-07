<?php

namespace SaasReady\Http\Requests\File;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Rules\ClassExistsRule;

class FileIndexRequest extends BaseFormRequest
{
    protected ?Model $model = null;

    protected function getEndpointName(): string
    {
        return 'files.index';
    }

    public function rules(): array
    {
        return [
            'limit' => 'required|int|max:100',
            'page' => 'required|int|min:1',
            'source_type' => [
                'required',
                'string',
                new ClassExistsRule(true),
            ],
            'source_id' => [
                'required',
            ],
            'load_related_model' => 'nullable|bool',
            'category' => 'nullable|string',
        ];
    }

    protected function passedValidation(): void
    {
        if (!$this->getRelatedModel()) {
            throw ValidationException::withMessages([
                'source_id' => 'Source is invalid',
            ]);
        }
    }

    public function getRelatedModel(): ?Model
    {
        return $this->source
            ??= $this->input('source_type')::find($this->input('source_id'));
    }
}
