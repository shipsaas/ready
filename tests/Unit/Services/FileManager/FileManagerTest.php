<?php

namespace SaasReady\Tests\Unit\Services\FileManager;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use SaasReady\Models\Country;
use SaasReady\Models\File;
use SaasReady\Services\FileManager\FileManager;
use SaasReady\Services\FileManager\UploadOption;
use SaasReady\Tests\TestCase;
use RuntimeException;

class FileManagerTest extends TestCase
{
    protected FileManager $fileManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fileManager = new FileManager();
    }

    public function testUpload()
    {
        $uploadedFile = UploadedFile::fake()->create('seth.txt', 5, 'text/plain');
        $uploadOption = UploadOption::prepareFromUploadedFile($uploadedFile);
        $uploadOption->storePath = 'my-info/';
        $uploadOption->category = 'my-info';
        $uploadOption->newFileName = 'seth-tran.txt';
        $uploadOption->source = Country::factory()->create();

        $file = $this->fileManager->upload($uploadOption);

        $this->assertNotNull($file);
        $this->assertDatabaseHas('files', [
            'model_id' => $uploadOption->source->id,
            'model_type' => $uploadOption->source->getMorphClass(),
            'filename' => 'seth-tran.txt',
            'original_filename' => 'seth.txt',
            'mime_type' => 'text/plain',
            'size' => 5 * 1024,
            'source' => 'local',
        ]);
        $this->assertTrue(Storage::exists($file->path));
    }

    public function testUploadFailed()
    {
        $uploadedFile = UploadedFile::fake()->create('seth.txt', 5, 'text/plain');
        $uploadOption = UploadOption::prepareFromUploadedFile($uploadedFile);
        $uploadOption->storePath = 'my-info/';
        $uploadOption->category = 'my-info';
        $uploadOption->newFileName = 'seth-tran.txt';
        $uploadOption->source = Country::factory()->create();

        Storage::expects('getDefaultDriver')
            ->once()
            ->andReturn('local');
        Storage::expects('disk')
            ->once()
            ->andReturnSelf();
        Storage::expects('putFileAs')
            ->once()
            ->andReturn(false);

        $file = $this->fileManager->upload($uploadOption);

        $this->assertNull($file);
        $this->assertDatabaseEmpty('files');
    }

    public function testGetUrl()
    {
        config([
            'filesystems.disks.local.url' => 'https://sethphat.com/',
        ]);

        $uploadedFile = UploadedFile::fake()->create('seth.txt', 5, 'text/plain');
        $uploadOption = UploadOption::prepareFromUploadedFile($uploadedFile);
        $uploadOption->newFileName = 'seth-tran.txt';
        $uploadOption->driver = 'local';
        $file = $this->fileManager->upload($uploadOption);

        $url = $this->fileManager->getUrl($file);

        $this->assertNotNull($url);
        $this->assertSame('https://sethphat.com/files/seth-tran.txt', $url);
    }

    public function testGetUrlFailed()
    {
        $file = File::factory()->create();

        $url = $this->fileManager->getUrl($file);

        $this->assertNull($url);
    }

    public function testGetTemporaryUrl()
    {
        config([
            'filesystems.disks.local.url' => 'https://sethphat.com/',
        ]);

        $uploadedFile = UploadedFile::fake()->create('seth.txt', 5, 'text/plain');
        $uploadOption = UploadOption::prepareFromUploadedFile($uploadedFile);
        $uploadOption->newFileName = 'seth-tran.txt';
        $uploadOption->driver = 'local';
        $file = $this->fileManager->upload($uploadOption);

        Storage::expects('disk')->andReturnSelf();
        Storage::expects('exists')->andReturn(true);
        Storage::expects('temporaryUrl')->andReturn('https://s3.aws.com/temp/seth-tran.txt');
        $url = $this->fileManager->getTemporaryUrl($file, now()->addDay());

        $this->assertNotNull($url);
        $this->assertSame('https://s3.aws.com/temp/seth-tran.txt', $url);
    }

    public function testGetTemporaryUrlFailedDueToDriverNotSupport()
    {
        $this->expectException(RuntimeException::class);

        $uploadedFile = UploadedFile::fake()->create('seth.txt', 5, 'text/plain');
        $uploadOption = UploadOption::prepareFromUploadedFile($uploadedFile);
        $uploadOption->newFileName = 'seth-tran.txt';
        $uploadOption->driver = 'local';
        $file = $this->fileManager->upload($uploadOption);

        $url = $this->fileManager->getTemporaryUrl($file, now()->addDay());
    }
}
