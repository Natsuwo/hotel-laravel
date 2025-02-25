<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    const TABLE_NAME = 'features';
    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'name',
        'icon',
        'type'
    ];

    public function roomAmenities()
    {
        return $this->hasMany(RoomAmenities::class, 'feature_id');
    }

    public function roomFacilities()
    {
        return $this->hasMany(RoomFacilities::class, 'feature_id');
    }

    public function roomFeatures()
    {
        return $this->hasMany(RoomFeatures::class, 'feature_id');
    }
}
