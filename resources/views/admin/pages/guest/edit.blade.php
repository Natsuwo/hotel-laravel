@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h2>Update Guest</h2>
        <form action="{{ route('admin.guest.update', $record->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $record->name }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="uid">UID</label>
                        <input type="text" class="form-control" id="uid" name="uid" value="{{ $record->uid }}"
                            disabled>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $record->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ $record->phone }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ $record->address }}">
                    </div>
                    <div class="form-group">
                        <label for="nationality">Nationality</label>
                        <input type="text" class="form-control" id="nationality" name="nationality"
                            value="{{ $record->nationality }}">
                    </div>
                    <div class="form-group">
                        <label for="passport">Passport</label>
                        <input type="text" class="form-control" id="passport" name="passport"
                            value="{{ $record->passport }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ $record->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $record->gender == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ $record->gender == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob"
                            value="{{ $record->dob }}">
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <input type="file" class="form-control" id="avatar" name="avatar">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Guest</button>
        </form>
    </div>
@endsection
