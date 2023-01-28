<?php

namespace SaasReady\Tests\Unit\Traits;

use SaasReady\Models\Currency;
use SaasReady\Models\File;
use SaasReady\Tests\TestCase;
use SaasReady\Traits\HasFiles;

class HasFilesTest extends TestCase
{
    public function testHasFilesHasMultipleFiles()
    {
        /** @var CurrencyHasFile $currency */
        $fakeCurrency = Currency::factory()->create();
        $files = File::factory()->count(2)
            ->create([
                'model_id' => $fakeCurrency->id,
                'model_type' => $fakeCurrency->getMorphClass(),
            ]);

        $currency = CurrencyHasFile::find($fakeCurrency->id);
        $this->assertTrue($currency->files->isNotEmpty());
        $this->assertTrue($currency->files->where('uuid', $files[0]->uuid)->isNotEmpty());
        $this->assertTrue($currency->files->where('uuid', $files[1]->uuid)->isNotEmpty());
    }

    public function testHasFilesHasLatestFile()
    {
        /** @var CurrencyHasFile $currency */
        $fakeCurrency = Currency::factory()->create();

        $this->travelTo('2023-01-28 17:50:00');
        $firstFile = File::factory()
            ->create([
                'model_id' => $fakeCurrency->id,
                'model_type' => $fakeCurrency->getMorphClass(),
            ]);

        $this->travelTo('2023-01-28 17:55:00');
        $secondFile = File::factory()
            ->create([
                'model_id' => $fakeCurrency->id,
                'model_type' => $fakeCurrency->getMorphClass(),
            ]);

        $currency = CurrencyHasFile::find($fakeCurrency->id);
        $this->assertNotNull($currency->latestFile);
        $this->assertTrue($currency->latestFile->is($secondFile));
    }

    public function testHasFilesDoesntHavesLatestFile()
    {
        /** @var CurrencyHasFile $currency */
        $fakeCurrency = Currency::factory()->create();

        $currency = CurrencyHasFile::find($fakeCurrency->id);
        $this->assertNull($currency->latestFile);
    }
}

class CurrencyHasFile extends Currency
{
    use HasFiles;

    public function getMorphClass()
    {
        return Currency::class;
    }
}
