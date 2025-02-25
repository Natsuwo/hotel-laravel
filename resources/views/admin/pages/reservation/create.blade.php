@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Create Reservation</h1>
        <form action="{{ route('admin.reservation.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="guest_id">Guest ID</label>
                <input type="text" class="form-control" id="guest_id" name="guest_id" value="{{ old('guest_id') }}" required>
                <div id="guest_list"></div>
            </div>
            <div class="form-group">
                <label for="room_id">Room ID</label>
                <input type="text" class="form-control" id="room_id" name="room_id" value="{{ old('room_id') }}"
                    required>
                <div id="room_list"></div>
            </div>
            <div class="form-group">
                <label for="check_in">Check-In Date</label>
                <input type="datetime-local" class="form-control" id="check_in" name="check_in"
                    value="{{ old('check_in') }}" required>
            </div>
            <div class="form-group">
                <label for="check_out">Check-Out Date</label>
                <input type="datetime-local" class="form-control" id="check_out" name="check_out"
                    value="{{ old('check_out') }}" required>
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="price_per_night" name="price_per_night" value="">
            </div>
            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="number" class="form-control" id="duration" name="duration" value="{{ old('duration') }}"
                    required>
            </div>
            <div class="form-group">
                <label for="adults">Adults</label>
                <input type="number" class="form-control" id="adults" name="adults" value="{{ old('adults') }}"
                    required>
            </div>
            <div class="form-group">
                <label for="child">Children</label>
                <input type="number" class="form-control" id="child" name="child" value="{{ old('child') }}"
                    required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Confirmed</option>
                    <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Rejected</option>
                    <option value="3" {{ old('status') == '3' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes">{{ old('notes') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Reservation</button>
        </form>
    </div>
@endsection

@section('my-script')
    @include('admin.blocks.froala_script')
    @include('admin.pages.room_types.script')

    <script>
        new FroalaEditor('#notes', {
            theme: 'dark',
        });

        $(document).ready(function() {
            $('#guest_id').on('input click', function() {
                var search = $(this).val();
                $.ajax({
                    url: "{{ route('admin.guest.get-guest') }}",
                    type: 'GET',
                    data: {
                        name: search
                    },
                    success: function(response) {

                        var guestList = '';
                        response.forEach(function(guest) {
                            guestList += '<div class="guest-item" data-id="' + guest
                                .id +
                                '" style="cursor: pointer; padding: 5px; border: 1px solid #333; margin: 2px 0; background-color: #333; color: #fff;">' +
                                guest.name + '</div>';
                        });
                        $('#guest_list').html(guestList);

                        $('.guest-item').on('click', function() {
                            var guestId = $(this).data('id');
                            $('#guest_id').val(guestId);
                            $('#guest_list').html('');
                        });
                    }
                });
            });

            $('#room_id').on('input click', function() {
                var search = $(this).val();
                $.ajax({
                    url: "{{ route('admin.room.get-room') }}",
                    type: 'GET',
                    data: {
                        name: search
                    },
                    success: function(response) {

                        var roomList = '';
                        response.forEach(function(room) {
                            roomList += '<div class="room-item" data-id="' + room
                                .id +
                                '" data-price="' + room.price +
                                '" style="cursor: pointer; padding: 5px; border: 1px solid #333; margin: 2px 0; background-color: #333; color: #fff;">' +
                                room.room_number + '</div>';
                        });
                        $('#room_list').html(roomList);

                        $('.room-item').on('click', function() {
                            var roomId = $(this).data('id');
                            var pricePerNight = $(this).data('price');
                            $('#room_id').val(roomId);
                            $('#price_per_night').val(pricePerNight);
                            $('#room_list').html('');
                        });
                    }
                });
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('#guest_id, #guest_list').length) {
                    $('#guest_list').html('');
                }
                if (!$(event.target).closest('#room_id, #room_list').length) {
                    $('#room_list').html('');
                }
            });

            $('#check_in, #check_out').on('change', function() {
                var checkInDate = new Date($('#check_in').val());
                var checkOutDate = new Date($('#check_out').val());

                if (checkInDate && checkOutDate && checkOutDate > checkInDate) {
                    var timeDifference = checkOutDate.getTime() - checkInDate.getTime();
                    var daysDifference = Math.ceil(timeDifference / (1000 * 3600 * 24));
                    $('#duration').val(daysDifference);
                } else {
                    $('#duration').val('');
                }
            });
        });
    </script>
@endsection
