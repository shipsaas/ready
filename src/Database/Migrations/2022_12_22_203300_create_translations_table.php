<?php

namespace SaasReady\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('key')->index();
            $table->string('label');
            $table->json('translations')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['key', 'deleted_at']);
            $table->unique(['uuid', 'deleted_at']);
            $table->index(['id', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
