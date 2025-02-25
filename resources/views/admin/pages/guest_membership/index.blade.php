@extends('admin.layouts.master')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Guest Membership
                    <a href="{{ route('admin.guest_membership.create') }}" class="btn btn-primary float-right">Add
                        Membership</a>
                </h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Discount</th>
                                <th>Spending Required</th>
                                <th>Point Required</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                                <tr>
                                    <td>{{ $record->id }}</td>
                                    <td>{{ $record->name }}</td>
                                    <td>{{ $record->discount }}%</td>
                                    <td>${{ number_format($record->spending_required) }}</td>
                                    <td>{{ number_format($record->point_required) }}</td>
                                    <td>
                                        <a href="{{ route('admin.guest_membership.edit', $record->id) }}"
                                            class="btn btn-primary">Edit</a>

                                        <form action="{{ route('admin.guest_membership.destroy', $record->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                onclick="return confirm('Are you sure you want to delete this guest membership?');"
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
