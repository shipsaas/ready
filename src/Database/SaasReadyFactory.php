<?php

namespace SaasReady\Database;

trait SaasReadyFactory
{
    protected static function newFactory()
    {
        $factoryClassName = class_basename(get_called_class());

        return ("SaasReady\\Database\\Factories\\{$factoryClassName}Factory")::new();
    }
}
