@extends('admin.layouts.master')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Guests
                    <a href="{{ route('admin.guest.create') }}" class="btn btn-primary float-right">Add Guest</a>
                </h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Point</th>
                                <th>Membership</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($guests as $guest)
                                <tr>
                                    <td>
                                        <span>
                                            {{ $guest->name }}
                                            <br>
                                            <small style="color: gray;">{{ $guest->uid }}</small>
                                        </span>
                                    </td>
                                    <td>{{ $guest->email }}</td>
                                    <td>{{ $guest->phone }}</td>
                                    <td>{{ $guest->point }}</td>
                                    <td>
                                        @php
                                            $badgeClass = '';
                                            switch ($guest->membership_name) {
                                                case 'Basic':
                                                case 'Bronze':
                                                case 'Silver':
                                                    $badgeClass = 'badge-info';
                                                    break;
                                                case 'Gold':
                                                case 'Platinum':
                                                case 'Diamond':
                                                    $badgeClass = 'badge-success';
                                                    break;
                                                case 'Elite':
                                                case 'VIP':
                                                case 'Royal':
                                                    $badgeClass = 'badge-warning';
                                                    break;
                                                case 'Legend':
                                                    $badgeClass = 'badge-danger';
                                                    break;
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $guest->membership_name }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.guest.edit', $guest->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('admin.guest.destroy', $guest->id) }}" method="POST"
                                            style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $guests->links() }}
            </div>
        </div>
    </div>
@endsection
