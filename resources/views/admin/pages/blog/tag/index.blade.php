@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Tag</h2>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.taxonomy-tag.create') }}" class="btn btn-success">Create</a>
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
                        @foreach ($tags as $tag)
                            <tr>
                                <td><input type="checkbox" class="checkItem"></td>
                                <td>
                                    {{ $tag->name }}
                                </td>
                                <td>{{ $tag->slug }}</td>
                                <td>{!! Str::limit($tag->description, 30) !!}</td>
                                <td>{{ $tag->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin.taxonomy-tag.edit', $tag->id) }}"
                                        class="btn btn-warning">Edit</a>
                                    <form action="{{ route('admin.taxonomy-tag.destroy', $tag->id) }}" method="POST"
                                        style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this tag?')">Delete</button>
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
