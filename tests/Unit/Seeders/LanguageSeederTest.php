<?php

namespace SaasReady\Tests\Unit\Seeders;

use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Language;
use SaasReady\Tests\TestCase;

class LanguageSeederTest extends TestCase
{
    public function testSeederSeedsAllLanguages()
    {
        $this->travelTo('2022-10-23 10:00:00');

        $seeder = include __DIR__ . '/../../../src/Database/Migrations/2022_12_10_185600_seed_languages.php';
        $seeder->up();

        $this->assertDatabaseHas((new Language())->getTable(), [
            'code' => LanguageCode::VIETNAMESE,
            'name' => 'Vietnamese',
        ]);
        $this->assertDatabaseHas((new Language())->getTable(), [
            'code' => LanguageCode::ENGLISH,
            'name' => 'English',
            'activated_at' => '2022-10-23 10:00:00',
        ]);
        $this->assertDatabaseHas((new Language())->getTable(), [
            'code' => LanguageCode::ENGLISH_AUSTRALIA,
            'name' => 'English (Australia)',
        ]);
    }
}
