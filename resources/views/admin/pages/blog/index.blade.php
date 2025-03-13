@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Blog</h2>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-success">Create</a>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Tag</th>
                            <th>Content</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $blog)
                            <tr>
                                <td><input type="checkbox" class="checkItem"></td>
                                <td>
                                    {{ $blog->title }}
                                </td>
                                <td>
                                    <img src="{{ $blog->thumbnail }}" alt="{{ $blog->title }}" width="100"
                                        style="border-radius: 0px; min-width: 100px; height: auto;">
                                </td>
                                <td>
                                    @foreach ($blog->categories as $category)
                                        <span class="badge badge-success">{{ $category }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($blog->tags as $tag)
                                        <span class="badge badge-primary">{{ $tag }}</span>
                                    @endforeach
                                </td>
                                <td>{!! Str::limit($blog->content, 30) !!}</td>
                                <td>{{ $blog->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('admin.blog.destroy', $blog->id) }}" method="POST"
                                        style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this blog?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
