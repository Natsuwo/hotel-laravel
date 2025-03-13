@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title
                ">User Roles
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary float-right">Add Roles</a>

            </h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Role Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->description }}</td>
                            <td>
                                @if ($role->is_active == 1)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $role->priority }}</td>
                            <td>
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-info">Edit</a>
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this role?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
