<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    protected $table = 'coupons';
    protected $fillable = [
        'code',
        'discount',
        'usage_limit',
        'usage_count',
        'start_date',
        'end_date',
        'status',
    ];
}
