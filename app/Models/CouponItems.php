<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponItems extends Model
{
    protected $table = 'coupon_item';
    protected $fillable = [
        'coupon_id',
        'guest_id',
        'invoice_id',
        'discount',
        'discount_type',
        'used_at'
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupons::class, 'coupon_id');
    }

    public function guest()
    {
        return $this->belongsTo(Guests::class, 'guest_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'invoice_id');
    }
}
