<?php

namespace SaasReady\Events\Currency;

use Illuminate\Queue\SerializesModels;
use SaasReady\Models\Currency;

class CurrencyUpdated
{
    use SerializesModels;

    public function __construct(public Currency $currency)
    {
    }
}
