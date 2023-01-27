<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('release_notes', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('version');
            $table->text('note');

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
