<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\TaxonomiesCategories;
use App\Http\Controllers\TaxonomiesTags;
use Illuminate\Support\Facades\Route;


Route::get('blog/index', [BlogController::class, 'index'])
  ->name('api.blog.index');

Route::get('blog/show/{id}', [BlogController::class, 'show'])
  ->name('api.blog.show');

Route::get('/blog/tag/{id}', [TaxonomiesTags::class, 'show'])
  ->name('api.blog.tag.show');

Route::get('/blog/category/{id}', [TaxonomiesCategories::class, 'show'])
  ->name('api.blog.category.show');
