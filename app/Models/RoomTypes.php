<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomTypes extends Model
{
    protected $table = 'room_types';
    // protected $guarded = [];
    protected $fillable = [
        'title',
        'slug',
        'description',
        'bed_type',
        'bed_count',
        'acreage',
        'guest_count',
        'price_per_night',
        'price_per_hour',
        'discount',
    ];
    // public $timestamps = false;

    public function room()
    {
        return $this->hasMany(Rooms::class, 'room_type_id');
    }

    public function amenities()
    {
        return $this->hasMany(RoomAmenities::class, 'room_type_id');
    }

    public function facilities()
    {
        return $this->hasMany(RoomFacilities::class, 'room_type_id');
    }

    public function features()
    {
        return $this->hasMany(RoomFeatures::class, 'room_type_id');
    }

    public function galleries()
    {
        return $this->hasMany(RoomGalleries::class, 'room_type_id');
    }
}
