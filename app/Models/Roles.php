<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'priority',
        'created_at',
        'updated_at',
    ];

    public function userRoles()
    {
        return $this->hasMany(UserRoles::class, 'role_id');
    }
}
