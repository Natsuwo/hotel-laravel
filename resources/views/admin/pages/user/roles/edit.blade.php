@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Create Roles</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4">{{ $role->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="is_active" required>
                            <option value="1" {{ $role->is_active == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $role->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <input type="number" class="form-control" id="priority" name="priority"
                            value="{{ $role->priority }}" required max="100" min="0"
                            oninput="this.value = Math.max(0, Math.min(100, this.value))">
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
