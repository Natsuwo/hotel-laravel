@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title
                ">Users
                <a href="{{ route('admin.user.create') }}" class="btn btn-primary float-right">Add User</a>

            </h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Verified</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            @php
                                $role = $user?->userRole?->role;
                            @endphp
                            <td>
                                @if ($role?->priority >= 100)
                                    <span class="badge badge-danger">{{ $role?->name }}</span>
                                @elseif ($role?->priority >= 80)
                                    <span class="badge badge-warning">{{ $role?->name }}</span>
                                @elseif ($role?->priority >= 50)
                                    <span class="badge badge-primary">{{ $role?->name }}</span>
                                @elseif ($role?->priority >= 25)
                                    <span class="badge badge-success">{{ $role?->name }}</span>
                                @else
                                    <span class="badge badge-info">{{ $role?->name }}</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->email_verified_at)
                                    <span class="badge badge-success">Verified</span>
                                @else
                                    <span class="badge badge-danger">Not Verified</span>
                                @endif
                            </td>
                            <td>{{ $user?->meta?->firstWhere('meta_key', 'phone')?->meta_value ?? 'N/A' }}</td>
                            <td>{{ $user?->meta?->firstWhere('meta_key', 'address')?->meta_value ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
