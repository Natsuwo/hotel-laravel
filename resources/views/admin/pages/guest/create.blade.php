@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h2>Create Guest</h2>
        <form action="{{ route('admin.guest.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="uid">UID</label>
                        <input type="text" class="form-control" id="uid" name="uid" value="{{ old('uid') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ old('address') }}">
                    </div>
                    <div class="form-group">
                        <label for="nationality">Nationality</label>
                        <input type="text" class="form-control" id="nationality" name="nationality"
                            value="{{ old('nationality') }}">
                    </div>
                    <div class="form-group">
                        <label for="passport">Passport</label>
                        <input type="text" class="form-control" id="passport" name="passport"
                            value="{{ old('passport') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob"
                            value="{{ old('dob') }}">
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
@section('my-script')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('admin.guest.make-uid') }}",
                type: "GET",
                success: function(response) {
                    $('#uid').val(response.uid);
                }
            });
        });
    </script>
@endsection
