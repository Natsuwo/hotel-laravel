<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TaxonomiesTags extends Model
{
    protected $table = 'taxonomies_tags';
    protected $fillable = ['name', 'slug', 'description'];
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

    public function blogTags()
    {
        return $this->hasMany(BlogTag::class, 'tag_id');
    }
}
