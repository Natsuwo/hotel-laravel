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
}
