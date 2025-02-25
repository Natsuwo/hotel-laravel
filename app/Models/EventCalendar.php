<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCalendar extends Model
{
    protected $table = 'event_calendar';
    protected $fillable = [
        'title',
        'start',
        'end',
        'color',
    ];

    public $timestamps = false;
}
