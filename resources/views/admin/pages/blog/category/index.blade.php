@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Category</h2>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.taxonomy-category.create') }}" class="btn btn-success">Create</a>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td><input type="checkbox" class="checkItem"></td>
                                <td>
                                    {{ $category->name }}
                                </td>
                                <td>{{ $category->slug }}</td>
                                <td>{!! Str::limit($category->description, 30) !!}</td>
                                <td>{{ $category->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin.taxonomy-category.edit', $category->id) }}"
                                        class="btn btn-warning">Edit</a>
                                    <form action="{{ route('admin.taxonomy-category.destroy', $category->id) }}"
                                        method="POST" style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
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
