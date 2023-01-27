<?php

namespace SaasReady\Tests\Feature\Controllers;

use Illuminate\Support\Facades\Event;
use SaasReady\Events\ReleaseNote\ReleaseNoteCreated;
use SaasReady\Events\ReleaseNote\ReleaseNoteDeleted;
use SaasReady\Events\ReleaseNote\ReleaseNoteUpdated;
use SaasReady\Models\ReleaseNote;
use SaasReady\Tests\TestCase;

class ReleaseNoteControllerTest extends TestCase
{
    public function testIndexEndpointReturnsPaginatedRecords()
    {
        $releaseNote = ReleaseNote::factory()->count(2)->sequence(
            [
                'version' => 'v1.0.1',
                'note' => 'Hotfix',
            ],
            [
                'version' => 'v1.0.0',
                'note' => 'Initial Release',
            ]
        )->create();

        $this->json('GET', 'saas/release-notes')
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $releaseNote[0]->uuid,
                'version' => 'v1.0.1',
                'note' => 'Hotfix',
            ])
            ->assertJsonFragment([
                'uuid' => $releaseNote[1]->uuid,
                'version' => 'v1.0.0',
                'note' => 'Initial Release',
            ]);
    }

    public function testShowEndpointReturnsNotFound()
    {
        $this->json('GET', 'saas/release-notes/' . $this->faker->uuid)
            ->assertNotFound();
    }

    public function testShowEndpointByUuid()
    {
        $releaseNote = ReleaseNote::factory()->create();

        $this->json('GET', 'saas/release-notes/' . $releaseNote->uuid)
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $releaseNote->uuid,
            ]);
    }

    public function testStoreEndpointCreateNewRecord()
    {
        Event::fake([
            ReleaseNoteCreated::class,
        ]);

        $this->json('POST', 'saas/release-notes/', [
            'version' => 'v1.2.3',
            'note' => 'hehe new version',
        ])->assertCreated();

        $this->assertDatabaseHas((new ReleaseNote())->getTable(), [
            'version' => 'v1.2.3',
            'note' => 'hehe new version',
        ]);

        Event::assertDispatched(
            ReleaseNoteCreated::class,
            fn (ReleaseNoteCreated $event) => $event->releaseNote->version === 'v1.2.3'
                && $event->releaseNote->note === 'hehe new version'
        );
    }

    public function testUpdateEndpointUpdatesTheRecord()
    {
        Event::fake([
            ReleaseNoteUpdated::class,
        ]);

        $releaseNote = ReleaseNote::factory()->create([
            'version' => 'v1.1.1',
            'note' => 'ready rocks',
        ]);

        $this->json('PUT', 'saas/release-notes/' . $releaseNote->uuid, [
            'version' => 'v1.1.2',
            'note' => 'ready awesome',
        ])->assertOk();

        $updatedReleaseNote = $releaseNote->fresh();

        $this->assertSame($releaseNote->id, $updatedReleaseNote->id);
        $this->assertNotSame($releaseNote->version, $updatedReleaseNote->version);
        $this->assertNotSame($releaseNote->note, $updatedReleaseNote->note);

        $this->assertDatabaseMissing($releaseNote->getTable(), [
            'version' => 'v1.1.1',
        ]);

        $this->assertDatabaseHas($releaseNote->getTable(), [
            'version' => 'v1.1.2',
            'note' => 'ready awesome',
        ]);

        Event::assertDispatched(
            ReleaseNoteUpdated::class,
            fn (ReleaseNoteUpdated $event) => $event->releaseNote->is($releaseNote)
                && $event->releaseNote->is($updatedReleaseNote)
        );
    }

    public function testDestroyEndpointDeletesTheRecord()
    {
        Event::fake([
            ReleaseNoteDeleted::class,
        ]);

        $releaseNote = ReleaseNote::factory()->create();

        $this->json('DELETE', 'saas/release-notes/' . $releaseNote->uuid)
            ->assertOk();

        $this->assertSoftDeleted($releaseNote->getTable(), [
            'id' => $releaseNote->id,
        ]);

        Event::assertDispatched(
            ReleaseNoteDeleted::class,
            fn (ReleaseNoteDeleted $event) => $event->releaseNote->is($releaseNote)
        );
    }
}
