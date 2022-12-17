<?php

namespace SaasReady\Tests\Unit\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use SaasReady\Contracts\EventSourcingContract;
use SaasReady\Listeners\EventSourcingListener;
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

        $insertedEvent = EventModel::where([
            'model_id' => $language->getKey(),
            'model_type' => $language->getMorphClass(),
        ])->first();

        $this->assertTrue($insertedEvent->model()->first()->is($language));
    }

    public function testDispatchEventsWillDispatchAQueueToRecordTheEvent()
    {
        Queue::fake([
            EventSourcingListener::class,
        ]);

        config([
            'saas-ready.event-sourcing.should-queue' => true,
            'saas-ready.event-sourcing.queue-name' => 'low-priority',
            'saas-ready.event-sourcing.queue-connection' => 'redis',
        ]);

        $language = Language::factory()->create();
        $event = new LanguageCreated($language);

        Event::dispatch($event);

        Queue::assertPushedOn(
            'low-priority',
            EventSourcingListener::class,
            fn (EventSourcingListener $job) => $job->event->getModel()->is($language)
                && $job->connection === 'redis'
        );
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
