<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, \Spatie\Permission\Traits\HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user has a specific role via Spatie Permission
     * No hardcoded fallbacks — all roles must be assigned in the database
     */
    public function hasRole($roleName, $guard = null): bool
    {
        // Use Spatie's HasRoles trait method if tables exist
        if (\Illuminate\Support\Facades\Schema::hasTable('roles') && \Illuminate\Support\Facades\Schema::hasTable('model_has_roles')) {
            $role = \Illuminate\Support\Facades\DB::table('roles')->where('name', $roleName)->first();
            if ($role) {
                return \Illuminate\Support\Facades\DB::table('model_has_roles')
                    ->where('role_id', $role->id)
                    ->where('model_id', $this->id)
                    ->where('model_type', get_class($this))
                    ->exists();
            }
        }

        return false;
    }
}
