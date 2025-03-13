<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    protected $table = 'coupons';
    protected $fillable = [
        'code',
        'discount',
        'discount_type',
        'usage_per_user',
        'usage_limit_per_coupon',
        'usage_limit',
        'usage_count',
        'start_date',
        'end_date',
        'status',
    ];

    public function couponItems()
    {
        return $this->hasMany(CouponItems::class, 'coupon_id');
    }

    public function createCouponItem($guest_id, $invoice_id)
    {
        $usage_per_user = $this->usage_per_user;
        $totalUserUsage = $this->couponItems()
            ->where('guest_id', $guest_id)
            ->where('coupon_id', $this->id)
            ->count();

        if ($usage_per_user > 0 && $totalUserUsage >= $usage_per_user) {
            throw new \Exception('You have reached the maximum usage limit for this coupon');
        }

        if ($this->usage_limit > 0 && $this->usage_count >= $this->usage_limit) {
            throw new \Exception('This coupon has reached its maximum usage limit');
        }

        if ($this->start_date && $this->start_date > now()) {
            throw new \Exception('This coupon is not yet valid');
        }

        if ($this->end_date && $this->end_date < now()) {
            throw new \Exception('This coupon has expired');
        }

        $this->usage_count++;
        $this->save();
        return CouponItems::create([
            'coupon_id' => $this->id,
            'guest_id' => $guest_id,
            'invoice_id' => $invoice_id,
            'discount' => $this->discount,
            'discount_type' => $this->discount_type,
            'used_at' => now(),
        ]);
    }
}
