<?php

namespace App\Http\Controllers;

use App\Models\TaxonomiesTags as ModelsTaxonomiesTags;
use Illuminate\Http\Request;

class TaxonomiesTags extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 10;
        $tags = ModelsTaxonomiesTags::paginate($perPage);
        return view('admin.pages.blog.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.blog.tag.create');
    }

    public function slug(Request $request)
    {
        $slug = ModelsTaxonomiesTags::makeSlug($request->name);
        return response()->json(['slug' => $slug]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        ModelsTaxonomiesTags::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.taxonomy-tag.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tag = ModelsTaxonomiesTags::where('id', $id)
            ->orWhere('slug', $id)
            ->with('blogTags.blog.gallery')
            ->first();

        $tag->blogTags->each(function ($blogTag) {
            $blogTag->thumbnail = $blogTag->blog->gallery->thumbUrl();
            return $blogTag;
        });

        if (request()->is('api/*')) {
            return response()->json(['success' => true, 'data' => $tag]);
        }

        return view('admin.pages.blog.tag.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tag = ModelsTaxonomiesTags::findOrFail($id);
        return view('admin.pages.blog.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $tag = ModelsTaxonomiesTags::findOrFail($id);
        $tag->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.taxonomy-tag.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = ModelsTaxonomiesTags::findOrFail($id);
        $tag->delete();
        return redirect()->route('admin.taxonomy-tag.index');
    }

    public function searchOrCreate(Request $request)
    {
        $tag = ModelsTaxonomiesTags::where('name', $request->tag)->first();
        if ($tag) {
            return response()->json($tag);
        }
        $tag = ModelsTaxonomiesTags::create([
            'name' => $request->tag,
            'slug' => ModelsTaxonomiesTags::makeSlug($request->tag),
        ]);
        return response()->json($tag);
    }

    public function search(Request $request)
    {
        $tags = ModelsTaxonomiesTags::where('name', 'like', '%' . $request->input('query') . '%')->get();
        return response()->json($tags);
    }
}
