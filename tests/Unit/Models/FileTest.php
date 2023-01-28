<?php

namespace SaasReady\Tests\Unit\Models;

use SaasReady\Models\Currency;
use SaasReady\Models\File;
use SaasReady\Tests\TestCase;

class FileTest extends TestCase
{
    public function testFileMorphTo()
    {
        $currency = Currency::factory()->create();
        $file = File::factory()->create([
            'model_id' => $currency->id,
            'model_type' => $currency->getMorphClass(),
        ]);

        $relationInstance = $file->model()->first();

        $this->assertNotNull($relationInstance);
        $this->assertSame(
            $relationInstance->id,
            $currency->id
        );
        $this->assertInstanceOf(Currency::class, $relationInstance);
    }
}
