<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogTagController;
use App\Http\Controllers\TaxonomiesCategories;
use App\Http\Controllers\TaxonomiesTags;


Route::middleware('role:writer')->group(function () {
  Route::resource('blogs', BlogController::class)->names('admin.blog');
  Route::resource('blogs-category', BlogCategoryController::class)->names('admin.blog-category');
  Route::resource('blogs-tag', BlogTagController::class)->names('admin.blog-tag');
  Route::resource('taxonomies-tag', TaxonomiesTags::class)->names('admin.taxonomy-tag');
  Route::resource('taxonomies-category', TaxonomiesCategories::class)->names('admin.taxonomy-category');


  Route::post('taxonomy-category/slug', [TaxonomiesCategories::class, 'slug'])->name('admin.taxonomy-category.slug');
  Route::post('taxonomy-tag/slug', [TaxonomiesTags::class, 'slug'])->name('admin.taxonomy-tag.slug');
  Route::post('blog/slug', [BlogController::class, 'slug'])->name('admin.blog.slug');
  Route::post('taxonomy-tag/searchOrCreate', [TaxonomiesTags::class, 'searchOrCreate'])->name('admin.taxonomy-tag.searchOrCreate');
  Route::get('taxonomy-tag/search', [TaxonomiesTags::class, 'search'])->name('admin.taxonomy-tag.search');
});
