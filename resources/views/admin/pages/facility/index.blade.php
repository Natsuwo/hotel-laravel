@extends('admin.layouts.master')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Facilities
                    <a href="{{ route('admin.facility.create') }}" class="btn btn-success float-right">Add Facility</a>
                </h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $facility)
                                <tr>
                                    <td>{{ $facility->id }}</td>
                                    <td>{{ $facility->name }}</td>
                                    <td><i class="{{ $facility->icon }}"></i></td>
                                    <td>
                                        <a href="{{ route('admin.facility.edit', $facility->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('admin.facility.destroy', $facility->id) }}" method="POST"
                                            style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $records->links() }}
        </div>
    </div>
@endsection
