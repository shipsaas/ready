<?php

namespace SaasReady\Events\Language;

use Illuminate\Queue\SerializesModels;
use SaasReady\Models\Language;

class LanguageUpdated
{
    use SerializesModels;

    public function __construct(public Language $language)
    {
    }
}
