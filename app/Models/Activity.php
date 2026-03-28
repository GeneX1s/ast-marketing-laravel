<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'user', 'module', 'action', 'description', 'ip_address', 'result',
    ];
}
