@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Update Invite</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.user_invite.update', $invite->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="invite_code">Invite Code</label>
                        <input type="text" class="form-control" id="invite_code" name="invite_code"
                            value="{{ $invite->invite_code }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $invite->email }}" required>
                    </div>

                    <div class="form-group">
                        <label for="expired_at">Expires</label>
                        <input type="datetime-local" class="form-control" id="expired_at" name="expired_at"
                            value="{{ $invite->expired_at }}" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role_id" required>
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $invite->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
