<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TaxonomiesCategory extends Model
{
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

    public function blogCategories()
    {
        return $this->hasMany(BlogCategory::class, 'category_id');
    }
}
