<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestMemberShips extends Model
{
    protected $table = 'guest_memberships';
    protected $fillable = [
        'name',
        'discount',
        'spending_required',
        'point_required',
    ];
}
