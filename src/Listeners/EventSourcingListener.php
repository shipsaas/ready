<?php

namespace SaasReady\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SaasReady\Contracts\EventSourcingContract;

class EventSourcingListener implements ShouldQueue
{
    use Dispatchable;
    use Queueable;
    use SerializesModels;
    use InteractsWithQueue;

    public function __construct(public EventSourcingContract $event)
    {
    }

    public function handle(): void
    {

    }
}
