@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Rooms</h1>
            <div class="d-flex align-items-center gap-1">
                <form action="{{ route('admin.room_types.index') }}" method="GET">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control" placeholder="Search..." style="width: 200px;"
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="input-group-text" type="submit">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>
                    </div>
                    @foreach (request()->except('search') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                </form>
                <select class="form-control d-inline-block" style="width: 150px;"
                    onchange="window.location.href='?filter=' + this.value;">
                    <option value="room_type" {{ request('filter') == 'room_type' ? 'selected' : '' }}>Room Type</option>
                    <option value="room_id" {{ request('filter') == 'room_id' ? 'selected' : '' }}>Room ID</option>
                </select>
                <a href="{{ route('admin.room_types.create') }}">
                    <button class="btn btn-primary">Add Room Types</button>
                </a>
            </div>
        </div>
        @if (request('filter') == 'room_id')
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <div class="btn-group" role="group" aria-label="Room Filters">
                                    <a href="?{{ http_build_query(array_merge(request()->query(), ['room_filter' => 'all'])) }}"
                                        class="btn btn-outline-primary {{ request('room_filter') == 'all' ? 'btn-primary text-white' : '' }}">All
                                        Rooms</a>
                                    <a href="?{{ http_build_query(array_merge(request()->query(), ['room_filter' => 'available'])) }}"
                                        class="btn btn-outline-primary {{ request('room_filter') == 'available' ? 'btn-primary text-white' : '' }}">Available
                                        Rooms</a>
                                    <a href="?{{ http_build_query(array_merge(request()->query(), ['room_filter' => 'occupied'])) }}"
                                        class="btn btn-outline-primary {{ request('room_filter') == 'occupied' ? 'btn-primary text-white' : '' }}">Occupied
                                        Rooms</a>
                                    <a href="?{{ http_build_query(array_merge(request()->query(), ['room_filter' => 'maintenance'])) }}"
                                        class="btn btn-outline-primary {{ request('room_filter') == 'maintenance' ? 'btn-primary text-white' : '' }}">Maintenance
                                        Rooms</a>
                                </div>
                                <a href="{{ route('admin.room.create') }}" class="btn btn-primary float-right">Add New
                                    Room</a>
                            </h4>
                            </p>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <a
                                                    href="?{{ http_build_query(array_merge(request()->query(), ['sort' => request('sort') == 'desc' ? 'asc' : 'desc'])) }}">
                                                    #
                                                    <i
                                                        class="mdi mdi-arrow-{{ request('sort') == 'desc' ? 'down' : 'up' }}"></i>
                                                </a>
                                            </th>
                                            <th>Number</th>
                                            <th>Type</th>
                                            <th>Floor</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rooms as $room)
                                            <tr>
                                                <td>{{ $room->room_id }}</td>
                                                <td>{{ $room->room_number }}</td>
                                                <td>{{ $room->title }}</td>
                                                <td>{{ $room->floor_number }}</td>
                                                <td>
                                                    <x-tag-status status="{{ $room->status }}" />
                                                </td>
                                                <td class="d-flex gap-1">
                                                    <a href="{{ route('admin.room.edit', ['id' => $room->room_id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                    <form
                                                        action="{{ route('admin.room.destroy', ['id' => $room->room_id]) }}"
                                                        method="POST"
                                                        onsubmit="return confirm(`Are you sure you want to delete room {{ $room->room_number }}?` );">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $rooms->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div id='card-left' class="col-md-12">
                    <div class="row">
                        @foreach ($rooms as $room)
                            <div class="col-md-12 mb-4">
                                <div class="card rounded overflow-hidden" onclick="showRoomDetail({{ $room->id }})"
                                    style="cursor:pointer;"
                                    onmouseover="this.querySelector('.overlay').style.display='block';"
                                    onmouseout="this.querySelector('.overlay').style.display='none';">
                                    <div class="overlay"
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.1); display: none;">
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-md-4 col-sm-12 card-col-thumbnail">
                                            @if ($room->thumbnails->count() > 0)
                                                <img class="w-100 h-100" src="{{ $room->thumbnails[0]['url'] }}"
                                                    class="card-img" alt="Room Thumbnail" style="object-fit: cover;">
                                            @else
                                                <img src="https://via.placeholder.com/300" class="card-img"
                                                    alt="Room Thumbnail">
                                            @endif

                                        </div>
                                        <div class="col-md-8 col-sm-12 card-col-content">
                                            <div class="card-body d-flex flex-column justify-content-between"
                                                style="height: 100%;">
                                                <h1 class="card-title">{{ $room->title }} <span
                                                        class="badge badge-{{ $room->available_rooms > 0 ? 'success' : 'info' }} float-right">{{ $room->available_rooms > 0 ? 'Available' : 'Occupied' }}</span>
                                                </h1>
                                                <div class="card-text d-flex flex-wrap">
                                                    <span class="d-flex align-items-center">
                                                        <i class="mdi mdi-ruler-square mr-2"></i>{{ $room->acreage }} m²
                                                    </span>
                                                    <span class="d-flex align-items-center mx-4">
                                                        <i
                                                            class="mdi mdi-bed-empty mr-2"></i>{{ $room->bed_count > 1 ? $room->bed_count : '' }}
                                                        {{ $room->bed_type }} Bed
                                                    </span>
                                                    <span class="d-flex align-items-center">
                                                        <i
                                                            class="mdi mdi-account-multiple mr-2"></i>{{ $room->guest_count }}
                                                        Guests
                                                    </span>
                                                </div>
                                                <div class="card-description mt-3 flex-grow-1">
                                                    <p class="card-text">{!! $room->description !!}</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        Availability: <span class="font-weight-bold">
                                                            {{ $room->available_rooms }}
                                                        </span>/{{ $room->total_rooms }}
                                                    </div>
                                                    <span class="text-primary">
                                                        <span class="font-weight-bold">${{ $room->price_per_night }}</span>
                                                        /night</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6" id="room-detail-content"></div>
            </div>
        @endif


    </div>
@endsection

@section('my-script')
    <script>
        var currentRoomId = null;

        function showRoomDetail(roomId) {
            if (currentRoomId === roomId) {
                $('#card-left').removeClass('col-md-6').addClass('col-md-12');
                $('#room-detail-content').html('');
                $('.card-col-thumbnail').removeClass('d-none').addClass('col-md-4');
                $('.card-col-content').removeClass('col-md-12').addClass('col-md-8');

                currentRoomId = null;
                return;
            }
            currentRoomId = roomId;
            $('#card-left').removeClass('col-md-12').addClass('col-md-6');
            $('.card-col-thumbnail').removeClass('col-md-4').addClass('d-none');
            $('.card-col-content').removeClass('col-md-8').addClass('col-md-12');
            $('#room-detail-content').html(
                '<div class="d-flex justify-content-center align-items-center" style="height: 100%;"><i class="mdi mdi-loading mdi-spin" style="font-size: 30px;"></i> Loading...</div>'
            );
            $.ajax({
                url: `{{ route('admin.room_types.show', '') }}/${roomId}`,
                success: function(response) {
                    if (response?.html) {
                        $('#room-detail-content').html(response?.html);
                    }
                }
            });
        }
    </script>
@endsection
