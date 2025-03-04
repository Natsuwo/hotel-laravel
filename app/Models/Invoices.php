<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $table = 'invoices';
    protected $fillable = [
        'guest_id',
        'room_id',
        'booking_id',
        'coupon_id',
        'price_per_night',
        'extras',
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
        return $this->belongsTo(Coupons::class, 'coupon_code', 'code');
    }

    static function createInvoice($data)
    {
        $invoice = self::create([
            'guest_id' => $data['guest_id'],
            'room_id' => $data['room_id'],
            'booking_id' => $data['booking_id'],
            'coupon_id' => $data['coupon_id'],
            'price_per_night' => $data['price_per_night'],
            'extras' => $data['extras'],
            'vat' => $data['vat'],
            'tax' => $data['tax'],
            'amount' => $data['amount'],
            'status' => $data['status'],
        ]);
        return $invoice;
    }
}
