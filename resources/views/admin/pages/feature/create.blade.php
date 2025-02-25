@extends('admin.layouts.master')

@section('content')
    <form class="forms-sample" role="form" method="POST" action="{{ route('admin.feature.store') }}">
        @csrf
        <div class="row">
            @if (session('success'))
                <div class="col-md-12">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create New Feature</h4>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Value" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="icon">Icon</label>
                            <input type="text" class="form-control" id="icon" name="icon" placeholder="Icon"
                                value="{{ old('icon') }}">
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="facility" {{ old('type') == 'facility' ? 'selected' : '' }}>Facility</option>
                                <option value="feature" {{ old('type') == 'feature' ? 'selected' : '' }}>Feature</option>
                                <option value="amenity" {{ old('type') == 'amenity' ? 'selected' : '' }}>Amenity</option>
                            </select>

                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </div>
                </div>
            </div>
    </form>
@endsection
