<?php

namespace SaasReady\Commands;

use BackedEnum;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;
use SaasReady\Constants\CurrencyCode;
use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Currency;
use SaasReady\Models\Language;

class DeactivateEntityCommand extends Command
{
    protected $signature = 'saas-ready:deactivate-entity {entity} {code}';
    protected $description = 'Deactivate an entity';

    public function handle(): int
    {
        $entity = $this->getEntity();

        if ($entity === null) {
            $this->error('Entity with the ' . $this->argument('code') . ' identifier does not exists');

            return 1;
        }

        $entity->update([
            'activated_at' => null,
        ]);

        $this->info('Deactivated the entity ' . ($entity->code instanceof BackedEnum ? $entity->code->value : $entity->code));

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
