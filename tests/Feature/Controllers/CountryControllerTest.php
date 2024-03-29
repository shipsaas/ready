<?php

namespace SaasReady\Tests\Feature\Controllers;

use Illuminate\Support\Facades\Event;
use SaasReady\Constants\CountryCode;
use SaasReady\Events\Country\CountryCreated;
use SaasReady\Events\Country\CountryDeleted;
use SaasReady\Events\Country\CountryUpdated;
use SaasReady\Models\Country;
use SaasReady\Tests\TestCase;

class CountryControllerTest extends TestCase
{
    public function testIndexEndpointReturnsAllCountries()
    {
        $countries = Country::factory()->count(2)->sequence(
            [
                'code' => CountryCode::SINGAPORE,
                'name' => 'Singapore',
            ],
            [
                'code' => CountryCode::VIETNAM,
                'name' => 'Vietnam',
            ]
        )->create();

        $this->json('GET', 'saas/countries')
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $countries[0]->uuid,
            ])
            ->assertJsonFragment([
                'uuid' => $countries[1]->uuid,
            ]);
    }

    public function testIndexEndpointReturnsPaginatedCountries()
    {
        $countries = Country::factory()->count(2)->sequence(
            [
                'code' => CountryCode::SINGAPORE,
                'name' => 'Singapore',
            ],
            [
                'code' => CountryCode::VIETNAM,
                'name' => 'Vietnam',
            ]
        )->create();

        $this->json('GET', 'saas/countries', [
            'type' => 'paginated',
            'limit' => 1,
            'page' => 1,
        ])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $countries[0]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $countries[1]->uuid,
            ]);

        $this->json('GET', 'saas/countries', [
            'type' => 'paginated',
            'limit' => 1,
            'page' => 2,
        ])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $countries[1]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $countries[0]->uuid,
            ]);
    }

    public function testShowEndpointReturnsNotFound()
    {
        $this->json('GET', 'saas/countries/' . $this->faker->uuid)
            ->assertNotFound();
    }

    public function testShowEndpointCountryByUuid()
    {
        $country = Country::factory()->create();

        $this->json('GET', 'saas/countries/' . $country->uuid)
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $country->uuid,
            ]);
    }

    public function testStoreEndpointCreateNewRecord()
    {
        Event::fake([CountryCreated::class]);

        $this->json('POST', 'saas/countries/', [
            'code' => CountryCode::UNITED_STATES->value,
            'name' => 'United States',
            'dial_code' => '+1',
            'continent' => 'North America',
        ])->assertCreated();

        $this->assertDatabaseHas((new Country())->getTable(), [
            'code' => CountryCode::UNITED_STATES->value,
            'name' => 'United States',
            'dial_code' => '+1',
            'continent' => 'North America',
        ]);

        Event::assertDispatched(
            CountryCreated::class,
            fn (CountryCreated $event) => $event->country->code === CountryCode::UNITED_STATES
        );
    }

    public function testUpdateEndpointUpdatesTheRecord()
    {
        Event::fake([CountryUpdated::class]);

        $country = Country::factory()->create([
            'code' => CountryCode::UNITED_STATES,
        ]);

        $this->json('PUT', 'saas/countries/' . $country->uuid, [
            'code' => CountryCode::VIETNAM->value,
            'name' => 'Vietnam',
            'dial_code' => '+84',
            'continent' => 'SEA',
        ])
            ->assertOk();

        $updatedCountry = $country->fresh();

        $this->assertSame($country->id, $updatedCountry->id);
        $this->assertNotSame($country->code, $updatedCountry->code);
        $this->assertNotSame($country->name, $updatedCountry->name);

        $this->assertDatabaseMissing((new Country())->getTable(), [
            'code' => CountryCode::UNITED_STATES->value,
        ]);

        $this->assertDatabaseHas((new Country())->getTable(), [
            'code' => CountryCode::VIETNAM->value,
            'name' => 'Vietnam',
            'dial_code' => '+84',
            'continent' => 'SEA',
        ]);

        Event::assertDispatched(
            CountryUpdated::class,
            fn (CountryUpdated $event) => $event->country->code === CountryCode::VIETNAM
                && $event->country->is($updatedCountry)
        );
    }

    public function testDestroyEndpointDeletesTheRecord()
    {
        Event::fake([CountryDeleted::class]);

        $country = Country::factory()->create();

        $this->json('DELETE', 'saas/countries/' . $country->uuid)
            ->assertOk();

        $this->assertSoftDeleted($country->getTable(), [
            'id' => $country->id,
        ]);

        Event::assertDispatched(
            CountryDeleted::class,
            fn (CountryDeleted $event) => $event->country->is($country)
        );
    }
}
