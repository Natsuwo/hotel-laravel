@extends('admin.layouts.master')

@php
    $booking = $latestReservation;
    $guest = $booking->guest;
    $room = $booking->room;
    $invoice = $booking->invoice;
    use Carbon\Carbon;

    function formatDate($date)
    {
        return Carbon::parse($date)->format('Y-m-d h:iA');
    }
@endphp
@section('content')
    <div class="container">
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-3">
                @include('admin.pages.reservation.partials.guest_profile', [
                    'guest' => $guest,
                    'membership' => $membership,
                ])
            </div>

            <!-- Right Column -->
            <div class="col-md-9">
                @include('admin.pages.reservation.partials.booking_info', [
                    'booking' => $booking,
                    'room' => $room,
                    'invoice' => $invoice,
                ])
            </div>
            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Booking History</h4>
                        <div>
                            <form method="get" class="d-inline-block">
                                <input type="text" id="search" placeholder="Search..." name="search"
                                    class="form-control d-inline-block" style="width: 200px;"
                                    value="{{ request('search') }}">
                                <input type="text" id="filter-date" placeholder="Date from" name="date"
                                    class="form-control d-inline-block ml-2 datepicker" style="width: 200px;"
                                    value="{{ request('date') }}">
                                <button type="submit" class="btn btn-primary ml-2">Search</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Booking ID</th>
                                    <th>Booking Date</th>
                                    <th>Room Type</th>
                                    <th>Room Number</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Guests</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservations as $reservation)
                                    <tr>
                                        <td><img src="{{ $reservation?->room?->roomType?->galleries[0]?->gallery?->thumbUrl() }}"
                                                alt="Room Image"
                                                style="width: 110px; height: 75px; object-fit: cover; border-radius: 5px;">
                                        </td>
                                        <td>{{ $reservation->booking_id }}</td>
                                        <td>{{ formatDate($reservation->created_at) }}</td>
                                        <td>{{ $reservation->room?->roomType?->title }}</td>
                                        <td>{{ $reservation->room->room_number }}</td>
                                        <td>{{ formatDate($reservation->check_in) }}</td>
                                        <td>{{ formatDate($reservation->check_out) }}</td>
                                        <td>{{ $reservation->adults + $reservation->children }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('my-script')
    <script>
        $(document).ready(function() {
            $('#filter-date').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD',
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                    firstDay: 1
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            });

            $('#filter-date').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
            });

            $('#filter-date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $('#dark-mode-toggle').on('click', toggleDarkMode);
        });
    </script>
@endsection
