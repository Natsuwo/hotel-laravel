@extends('admin.layouts.master')

@section('content')
    <form class="forms-sample" role="form" method="POST" action="{{ route('admin.room.update', $room->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create New Room</h4>

                        <div class="form-group">
                            <label for="room_number">Room Number</label>
                            <input type="text" class="form-control" id="room_number" name="room_number"
                                placeholder="Room Number" value="{{ $room->room_number }}">
                        </div>
                        <div class="form-group">
                            <label for="floor">Floor</label>
                            <select class="form-control" id="floor" name="floor_id">
                                <option value="">Select Floor</option>
                                @foreach ($floors as $floor)
                                    <option value="{{ $floor->id }}"
                                        {{ $floor->id == $room->floor_id ? 'selected' : '' }}>
                                        {{ $floor->floor_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="room_type">Type</label>
                            <select class="form-control" id="room_type" name="room_type_id">
                                <option value="">Select Room Type</option>
                                @foreach ($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}"
                                        {{ $roomType->id == $room->room_type_id ? 'selected' : '' }}>
                                        {{ $roomType->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="room_status">Room Status</label>
                            <select class="form-control" id="room_status" name="status">
                                <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available
                                </option>
                                <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Occupied
                                </option>
                                <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>
                                    Maintenance</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Submit</button>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
