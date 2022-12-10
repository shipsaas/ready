<?php

namespace SaasReady\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid()->unique();
            $table->string('code', 2)->unique();
            $table->string('alpha3_code', 3)->unique();

            $table->string('continent', 50);
            $table->string('name', 100);
            $table->string('dial_code', 10);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
