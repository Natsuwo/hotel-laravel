<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'invoice_id',
        'transaction_id',
        'amount',
        'status',
        'payment_method',
        'paid_at',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'invoice_id');
    }

    public function plusPoint($amount)
    {
        $guestId = $this->invoice->guest_id;
        $guest = Guests::find($guestId);
        $guest->point += $amount;
        $guest->save();
    }
}
