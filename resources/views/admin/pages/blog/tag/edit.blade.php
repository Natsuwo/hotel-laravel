@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Update Taxonomy Tag</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.taxonomy-tag.update', $tag->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $tag->name }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ $tag->slug }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4">{{ $tag->description }}</textarea>
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
    <script>
        new FroalaEditor('textarea#description', {
            height: 300
        })
    </script>
@endsection
