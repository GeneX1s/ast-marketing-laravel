<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kampanye extends Model
{
    protected $fillable = [
        'pic_id', 'name', 'channel', 'type', 'schedule',
        'status', 'content_url', 'notes',
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
