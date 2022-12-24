<?php

namespace SaasReady\Services\TranslationRepositories;

use Illuminate\Foundation\Application;
use SaasReady\Contracts\TranslationRepositoryContract;
use SaasReady\Models\Translation;

class DatabaseTranslationRepository implements TranslationRepositoryContract
{
    protected string $langCode;
    protected array $translations = [];

    public function __construct(Application $laravel)
    {
        $this->langCode = $laravel->getLocale();

        if (config('saas-ready.translation.strategy') === 'all') {
            $this->translations = $this->getTransformedTranslations();
        }
    }

    public function getTranslation(string $key): string
    {
        if (isset($this->translations[$key])) {
            return $this->translations[$key];
        }

        if (config('saas-ready.translation.strategy') === 'single') {
            $translation = Translation::findByKey($key, ['translations']);
            $this->translations[$key] = $translation?->translations[$this->langCode] ?? $key;

            return $this->translations[$key];
        }

        return $key;
    }

    public function getTransformedTranslations(): array
    {
        return Translation::all(['key', 'translations'])
            ->mapWithKeys(fn (Translation $translation) => [
                $translation->key => $translation->translations[$this->langCode] ?? $translation->key,
            ])
            ->toArray();
    }
}
