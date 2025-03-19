@props(['room'])

<style>
    .features-list,
    .amenities-list,
    .facilities-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
    }

    .features-list div,
    .amenities-list div {
        width: calc(50% - 1rem);
    }

    .facilities-list div {
        width: calc(100% / 3 - 1rem);
    }
</style>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <h3 class="card-title">Room Details</h3>
            <div class="d-flex">
                <a href="{{ route('admin.room_types.edit', $room->id) }}" class="mr-2">
                    <button class="btn btn-success">
                        Edit
                    </button></a>
                <form action="{{ route('admin.room_types.destroy', $room->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this room?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        <div id="room-detail-content">
            <div class="d-flex align-items-center">
                <h2>{{ $room->title }}</h2>
                <span
                    class="badge badge-{{ $room->available_rooms > 0 ? 'success' : 'info' }} ml-3">{{ $room->available_rooms > 0 ? 'Available' : 'Occupied' }}</span>
            </div>
            <p>
                <span class="card-description">Availability: </span><span>
                    <span class="font-weight-bold">{{ $room->available_rooms }}</span>/
                    {{ $room->total_rooms }}
                </span>
            </p>
            <div class="d-flex">

                @if ($room->thumbnails->count() > 0)
                    <img src="{{ $room->thumbnails->first()['url'] }}" class="img-thumbnail" alt="Room Thumbnail"
                        style="width: 80%; height: 300px; object-fit: cover;">
                @else
                    <img src="https://placehold.co/300" class="img-thumbnail" alt="Room Thumbnail"
                        style="width: 80%; height: 300px; object-fit: cover;">
                @endif
                <div class="d-flex flex-column ml-2" style="width: 20%; max-height: 300px; overflow-y: auto;">
                    @foreach ($room->thumbnails->take(3) as $thumbnail)
                        <img src="{{ $thumbnail['url'] }}" class="img-thumbnail mb-1" alt="Thumbnail"
                            style='max-height: 75px; min-height: 75px; object-fit:cover;'>
                    @endforeach
                    <button class="btn btn-link p-0"
                        style="height: 75px; display: flex; justify-content: center; align-items: center; border: 1px solid #ddd; background-color: #f8f9fa;">
                        View All
                    </button>
                </div>
            </div>
            <div class="card-text d-flex flex-wrap mt-2">
                <span class="d-flex align-items-center">
                    <i class="mdi mdi-ruler-square mr-2"></i>{{ $room->acreage }} m²
                </span>
                <span class="d-flex align-items-center mx-4">
                    <i class="mdi mdi-bed-empty mr-2"></i>{{ $room->bed_count > 1 ? $room->bed_count : '' }}
                    {{ $room->bed_type }} Bed
                </span>
                <span class="d-flex align-items-center">
                    <i class="mdi mdi-account-multiple mr-2"></i>{{ $room->guest_count }} Guests
                </span>
            </div>
            <div class="card-description my-3">
                {!! $room->description !!}
            </div>
            <div class="features">
                <h4>Features</h4>
                <div class="features-list">
                    @if ($room->features)
                        @foreach ($room->features as $feature)
                            <div class="d-flex">
                                <i class="mdi mdi-check-circle text-success mr-2"></i>
                                <p>{!! $feature->name !!}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="facilities">
                <h4>Facilities</h4>
                <div class="facilities-list">
                    @foreach ($room->facilities as $facility)
                        <div class="d-flex">
                            <i class="{{ $facility->icon }} mr-2"></i>
                            <p>{{ $facility->name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="amenities">
                <h4>Amenities</h4>
                <div class="amenities-list">
                    @foreach ($room->amenities as $amenity)
                        <div class="d-flex">
                            <i class="mdi mdi-check-circle text-success mr-2"></i>
                            <p>{!! $amenity->name !!}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
