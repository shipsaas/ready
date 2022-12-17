<?php

namespace SaasReady\Tests\Feature\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Event;
use SaasReady\Contracts\EventSourcingContract;
use SaasReady\Models\Country;
use SaasReady\Models\Event as EventModel;
use SaasReady\Tests\TestCase;

class EventControllerTest extends TestCase
{
    public function testIndexEndpointReturnsEventsOfASource()
    {
        $country = Country::factory()->create();
        Event::dispatch(new FakeEvent($country));
        Event::dispatch(new FakeEvent($country));

        $this->json('GET', 'saas/events', [
            'limit' => 10,
            'page' => 1,
            'source_type' => $country->getMorphClass(),
            'source_id' => $country->id,
            'load_related_model' => true,
        ])
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment([
                'name' => 'FakeEvent',
                'category' => 'fake.event',
                'properties' => [
                    'country_name' => $country->name,
                ],
            ])
            ->assertJsonFragment([
                'code' => $country->code,
            ]);
    }

    public function testIndexEndpointReturnsEventsOfASourceFilterByUserId()
    {
        $country = Country::factory()->create();

        // eg user 1 created this
        Event::dispatch(new FakeEvent($country, 1));

        // and user 2 updated this
        Event::dispatch(new FakeEvent($country, 2));

        $this->json('GET', 'saas/events', [
            'limit' => 10,
            'page' => 1,
            'source_type' => $country->getMorphClass(),
            'source_id' => $country->id,
            'load_related_model' => true,
            'user_id' => 1,
        ])
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'name' => 'FakeEvent',
                'category' => 'fake.event',
                'properties' => [
                    'country_name' => $country->name,
                ],
            ]);
    }

    public function testIndexEndpointReturnsValidationErrorOnWrongSourceType()
    {
        $this->json('GET', 'saas/events', [
            'limit' => 10,
            'page' => 1,
            'source_type' => 'lol',
            'source_id' => 1,
            'load_related_model' => true,
            'user_id' => 1,
        ])->assertJsonValidationErrorFor('source_type');
    }

    public function testIndexEndpointReturnsValidationErrorOnNonExistenceSource()
    {
        $this->json('GET', 'saas/events', [
            'limit' => 10,
            'page' => 1,
            'source_type' => Country::class,
            'source_id' => 99999,
            'load_related_model' => true,
            'user_id' => 1,
        ])->assertJsonValidationErrorFor('source_id');
    }

    public function testShowEndpointReturnsNotFound()
    {
        $this->json('GET', 'saas/events/' . $this->faker->uuid)
            ->assertNotFound();
    }

    public function testShowEndpointReturnsEventByUuid()
    {
        $country = Country::factory()->create();
        Event::dispatch(new FakeEvent($country));

        $event = EventModel::first();

        $this->json('GET', 'saas/events/' . $event->uuid, ['load_related_model' => true])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $event->uuid,
            ])
            ->assertJsonFragment([
                'code' => $country->code,
            ]);
    }
}

class FakeEvent implements EventSourcingContract
{
    public function __construct(public Country $country, public ?int $userId = null)
    {
    }

    public function getModel(): Model
    {
        return $this->country;
    }

    public function getUser(): ?Model
    {
        if (!$this->userId) {
            return null;
        }

        $user = new User();
        $user->id = $this->userId;

        return $user;
    }

    public function getCategory(): string
    {
        return 'fake.event';
    }

    public function getEventProperties(): array
    {
        return [
            'country_name' => $this->country->name,
        ];
    }
}
