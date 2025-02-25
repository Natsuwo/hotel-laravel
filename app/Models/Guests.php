<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guests extends Model
{
    protected $table = 'guests';
    protected $fillable = [
        'uid',
        'name',
        'gender',
        'dob',
        'email',
        'phone',
        'address',
        'nationality',
        'passport',
        'avatar',
    ];

    static function generateUid()
    {
        do {
            $uid = 'G' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT) . '-' . rand(100000000, 999999999);
        } while (self::where('uid', $uid)->exists());

        return $uid;
    }

    public function guestMembership()
    {
        return $this->hasOne(self::class, 'id')
            ->join('guest_memberships', function ($join) {
                $join->on('guests.point', '>=', 'guest_memberships.point_required')
                    ->whereRaw('guest_memberships.point_required = (select max(point_required) from guest_memberships where guests.point >= point_required)');
            })
            ->first();
    }
}
