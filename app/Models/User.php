<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // Define role constants
    public const ROLE_SUPER_ADMIN = 'super_admin';
    // Reserved roles for future implementation
    // public const ROLE_ADMIN = 'admin';
    // public const ROLE_STAFF = 'staff';
    // public const ROLE_USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Check if user is super admin
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Get all available roles
     *
     * @return array
     */
    public static function getAvailableRoles(): array
    {
        return [
            self::ROLE_SUPER_ADMIN,
            // Reserved for future implementation
            // self::ROLE_ADMIN,
            // self::ROLE_STAFF,
            // self::ROLE_USER,
        ];
    }
}