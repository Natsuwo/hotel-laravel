<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floors extends Model
{
    protected $table = 'floors';
    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
    ];

    public function rooms()
    {
        return $this->hasMany(Rooms::class, 'floor_id');
    }
}
