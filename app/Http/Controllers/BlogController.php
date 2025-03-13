<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\TaxonomiesCategory;
use App\Models\TaxonomiesTags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = request()->get('limit', 10);
        $blogs = Blog::with('blogCategories.category', 'blogTags.tag')->paginate($limit);
        $blogs->getCollection()->transform(function ($blog) {
            $blog->thumbnail = $blog->gallery ? $blog->gallery->thumbUrl() : null;
            $blog->categories = $blog->blogCategories->map(function ($category) {
                return $category->category->name;
            });
            $blog->tags = $blog->blogTags->map(function ($tag) {
                return $tag->tag->name;
            });
            return $blog;
        });
        if (request()->is('api/*')) {
            return response()->json(['success' => true, 'data' => $blogs]);
        }
        return view('admin.pages.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = TaxonomiesCategory::all();
        return view('admin.pages.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
            'gallery_id' => 'nullable|integer',
        ]);
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('admin.blog.index')->with('error', 'User not found');
        }
        $userId = $user->id;
        $blog = Blog::create([
            'user_id' => $userId,
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'gallery_id' => $request->gallery_id,
        ]);

        if ($request->categories) {
            foreach ($request->categories as $category) {
                BlogCategory::create($blog->id, $category);
            }
        }
        if ($request->tags) {
            foreach ($request->tags as $tag) {
                BlogTag::create($blog->id, $tag);
            }
        }
        return redirect()->route('admin.blog.index');
    }

    public function slug(Request $request)
    {
        $slug = Blog::makeSlug($request->title);
        return response()->json(['slug' => $slug]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::with('blogCategories.category', 'blogTags.tag', 'gallery', 'user')
            ->where('id', $id)
            ->orWhere('slug', $id)
            ->first();
        $blog->categories = $blog->blogCategories->map(function ($category) {
            return [
                'id' => $category->category_id,
                'name' => $category->category->name,
                'slug' => $category->category->slug,
            ];
        });
        $blog->tags = $blog->blogTags->map(function ($tag) {
            return [
                'id' => $tag->tag_id,
                'name' => $tag->tag->name,
                'slug' => $tag->tag->slug,
            ];
        });
        $blog->thumbnail = $blog->gallery ? $blog->gallery->thumbUrl() : null;

        $categories = TaxonomiesCategory::withCount(['blogCategories' => function ($query) {
            $query->where('blog_id', '!=', null);
        }])->orderBy('blog_categories_count', 'desc')
            ->limit(5)
            ->get();

        $tags = TaxonomiesTags::withCount(['blogTags' => function ($query) use ($blog) {
            $query->where('blog_id', $blog->id);
        }])->orderBy('blog_tags_count', 'desc')
            ->limit(5)
            ->get();

        $relatedBlogs = Blog::where('id', '!=', $blog->id)
            ->whereHas('blogCategories', function ($query) use ($blog) {
                $query->whereIn('category_id', $blog->blogCategories->pluck('category_id')->toArray());
            })
            ->limit(5)
            ->get();

        if (request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $blog,
                'categories' => $categories,
                'tags' => $tags,
                'related' => $relatedBlogs,
            ]);
        }
        return view('admin.pages.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::with('blogCategories.category', 'blogTags.tag', 'gallery')->findOrFail($id);
        $categories = TaxonomiesCategory::all();
        $blog->categories = $blog->blogCategories->map(function ($category) {
            return $category->category_id;
        });
        $blog->tags = $blog->blogTags->map(function ($tag) {
            return [
                'id' => $tag->tag_id,
                'name' => $tag->tag->name,
            ];
        });
        return view('admin.pages.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
            'gallery_id' => 'nullable|integer',
        ]);
        $blog = Blog::findOrFail($id);
        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->content = $request->content;
        $blog->gallery_id = $request->gallery_id;
        $blog->save();

        $existingCategories = $blog->blogCategories->pluck('category_id')->toArray();
        $newCategories = $request->categories ?: [];
        foreach ($existingCategories as $categoryId) {
            if (!in_array($categoryId, $newCategories)) {
                BlogCategory::kill($id, $categoryId);
            }
        }
        BlogCategory::where('blog_id', $id)->delete();
        foreach ($newCategories as $category) {
            BlogCategory::create($id, $category);
        }

        $existingTags = $blog->blogTags->pluck('tag_id')->toArray();
        $newTags = $request->tags ?: [];
        foreach ($existingTags as $tagId) {
            if (!in_array($tagId, $newTags)) {
                BlogTag::kill($id, $tagId);
            }
        }
        BlogTag::where('blog_id', $id)->delete();
        foreach ($newTags as $tag) {
            BlogTag::create($id, $tag);
        }

        return redirect()->route('admin.blog.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
