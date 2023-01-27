<?php

namespace SaasReady\Events\Country;

use Illuminate\Queue\SerializesModels;
use SaasReady\Models\Country;

class CountryDeleted
{
    use SerializesModels;

    public function __construct(public Country $country)
    {
    }
}
