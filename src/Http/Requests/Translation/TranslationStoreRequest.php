<?php

namespace SaasReady\Http\Requests\Translation;

use Illuminate\Validation\Rule;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Models\Translation;
use SaasReady\Rules\TranslationValuesRule;

class TranslationStoreRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'translations.store';
    }

    public function rules(): array
    {
        return [
            'key' => [
                'required',
                'string',
                Rule::unique((new Translation())->getTable(), 'key'),
            ],
            'label' => 'required|string',
            'translations' => [
                'required',
                app(TranslationValuesRule::class),
            ],
        ];
    }
}
