<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInvite extends Model
{
    public string $invite_link;
    protected $table = 'user_invite';
    protected $fillable = [
        'invite_code',
        'email',
        'is_used',
        'used_at',
        'expired_at',
        'role_id',
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    static function generateInviteCode()
    {
        do {
            $inviteCode = md5(uniqid(rand(), true));
        } while (self::where('invite_code', $inviteCode)->exists());

        return $inviteCode;
    }

    static function checkInviteCode($inviteCode)
    {
        $invite = self::where('invite_code', $inviteCode)->first();

        if (!$invite) {
            throw new \Exception('Invite code does not exist.');
        }

        if ($invite->is_used) {
            throw new \Exception('Invite code has already been used.');
        }

        if ($invite->expired_at && $invite->expired_at < now()) {
            throw new \Exception('Invite code has expired.');
        }

        return $invite;
    }
}
