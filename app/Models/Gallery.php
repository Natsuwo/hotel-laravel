<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;
    const TABLE_NAME = 'galleries';
    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'title',
        'path',
        'size',
        'width',
        'height',
    ];

    public function roomGalleries()
    {
        return $this->hasMany(RoomGalleries::class, 'gallery_id');
    }

    public function thumbUrl()
    {
        return Storage::disk('r2')->temporaryUrl($this->path, now()->addMinutes(5));
    }
}
