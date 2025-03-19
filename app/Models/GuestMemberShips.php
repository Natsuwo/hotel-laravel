<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestMemberShips extends Model
{
    use HasFactory;
    protected $table = 'guest_memberships';
    protected $fillable = [
        'name',
        'discount',
        'spending_required',
        'point_required',
    ];
}
