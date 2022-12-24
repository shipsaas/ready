<?php

namespace SaasReady\Services;

use SaasReady\Contracts\TranslationRepositoryContract;

class Translator
{
    public function __construct(private TranslationRepositoryContract $translationRepository)
    {
    }

    public function translate(string $key, array $variables = []): string
    {
        $translatedText = $this->translationRepository->getTranslation($key);

        $replacements = collect($variables)->mapWithKeys(fn ($value, $placeholder) => [
            '{' . trim($placeholder, '{}') . '}' => $value,
        ])->toArray();

        return strtr($translatedText, $replacements);
    }
}
