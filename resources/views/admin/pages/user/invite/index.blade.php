@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title
                ">Invites
                <a href="{{ route('admin.user_invite.create') }}" class="btn btn-primary float-right">Add Invite</a>

            </h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Invite Code</th>
                        <th>Email</th>
                        <th>Used</th>
                        <th>Used At</th>
                        <th>Expired At</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invites as $invite)
                        <tr>
                            <td>{{ $invite->id }}</td>
                            <td>{{ $invite->invite_code }}</td>
                            <td>{{ $invite->email }}</td>
                            <td>{{ $invite->is_used == '1' ? 'Yes' : 'No' }}</td>
                            <td>{{ $invite->used_at ?? 'NaN' }}</td>
                            <td>{{ $invite->expired_at }}</td>
                            <td>{{ $invite->role->name }}</td>
                            <td>
                                <a href="{{ route('admin.user_invite.edit', $invite->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('admin.user_invite.destroy', $invite->id) }}" method="POST"
                                    style="display: inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this invite?');">
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
