<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = ['name', 'page', 'action'];

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(PermissionGroup::class, 'permission_group_permission');
    }
}
