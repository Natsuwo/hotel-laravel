@extends('admin.layouts.master')

@section('content')
    <div class="row ">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Housekeeping</h4>
                </div>
                <div class="card-body">
                    <div class="row my-2">
                        <form class="input-group col-md-6" action="{{ route('admin.housekeeping.index') }}" method="GET">
                            <input type="text" class="form-control" placeholder="Search room, floor, etc..."
                                name="search" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button">Search</button>
                            </div>
                        </form>

                        <div class="d-flex col-md-6 justify-content-end">
                            <div class="mr-2">
                                <select class="form-control"
                                    onchange="window.location.href='?{{ http_build_query(request()->except('room_type')) }}&room_type=' + this.value">
                                    <option value="">All Rooms</option>
                                    @foreach ($roomTypeNames as $roomTypeName)
                                        <option value="{{ strtolower($roomTypeName) }}"
                                            {{ request('room_type') == strtolower($roomTypeName) ? 'selected' : '' }}>
                                            {{ $roomTypeName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mr-2">
                                <select class="form-control"
                                    onchange="window.location.href='?{{ http_build_query(request()->except('status')) }}&status=' + this.value">
                                    <option value="">All Status</option>
                                    <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready
                                    </option>
                                    <option value="cleaning_in_progress"
                                        {{ request('status') == 'cleaning_in_progress' ? 'selected' : '' }}>
                                        Cleaning in Progress</option>
                                    <option value="needs_cleaning"
                                        {{ request('status') == 'needs_cleaning' ? 'selected' : '' }}>Needs Cleaning
                                    </option>
                                    <option value="needs_inspection"
                                        {{ request('status') == 'needs_inspection' ? 'selected' : '' }}>Needs Inspection
                                    </option>
                                    <option value="inspection_in_progress"
                                        {{ request('status') == 'inspection_in_progress' ? 'selected' : '' }}>Inspection in
                                        Progress</option>
                                    <option value="needs_maintenance"
                                        {{ request('status') == 'needs_maintenance' ? 'selected' : '' }}>Needs Maintenance
                                    </option>
                                    <option value="maintenance_in_progress"
                                        {{ request('status') == 'maintenance_in_progress' ? 'selected' : '' }}>Maintenance
                                        in Progress</option>
                                </select>
                            </div>
                            <div>
                                <select class="form-control"
                                    onchange="window.location.href='?{{ http_build_query(request()->except('priority')) }}&priority=' + this.value">
                                    <option value="">All Priority</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low
                                    </option>
                                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium
                                    </option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check form-check-muted m-0">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" id="select-all">
                                                <i class="input-helper"></i>
                                            </label>
                                            <script>
                                                document.getElementById('select-all').addEventListener('change', function() {
                                                    var checkboxes = document.querySelectorAll('.form-check-input');
                                                    for (var checkbox of checkboxes) {
                                                        checkbox.checked = this.checked;
                                                    }
                                                });
                                            </script>
                                        </div>
                                    </th>
                                    <th>
                                        <a
                                            href="?sort_field=room_number&sort_order={{ request('sort_field') == 'room_number' && request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                            Room Number
                                            @if (request('sort_field') == 'room_number')
                                                <i
                                                    class="mdi {{ request('sort_order') == 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="?sort_field=room_type&sort_order={{ request('sort_field') == 'room_type' && request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                            Room Type
                                            @if (request('sort_field') == 'room_type')
                                                <i
                                                    class="mdi {{ request('sort_order') == 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="?sort_field=housekeeping_status&sort_order={{ request('sort_field') == 'housekeeping_status' && request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                            Housekeeping Status
                                            @if (request('sort_field') == 'housekeeping_status')
                                                <i
                                                    class="mdi {{ request('sort_order') == 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="?sort_field=priority&sort_order={{ request('sort_field') == 'priority' && request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                            Priority
                                            @if (request('sort_field') == 'priority')
                                                <i
                                                    class="mdi {{ request('sort_order') == 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="?sort_field=floor&sort_order={{ request('sort_field') == 'floor' && request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                            Floor
                                            @if (request('sort_field') == 'floor')
                                                <i
                                                    class="mdi {{ request('sort_order') == 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="?sort_field=reservation_status&sort_order={{ request('sort_field') == 'reservation_status' && request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                            Reservation Status
                                            @if (request('sort_field') == 'reservation_status')
                                                <i
                                                    class="mdi {{ request('sort_order') == 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th> Notes </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $housekeeping)
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-muted m-0">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input">
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </td>
                                        <td>Room {{ $housekeeping->room_number }} </td>
                                        <td> {{ $housekeeping->roomType->title }} </td>
                                        <td>
                                            <form
                                                action="{{ route('admin.housekeeping.updateStatus', $housekeeping->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="room_id" value="{{ $housekeeping->id }}">
                                                <input type="hidden" name="booking_id"
                                                    value="{{ $housekeeping->booking_id }}">
                                                <input type="hidden" name="field" value="status">
                                                <div class="dropdown">
                                                    <button
                                                        class="btn 
                                                        @if (str_contains($housekeeping->housekeeping_status, 'ready')) btn-success 
                                                        @elseif (str_contains($housekeeping->housekeeping_status, 'needs')) btn-danger 
                                                        @elseif (str_contains($housekeeping->housekeeping_status, 'in_progress')) btn-warning 
                                                        @else btn-secondary @endif 
                                                        dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        {{ ucwords(str_replace('_', ' ', $housekeeping->housekeeping_status ?? 'Ready')) }}
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <button class="dropdown-item" type="submit" name="value"
                                                            value="ready">Ready</button>
                                                        <button class="dropdown-item" type="submit" name="value"
                                                            value="needs_cleaning">Needs Cleaning</button>
                                                        <button class="dropdown-item" type="submit" name="value"
                                                            value="cleaning_in_progress">Cleaning in Progress</button>
                                                        <button class="dropdown-item" type="submit" name="value"
                                                            value="needs_inspection">Needs Inspection</button>
                                                        <button class="dropdown-item" type="submit" name="value"
                                                            value="inspection_in_progress">Inspection in Progress</button>
                                                        <button class="dropdown-item" type="submit" name="value"
                                                            value="needs_maintenance">Needs Maintenance</button>
                                                        <button class="dropdown-item" type="submit" name="value"
                                                            value="maintenance_in_progress">Maintenance in
                                                            Progress</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form
                                                action="{{ route('admin.housekeeping.updateStatus', $housekeeping->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="room_id" value="{{ $housekeeping->id }}">
                                                <input type="hidden" name="booking_id"
                                                    value="{{ $housekeeping->booking_id }}">
                                                <input type="hidden" name="field" value="priority">
                                                <div class="dropdown">
                                                    <button
                                                        class="btn 
                                                        @if ($housekeeping->housekeeping_priority == 'high') btn-danger 
                                                        @elseif ($housekeeping->housekeeping_priority == 'medium') btn-warning 
                                                        @else btn-success @endif 
                                                        dropdown-toggle"
                                                        type="button" id="priorityDropdown" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        {{ ucfirst($housekeeping->housekeeping_priority ?? 'Low') }}
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="priorityDropdown">
                                                        <button class="dropdown-item" type="submit" name="value"
                                                            value="low">Low</button>
                                                        <button class="dropdown-item" type="submit" name="value"
                                                            value="medium">Medium</button>
                                                        <button class="dropdown-item" type="submit" name="value"
                                                            value="high">High</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            @php
                                                $floorNumber = $housekeeping->floor;
                                                $suffix = 'th';
                                                if (!in_array($floorNumber % 100, [11, 12, 13])) {
                                                    switch ($floorNumber % 10) {
                                                        case 1:
                                                            $suffix = 'st';
                                                            break;
                                                        case 2:
                                                            $suffix = 'nd';
                                                            break;
                                                        case 3:
                                                            $suffix = 'rd';
                                                            break;
                                                    }
                                                }
                                            @endphp
                                            {{ $floorNumber . $suffix }}
                                        </td>
                                        <td>
                                            <div>
                                                @switch($housekeeping->reservations?->status)
                                                    @case('0')
                                                        Pending
                                                    @break

                                                    @case('1')
                                                        Ready
                                                    @break

                                                    @case('2')
                                                        Cancel
                                                    @break

                                                    @case('3')
                                                        Rejected
                                                    @break

                                                    @default
                                                        No have status
                                                @endswitch
                                            </div>
                                        </td>
                                        <td ondblclick="editNotes(this, {{ $housekeeping->id }})">
                                            <span>{{ $housekeeping->notes }}</span>
                                            <input type="text" class="form-control d-none"
                                                value="{{ $housekeeping->notes }}"
                                                onblur="saveNotes(this, {{ $housekeeping->id }})"
                                                onkeypress="if(event.key === 'Enter') saveNotes(this, {{ $housekeeping->id }})">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $records->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('my-script')
    <script>
        function editNotes(element, id) {
            element.querySelector('span').classList.add('d-none');
            element.querySelector('input').classList.remove('d-none');
        }

        function saveNotes(element, id) {
            let notes = element.value;
            element.classList.add('d-none');
            element.previousElementSibling.classList.remove('d-none');

            $.ajax({
                url: "{{ route('admin.housekeeping.updateStatus', $housekeeping->id) }}",
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    '_method': 'PATCH',
                    'room_id': id,
                    'field': 'notes',
                    'value': notes
                },
                success: function(response) {
                    $(element).prev().text(notes);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection
