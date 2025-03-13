<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    protected $fillable = ['blog_id', 'tag_id'];
    protected $table = 'blog_tags';

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function tag()
    {
        return $this->belongsTo(TaxonomiesTags::class, 'tag_id');
    }

    static function create($blogId, $tagId)
    {
        $existing = BlogTag::where('blog_id', $blogId)
            ->where('tag_id', $tagId)
            ->first();

        if (!$existing) {
            $blogTag = new BlogTag();
            $blogTag->blog_id = $blogId;
            $blogTag->tag_id = $tagId;
            $blogTag->save();
        }
    }

    static function kill($blogId, $tagId)
    {
        $existing = BlogTag::where('blog_id', $blogId)
            ->where('tag_id', $tagId)
            ->first();

        if ($existing) {
            $existing->delete();
        }
    }
}
