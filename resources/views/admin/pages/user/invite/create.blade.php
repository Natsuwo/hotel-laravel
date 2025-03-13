@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Create Invite</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.user_invite.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="invite_code">Invite Code</label>
                        <input type="text" class="form-control" id="invite_code" name="invite_code"
                            value="{{ $inviteCode }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="expired_at">Expires</label>
                        <input type="datetime-local" class="form-control" id="expired_at" name="expired_at"
                            value="{{ old('expired_at') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role_id" required>
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
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
