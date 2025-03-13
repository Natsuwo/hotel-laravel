<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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

    public function meta()
    {
        return $this->hasMany(UserMeta::class, 'user_id');
    }

    public function userRole()
    {
        return $this->hasOne(UserRoles::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'user_roles', 'user_id', 'role_id');
    }

    public function isAdmin()
    {
        return $this->roles()->where('priority', '>=', 100)->exists();
    }

    public function roleAccess($role)
    {
        $rolePriorities = [
            'admin' => 100,
            'manager' => 80,
            'concierge' => 50,
            'writer' => 25,
            'housekeeping' => 10,
        ];

        if (!isset($rolePriorities[$role])) {
            return false;
        }

        return $this->roles()->where('priority', '>=', $rolePriorities[$role])->exists();
    }
}
