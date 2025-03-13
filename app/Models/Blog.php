<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $fillable = ['title', 'slug', 'content', 'user_id', 'gallery_id'];

    static function makeSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        return $slug;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }

    public function blogCategories()
    {
        return $this->hasMany(BlogCategory::class, 'blog_id');
    }

    public function blogTags()
    {
        return $this->hasMany(BlogTag::class, 'blog_id');
    }
}
