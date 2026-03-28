<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'address',
        'role_id', 'has_2fa', 'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'has_2fa' => 'boolean',
            'status' => 'boolean',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class, 'pic_id');
    }

    public function kampanyes(): HasMany
    {
        return $this->hasMany(Kampanye::class, 'pic_id');
    }

    public function prospeks(): HasMany
    {
        return $this->hasMany(Prospek::class, 'pic_id');
    }

    public function prospekTimelines(): HasMany
    {
        return $this->hasMany(ProspekTimeline::class, 'pic_id');
    }

    public function pengajuans(): HasMany
    {
        return $this->hasMany(Pengajuan::class, 'pic_id');
    }

    /**
     * Check if user is Admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role?->name === 'Admin';
    }

    /**
     * Check if user has a specific page permission.
     */
    public function hasPermission(string $page): bool
    {
        if ($this->isAdmin()) return true;

        return $this->role?->permissionGroup?->permissions
            ->contains('page', $page) ?? false;
    }

    /**
     * Get all permission pages for this user.
     */
    public function getPermissionPages(): array
    {
        if ($this->isAdmin()) return ['*'];

        return $this->role?->permissionGroup?->permissions
            ->pluck('page')
            ->unique()
            ->values()
            ->toArray() ?? [];
    }
}
