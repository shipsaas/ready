<?php

namespace SaasReady\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    protected $fillable = [
        'code',
        'iso3_code',
        'name',
    ];
}
