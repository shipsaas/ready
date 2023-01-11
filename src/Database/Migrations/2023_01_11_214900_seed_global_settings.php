<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        DB::table('dynamic_settings')
            ->insert([
                'uuid' => Str::orderedUuid()->toString(),
                'model_id' => null,
                'model_type' => null,
                'settings' => '[]',
            ]);
    }
};
