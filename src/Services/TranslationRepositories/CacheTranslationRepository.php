<?php

namespace SaasReady\Services\TranslationRepositories;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use SaasReady\Contracts\TranslationRepositoryContract;

class CacheTranslationRepository implements TranslationRepositoryContract
{
    private const CACHE_KEY = 'saas-ready-cache-translations';

    private ?array $translations = null;

    public function __construct(private CacheRepository $cacheRepo)
    {
    }

    public function getTranslation(string $key): string
    {
        $this->translations ??= $this->cacheRepo->rememberForever(
            $this->getCacheKey(),
            $this->getTranslationsFromDatabase(...)
        );

        return $this->translations[$key] ?? $key;
    }

    private function getCacheKey(): string
    {
        return static::CACHE_KEY . '-' . app()->getLocale();
    }

    private function getTranslationsFromDatabase(): array
    {
        return app(DatabaseTranslationRepository::class)->getTransformedTranslations();
    }
}
