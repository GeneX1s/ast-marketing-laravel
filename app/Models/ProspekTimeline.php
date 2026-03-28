<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProspekTimeline extends Model
{
    protected $fillable = ['prospek_id', 'pic_id', 'message', 'schedule'];

    protected function casts(): array
    {
        return ['schedule' => 'datetime'];
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
}
