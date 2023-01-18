<?php

namespace SaasReady\Commands;

use Illuminate\Console\Command;
use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Language;
use SaasReady\Models\Translation;

class RenderTranslationsCommand extends Command
{
    protected $signature = 'saas-ready:render-translation {langCode}';
    protected $description = '[SaaS Ready] Render translation file for a specific Language';

    public function handle(): void
    {
        $langCode = $this->argument('langCode');
        $language = Language::findByCode(LanguageCode::tryFrom($langCode));

        if (!$language || !$language->activated_at) {
            $this->error('Language not found or not activated');

            return;
        }

        // key => text
        $translatedTexts = Translation::all(['key', 'translations'])
            ->mapWithKeys(function (Translation $translation) use ($langCode) {
                return [
                    $translation->key => $translation->translations[$langCode] ?? '',
                ];
            });

        $langFilePath = lang_path("$langCode.json");

        // write
        file_put_contents($langFilePath, $translatedTexts);

        $this->info("All translations of $langCode is exported successfully.");
        $this->info('Path: ' . $langFilePath);
    }
}
