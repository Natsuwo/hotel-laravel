<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{

    protected $table = 'user_roles';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'role_id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id', 'id');
    }
}
