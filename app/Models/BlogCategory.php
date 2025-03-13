<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $fillable = ['blog_id', 'category_id'];
    protected $table = 'blog_categories';

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function category()
    {
        return $this->belongsTo(TaxonomiesCategory::class, 'category_id');
    }

    static function create($blogId, $categoryId)
    {
        $existing = BlogCategory::where('blog_id', $blogId)
            ->where('category_id', $categoryId)
            ->first();

        if (!$existing) {
            $blogCategory = new BlogCategory();
            $blogCategory->blog_id = $blogId;
            $blogCategory->category_id = $categoryId;
            $blogCategory->save();
        }
    }

    static function kill($blogId, $categoryId)
    {
        $existing = BlogCategory::where('blog_id', $blogId)
            ->where('category_id', $categoryId)
            ->first();

        if ($existing) {
            $existing->delete();
        }
    }
}
