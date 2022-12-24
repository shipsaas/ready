<?php

namespace SaasReady\Tests\Unit\Models;

use SaasReady\Models\Translation;
use SaasReady\Tests\TestCase;

class TranslationTest extends TestCase
{
    public function testFindByUuid()
    {
        $translation = Translation::factory()->create();

        $foundTranslation = Translation::findByUuid($translation->uuid);

        $this->assertNotNull($translation);
        $this->assertTrue($foundTranslation->is($translation));

        $nullTranslation = Translation::findByUuid($this->faker->uuid());
        $this->assertNull($nullTranslation);
    }

    public function testFindByKey()
    {
        $translation = Translation::factory()->create([
            'key' => 'seth.phat',
        ]);

        $foundTranslation = Translation::findByKey('seth.phat');

        $this->assertNotNull($foundTranslation);
        $this->assertTrue($foundTranslation->is($translation));

        $nullTranslation = Translation::findByKey($this->faker->uuid());
        $this->assertNull($nullTranslation);
    }
}
