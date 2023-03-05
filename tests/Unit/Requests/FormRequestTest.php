<?php

namespace SaasReady\Tests\Unit\Requests;

use SaasReady\Auth\ReadyAuthorization;
use SaasReady\Http\Requests\Event\EventIndexRequest;
use SaasReady\Http\Requests\Event\EventShowRequest;
use SaasReady\Tests\TestCase;

class FormRequestTest extends TestCase
{
    public function testSetCustomAuthorization()
    {
        ReadyAuthorization::setCustomAuthorization(
            'events.index',
            fn () => false
        );
        ReadyAuthorization::setCustomAuthorization(
            'events.show',
            fn () => true
        );

        $requestA = new EventIndexRequest();
        $requestB = new EventShowRequest();

        $this->assertFalse($requestA->authorize());
        $this->assertTrue($requestB->authorize());
    }
}
