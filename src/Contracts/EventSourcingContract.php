<?php

namespace SaasReady\Contracts;

use Illuminate\Database\Eloquent\Model;

interface EventSourcingContract
{
    /**
     * Base model / source of the events
     *
     * @return Model
     */
    public function getModel(): Model;

    /**
     * [Optional] Related user of the current event
     *
     * @return Model|null
     */
    public function getUser(): ?Model;

    /**
     * Category's name of the Event
     *
     * @return string
     */
    public function getCategory(): string;

    /**
     * Properties of the event (will be stored)
     *
     * @return array
     */
    public function getEventProperties(): array;
}
