<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guests extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'guests';
    protected $fillable = [
        'uid',
        'name',
        'gender',
        'dob',
        'email',
        'password',
        'phone',
        'address',
        'nationality',
        'passport',
        'avatar',
        'provider'
    ];
    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

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
            ->leftJoin('guest_memberships', function ($join) {
                $join->on('guests.point', '>=', 'guest_memberships.point_required')
                    ->whereRaw('guest_memberships.point_required = (select max(point_required) from guest_memberships where guests.point >= point_required)');
            })
            ->select('guest_memberships.*')
            ->first();
    }
}
