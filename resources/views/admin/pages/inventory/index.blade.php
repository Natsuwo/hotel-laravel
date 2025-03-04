@extends('admin.layouts.master')

@section('content')
    <div class="row ">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Inventory</h4>
                </div>
                <div class="card-body">
                    <div class="row my-2">
                        <form class="input-group col-md-6" action="{{ route('admin.inventory.index') }}" method="GET">
                            <input type="text" class="form-control" placeholder="Search category, etc..." name="search"
                                value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button">Search</button>
                            </div>
                        </form>

                        <div class="d-flex col-md-6 justify-content-end">
                            <div class="mr-2">
                                <select class="form-control"
                                    onchange="window.location.href='?{{ http_build_query(request()->except('sort')) }}&sort=' + this.value">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest
                                    </option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest
                                    </option>
                                </select>
                            </div>
                            <div class="mr-2">
                                <select class="form-control"
                                    onchange="window.location.href='?{{ http_build_query(request()->except('category')) }}&category=' + this.value">
                                    <option value="">All Category</option>
                                    {{-- <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready
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
                                        in Progress</option> --}}
                                </select>
                            </div>
                            <div class="align-self-center">
                                <a href="{{ route('admin.inventory.create') }}" class="btn btn-success ">Add Inventory</a>
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
                                            href="?sort_field=name&sort_order={{ request('sort_field') == 'name' && request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                            Item
                                            @if (request('sort_field') == 'name')
                                                <i
                                                    class="mdi {{ request('sort_order') == 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="?sort_field=category&sort_order={{ request('sort_field') == 'category' && request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                            Category
                                            @if (request('sort_field') == 'category')
                                                <i
                                                    class="mdi {{ request('sort_order') == 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="?sort_field=availability&sort_order={{ request('sort_field') == 'availability' && request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                            Availability
                                            @if (request('sort_field') == 'availability')
                                                <i
                                                    class="mdi {{ request('sort_order') == 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="?sort_field=quality_stock&sort_order={{ request('sort_field') == 'quality_stock' && request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                            Quantity in Stock
                                            @if (request('sort_field') == 'quality_stock')
                                                <i
                                                    class="mdi {{ request('sort_order') == 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="?sort_field=quantity_in_reorder&sort_order={{ request('sort_field') == 'quantity_in_reorder' && request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                            Quantity in Reorder
                                            @if (request('sort_field') == 'quantity_in_reorder')
                                                <i
                                                    class="mdi {{ request('sort_order') == 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $inventory)
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-muted m-0">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input">
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($inventory?->gallery)
                                                <img src="{{ $inventory?->gallery?->thumbUrl() }}"
                                                    alt="{{ $inventory->name }}"
                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px;">
                                            @endif
                                            {{ $inventory->name }}
                                        </td>
                                        <td>
                                            {{ ucwords(str_replace('_', ' ', $inventory->category)) }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge 
                                                @if ($inventory->availability == 'available') badge-success 
                                                @elseif($inventory->availability == 'low') badge-warning @else badge-danger @endif">
                                                {{ ucfirst($inventory->availability) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $inventory->stock_quantity }}
                                        </td>
                                        <td>
                                            {{ $inventory->quantity_in_reorder }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.inventory.edit', $inventory->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('admin.inventory.destroy', $inventory->id) }}"
                                                method="POST" style="display: inline-block"
                                                onsubmit="return confirm('Are you sure you want to delete this inventory?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
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
