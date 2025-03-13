<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxonomiesCategory;

class TaxonomiesCategories extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 10;
        $categories = TaxonomiesCategory::paginate($perPage);
        return view('admin.pages.blog.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.blog.category.create');
    }

    public function slug(Request $request)
    {
        $slug = TaxonomiesCategory::makeSlug($request->name);
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

        TaxonomiesCategory::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.taxonomy-category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = TaxonomiesCategory::where('id', $id)
            ->orWhere('slug', $id)
            ->with('blogCategories.blog.gallery')
            ->first();

        $category->blogCategories->each(function ($blogCategory) {
            $blogCategory->thumbnail = $blogCategory->blog->gallery->thumbUrl();
            return $blogCategory;
        });

        if (request()->is('api/*')) {
            return response()->json(['success' => true, 'data' => $category]);
        }

        return view('admin.pages.blog.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = TaxonomiesCategory::findOrFail($id);
        return view('admin.pages.blog.category.edit', compact('category'));
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

        $category = TaxonomiesCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.taxonomy-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = TaxonomiesCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.taxonomy-category.index');
    }
}
