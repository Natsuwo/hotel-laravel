@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Edit Blog</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $blog->title) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    value="{{ old('slug', $blog->slug) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="4">{{ old('content', $blog->content) }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-gallery-modal id="galleryModal"></x-gallery-modal>

                                <div class="form-group select-image">
                                    <label>Room Images</label>
                                    <div id="drop-area" class="drop-area"
                                        style="border: 2px dashed #ccc; padding: 20px; text-align: center;"
                                        onclick="$('#galleryModal').modal('show');">
                                        <p>Drag & Drop your files here or click to upload</p>
                                        <div id="input-area"></div>
                                        <div class="d-flex flex-wrap" id="image_preview_container">
                                            @if ($blog->gallery)
                                                <div class="p-2">
                                                    <img src="{{ $blog->gallery->thumbUrl() }}"
                                                        style="max-width: 100%; margin: 10px; display: block;">
                                                </div>
                                                <input type="hidden" class="form-control" name="gallery_id"
                                                    value="{{ $blog->gallery->id }}">
                                            @endif
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="categories">Categories</label>
                                <div id="categories" style="max-height: 200px; overflow-y: auto;">
                                    @foreach ($categories as $category)
                                        <div class="form-check">
                                            <label class="form-check-label" for="category_{{ $category->id }}">
                                                <input class="form-check-input" type="checkbox" name="categories[]"
                                                    {{ $blog->categories->contains($category->id) ? 'checked' : '' }}
                                                    id="category_{{ $category->id }}" value="{{ $category->id }}"
                                                    {{ in_array($category->id, old('categories', $blog->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <i class="input-helper"></i>
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <div id="tags" style="max-height: 200px; overflow-y: auto;">
                                    <input type="text" class="form-control" id="new_tag" placeholder="Add new tag">
                                    <div id="new_tags_container"></div>
                                    <div id="tag_suggestions"></div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('admin.blocks.froala_script')
@section('my-script')
    @include('admin.pages.blog.script')
@endsection
