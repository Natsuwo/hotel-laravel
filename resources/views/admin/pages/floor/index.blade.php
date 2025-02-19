@extends('admin.layouts.master')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Floors
                    <a href="{{ route('admin.floor.create') }}" class="btn btn-primary float-right">Add New Floor</a>
                </h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Floor Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $floor)
                                <tr>
                                    <td>{{ $floor->id }}</td>
                                    <td>{{ $floor->floor_number }}</td>
                                    <td>
                                        <a href="{{ route('admin.floor.detail', $floor->id) }}"
                                            class="btn btn-primary">Edit</a>

                                        <form action="{{ route('admin.floor.delete', $floor->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure you want to delete this floor?');"
                                                type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $records->links() }}
            </div>
        </div>
    </div>
@endsection
