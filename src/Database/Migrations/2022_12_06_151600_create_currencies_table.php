<?php

namespace SaasReady\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid()->unique();

            $table->string('code')->unique();
            $table->string('name');
            $table->string('symbol');
            $table->unsignedInteger('decimals')->default(0);
            $table->char('decimal_separator');
            $table->char('thousands_separator');
            $table->boolean('space_after_symbol');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
