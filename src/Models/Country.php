<?php

namespace SaasReady\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SaasReady\Traits\EloquentBuilderMixin;
use SaasReady\Traits\HasUuid;

/**
 * @mixin EloquentBuilderMixin
 */
class Country extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuid;

    protected $table = 'countries';

    protected $fillable = [
        'code',
        'iso3_code',
        'name',
    ];
}
