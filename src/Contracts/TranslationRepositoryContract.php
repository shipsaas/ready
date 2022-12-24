<?php

namespace SaasReady\Contracts;

interface TranslationRepositoryContract
{
    /**
     * Contractor must retrieve the translation normally
     *
     * @param string $key
     *
     * @return string
     */
    public function getTranslation(string $key): string;
}
