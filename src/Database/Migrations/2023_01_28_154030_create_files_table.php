<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->nullableMorphs('model');

            $table->string('category')->nullable();
            $table->string('filename');
            $table->string('path');
            $table->string('original_filename');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->string('source')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'id',
                'deleted_at',
            ], 'idx_files_find_by_id');

            $table->index([
                'uuid',
                'deleted_at',
            ], 'idx_files_find_by_uuid');

            // normal search
            $table->index([
                'model_id',
                'model_type',
                'deleted_at',
            ], 'idx_files_normal_search');

            $table->index([
                'model_id',
                'model_type',
                'category',
                'deleted_at',
            ], 'idx_files_category_search');
        });
    }
};
