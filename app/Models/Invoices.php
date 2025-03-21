<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $appends = ['discount_coupon', 'subamount'];
    protected $table = 'invoices';
    protected $fillable = [
        'guest_id',
        'room_id',
        'booking_id',
        'coupon_id',
        'price_per_night',
        'nights',
        'extras',
        'discount',
        'vat',
        'tax',
        'amount',
        'status',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservations::class, 'booking_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'invoice_id');
    }

    public function guest()
    {
        return $this->belongsTo(Guests::class, 'guest_id');
    }

    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupons::class, 'coupon_id');
    }

    static function createInvoice($data)
    {
        $invoice = self::create([
            'guest_id' => $data['guest_id'],
            'room_id' => $data['room_id'],
            'booking_id' => $data['booking_id'],
            'coupon_id' => $data['coupon_id'],
            'price_per_night' => $data['price_per_night'],
            'nights' => $data['nights'],
            'discount' => $data['discount'],
            'extras' => $data['extras'],
            'vat' => $data['vat'],
            'tax' => $data['tax'],
            'amount' => $data['amount'],
            'status' => $data['status'],
        ]);
        return $invoice;
    }

    static function calculateSubAmount(Invoices $invoice)
    {
        // subamount = (price_per_night * nights) + vax + tax + extras
        $subamount = ($invoice->price_per_night * $invoice->nights) + $invoice->vat + $invoice->tax + $invoice->extras;
        return $subamount;
    }

    public function getDiscountCouponAttribute()
    {
        $this->calulateCoupon();
        return $this->coupon_discount ?? 0;
    }

    public function getSubamountAttribute()
    {
        $this->calulateCoupon();
        return $this->attributes['subamount'] ?? $this->amount;
    }

    public function calulateCoupon()
    {
        $coupon = $this->coupon;
        $subamount = $this->calculateSubAmount($this);
        $this->attributes['subamount'] = $subamount;
        if ($coupon) {
            $this->attributes['coupon_discount'] = round($subamount - $this->amount, 2);
        } else {
            $this->attributes['coupon_discount'] = 0;
        }
        return $this;
    }
}
