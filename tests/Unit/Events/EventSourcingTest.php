<?php

namespace SaasReady\Tests\Unit\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use SaasReady\Contracts\EventSourcingContract;
use SaasReady\Models\Event as EventModel;
use SaasReady\Models\Language;
use SaasReady\Tests\TestCase;

class EventSourcingTest extends TestCase
{
    public function testDispatchEventWillInsertANewEventRecord()
    {
        $language = Language::factory()->create();
        $event = new LanguageCreated($language);

        Event::dispatch($event);

        $this->assertDatabaseHas((new EventModel())->getTable(), [
            'model_id' => $language->getKey(),
            'model_type' => $language->getMorphClass(),
            'user_id' => null,
            'category' => $event->getCategory(),
            'properties->code' => $language->code,
            'properties->name' => $language->name,
        ]);
    }
}

class LanguageCreated implements EventSourcingContract
{
    public function __construct(public Language $language)
    {
    }

    public function getModel(): Model
    {
        return $this->language;
    }

    public function getUser(): ?Model
    {
        return null;
    }

    public function getCategory(): string
    {
        return 'crud.language.created';
    }

    public function getEventProperties(): array
    {
        return [
            'code' => $this->language->code,
            'name' => $this->language->name,
        ];
    }
}
