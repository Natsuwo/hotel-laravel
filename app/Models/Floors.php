<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floors extends Model
{
    use HasFactory;
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
