<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('dynamic_settings', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->morphs('model');
            $table->json('settings')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
