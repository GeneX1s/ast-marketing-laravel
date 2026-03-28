<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = [
        'recruiter_name', 'referral_code', 'commission_value',
        'commission_type', 'participant', 'active_participant',
        'total_commission', 'status',
    ];
}
