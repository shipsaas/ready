<?php

namespace SaasReady\Tests\Unit\Services\FileManager;

use Illuminate\Http\UploadedFile;
use RuntimeException;
use SaasReady\Services\FileManager\UploadOption;
use SaasReady\Tests\TestCase;

class UploadOptionTest extends TestCase
{
    public function testCreateInstanceFromPath()
    {
        $fakePath = tempnam('/tmp', 'test');

        $instance = UploadOption::prepareFromPath($fakePath);

        $this->assertNotNull($instance);
        $this->assertNotNull($instance->file);
    }

    public function testCreateInstanceFromPathFileNotFound()
    {
        $this->expectException(RuntimeException::class);

        $instance = UploadOption::prepareFromPath('sfjkasdhfjkhdsfkja');
    }

    public function testCreateInstanceFromUploadedFile()
    {
        $uploadedFile = UploadedFile::fake()->create('test');

        $instance = UploadOption::prepareFromUploadedFile($uploadedFile);

        $this->assertNotNull($instance);
        $this->assertNotNull($instance->file);
    }
}
