<?php

namespace SaasReady\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Language;

return new class () extends Migration {
    public function up(): void
    {
        $languages = array_map(function (LanguageCode $langCode) {
            return [
                'uuid' => Str::orderedUuid(),
                'code' => $langCode->value,
                'name' => $langCode->name,
                'activated_at' => $langCode === LanguageCode::ENGLISH
                    ? now()
                    : null,
            ];
        }, LanguageCode::cases());

        DB::insert((new Language())->getTable(), $languages);
    }

    public function down(): void
    {
        // 1 way
    }
};
