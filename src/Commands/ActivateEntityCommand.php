<?php

namespace SaasReady\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use SaasReady\Constants\CurrencyCode;
use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Currency;
use RuntimeException;
use BackedEnum;
use SaasReady\Models\Language;

class ActivateEntityCommand extends Command
{
    protected $signature = 'saas-ready:activate-entity {entity} {code}';
    protected $description = '[SaaS Ready] Activate an entity';

    public function handle(): int
    {
        $entity = $this->getEntity();

        if ($entity === null) {
            $this->error('Entity with the ' . $this->argument('code') . ' identifier does not exists');

            return 1;
        }

        $entity->update([
            'activated_at' => now(),
        ]);

        $this->info('Activated the entity ' . ($entity->code instanceof BackedEnum ? $entity->code->value : $entity->code));

        return 0;
    }

    public function getEntity(): ?Model
    {
        $code = $this->argument('code');

        return match ($this->argument('entity')) {
            'currency' => Currency::findByCode(CurrencyCode::tryFrom($code)),
            'language' => Language::findByCode(LanguageCode::tryFrom($code)),
            default => throw new RuntimeException('Unsupported entity'),
        };
    }
}
