<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prospek extends Model
{
    protected $fillable = [
        'pic_id', 'timeline_id', 'business_id', 'name', 'phone_number',
        'business_name', 'address', 'status', 'schedule', 'notes',
    ];

    protected function casts(): array
    {
        return ['schedule' => 'datetime'];
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
}
