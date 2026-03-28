<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    protected $fillable = ['business_id', 'amount', 'description', 'status'];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
