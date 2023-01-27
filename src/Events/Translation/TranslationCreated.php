<?php

namespace SaasReady\Events\Translation;

use Illuminate\Queue\SerializesModels;
use SaasReady\Models\Translation;

class TranslationCreated
{
    use SerializesModels;

    public function __construct(public Translation $translation)
    {
    }
}
