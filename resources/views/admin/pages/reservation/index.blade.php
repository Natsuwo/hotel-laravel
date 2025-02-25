@extends('admin.layouts.master')

@php
    use Carbon\Carbon;
@endphp

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Reservation
                    <a href="{{ route('admin.reservation.create') }}" class="btn btn-primary float-right">Add Booking</a>
                </h4>
                </p>
                <div class="table-responsive">
                    <table class="table" style='min-height: 200px'>
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Room</th>
                                <th>Request</th>
                                <th>Duration</th>
                                <th>Check-In & Check-Out</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.reservation.profile', $reservation->guest->id) }}">
                                            {{ $reservation->guest->name }}
                                        </a>
                                        <br>
                                        {{ $reservation->booking_id }}
                                    </td>
                                    <td>#{{ $reservation->room->room_number }}</td>
                                    <td>{!! $reservation->notes !!}</td>
                                    <td>{{ $reservation->duration }}</td>
                                    <td>{{ Carbon::parse($reservation->check_in)->format('d/m/Y H:i') }} <br>
                                        {{ Carbon::parse($reservation->check_out)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-{{ $reservation->status == '0' ? 'warning' : ($reservation->status == '1' ? 'success' : ($reservation->status == '2' ? 'danger' : 'dark')) }} dropdown-toggle"
                                                type="button" id="statusDropdown{{ $reservation->id }}"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @if ($reservation->status == '0')
                                                    Pending
                                                @elseif($reservation->status == '1')
                                                    Confirmed
                                                @elseif($reservation->status == '2')
                                                    Rejected
                                                @elseif($reservation->status == '3')
                                                    Cancelled
                                                @endif
                                            </button>
                                            <div class="dropdown-menu"
                                                aria-labelledby="statusDropdown{{ $reservation->id }}">
                                                <a class="dropdown-item status-select" data-id="{{ $reservation->id }}"
                                                    data-value="0" href="#">
                                                    <span class="badge badge-warning w-100">Pending</span>
                                                </a>
                                                <a class="dropdown-item status-select w-100"
                                                    data-id="{{ $reservation->id }}" data-value="1" href="#">
                                                    <span class="badge badge-success w-100">Confirmed</span>
                                                </a>
                                                <a class="dropdown-item status-select" data-id="{{ $reservation->id }}"
                                                    data-value="2" href="#">
                                                    <span class="badge badge-danger w-100">Rejected</span>
                                                </a>
                                                <a class="dropdown-item status-select" data-id="{{ $reservation->id }}"
                                                    data-value="3" href="#">
                                                    <span class="badge badge-dark w-100">Cancelled</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.reservation.edit', $reservation->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('admin.reservation.destroy', $reservation->id) }}"
                                            method="POST" style="display: inline-block">
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
                {{ $reservations->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
@endsection

@section('my-script')
    <script>
        $(document).ready(function() {
            $('.status-select').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var status = $(this).data('value');
                $.ajax({
                    url: "{{ route('admin.reservation.update-status') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endsection
