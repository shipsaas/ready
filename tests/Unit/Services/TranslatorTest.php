<?php

namespace SaasReady\Tests\Unit\Services;

use SaasReady\Contracts\TranslationRepositoryContract;
use SaasReady\Services\Translator;
use SaasReady\Tests\TestCase;

class TranslatorTest extends TestCase
{
    public function testTranslateTranslatesTheKey()
    {
        $repo = $this->createMock(TranslationRepositoryContract::class);
        $repo->method('getTranslation')
            ->with('welcome-text')
            ->willReturn('Hello {name}');

        $this->app->offsetSet(TranslationRepositoryContract::class, $repo);

        $translator = $this->app->make(Translator::class);

        $text = $translator->translate('welcome-text', ['name' => 'Seth Phat']);
        $text2 = saasTrans('welcome-text', ['name' => 'Seth Tran']);

        $this->assertSame('Hello Seth Phat', $text);
        $this->assertSame('Hello Seth Tran', $text2);
    }
}
