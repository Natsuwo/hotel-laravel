@extends('admin.layouts.master')

@section('content')
    <form class="forms-sample" role="form" method="POST" action="{{ route('admin.room_types.update', $record->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create New Room Type</h4>

                        <div class="form-group">
                            <label for="room_title">Room Title</label>
                            <input type="text" class="form-control" id="room_title" name="title" placeholder="Name"
                                value="{{ $record->title }}">
                        </div>
                        <div class="form-group">
                            <label for="room_title">Slug</label>
                            <input type="text" class="form-control" id="room_slug" name="slug" placeholder="Slug"
                                value="{{ $record->slug }}">
                        </div>
                        <div class="form-group">
                            <label for="room_description">Description</label>
                            <textarea class="form-control froala-editor" id="room_description" rows="4" name="description">{{ $record->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="bed_type">Bed Type</label>
                            <select class="form-control" id="bed_type" name="bed_type">
                                <option value="Single" {{ $record->bed_type == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Double" {{ $record->bed_type == 'Double' ? 'selected' : '' }}>Double</option>
                                <option value="Queen" {{ $record->bed_type == 'Queen' ? 'selected' : '' }}>Queen</option>
                                <option value="King" {{ $record->bed_type == 'King' ? 'selected' : '' }}>King</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bed_count">Bed Number</label>
                            <select class="form-control" id="bed_count" name="bed_count">
                                <option value="1" {{ $record->bed_count == 1 ? 'selected' : '' }}>1 Bed</option>
                                <option value="2" {{ $record->bed_count == 2 ? 'selected' : '' }}>2 Beds</option>
                                <option value="3" {{ $record->bed_count == 3 ? 'selected' : '' }}>3 Beds</option>
                                <option value="4" {{ $record->bed_count == 4 ? 'selected' : '' }}>4 Beds</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="room_acreage">Room Acreage</label>
                            <input type="number" class="form-control" id="room_acreage" name="acreage"
                                placeholder="Acreage" step="0.01" value="{{ $record->acreage }}">
                        </div>

                        <div class="form-group">
                            <label for="guest_count">Number of Guests</label>
                            <select class="form-control" id="guest_count" name="guest_count">
                                <option value="1" {{ $record->guest_count == 1 ? 'selected' : '' }}>1 Guest</option>
                                <option value="2" {{ $record->guest_count == 2 ? 'selected' : '' }}>2 Guests</option>
                                <option value="3" {{ $record->guest_count == 3 ? 'selected' : '' }}>3 Guests</option>
                                <option value="4" {{ $record->guest_count == 4 ? 'selected' : '' }}>4 Guests</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Features</label>
                            <div id="features-wrapper" class="row">
                                @foreach ($features as $feature)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            @php
                                                $featuresArray = is_object($record->features)
                                                    ? $record->features->toArray()
                                                    : (array) $record->features;
                                            @endphp
                                            <input class="form-check-input" type="checkbox"
                                                id="features-{{ $feature->id }}" name="features[]"
                                                value="{{ $feature->id }}"
                                                {{ in_array($feature->id, $featuresArray ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="features-{{ $feature->id }}">
                                                {!! $feature->name !!}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Facilities</label>
                            <div id="facilities-wrapper" class="row">
                                @foreach ($facilities as $facility)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            @php
                                                $facilitiesArray = is_object($record->facilities)
                                                    ? $record->facilities->toArray()
                                                    : (array) $record->facilities;
                                            @endphp
                                            <input class="form-check-input" type="checkbox"
                                                id="facilities-{{ $facility->id }}" name="facilities[]"
                                                value="{{ $facility->id }}"
                                                {{ in_array($facility->id, $facilitiesArray ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="facilities-{{ $facility->id }}">
                                                <i class="{{ $facility->icon }}"></i> {{ $facility->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Amenities</label>
                            <div id="amenities-wrapper" class="row">
                                @foreach ($amenities as $amenity)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            @php
                                                $amenitiesArray = is_object($record->amenities)
                                                    ? $record->amenities->toArray()
                                                    : (array) $record->amenities;
                                            @endphp
                                            <input class="form-check-input" type="checkbox"
                                                id="amenities-{{ $amenity->id }}" name="amenities[]"
                                                value="{{ $amenity->id }}"
                                                {{ in_array($amenity->id, $amenitiesArray ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="amenities-{{ $amenity->id }}">
                                                {!! $amenity->name !!}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>

                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Upload Room Image</h4>

                        <!-- Modal for Gallery -->
                        <x-gallery-modal id="galleryModal"></x-gallery-modal>


                        <div class="form-group select-image">
                            <label>Room Images</label>
                            <div id="drop-area" class="drop-area"
                                style="border: 2px dashed #ccc; padding: 20px; text-align: center;"
                                onclick="$('#galleryModal').modal('show');">
                                <p>Drag & Drop your files here or click to upload</p>
                                <div class="d-flex flex-wrap" id="image_preview_container">
                                    @foreach ($record->thumbnails as $thumbnail)
                                        <div class="p-2" style="flex: 0 0 50%;"><img src="{{ $thumbnail['url'] }}"
                                                style="max-width: 100%; margin: 10px; display: block;"></div>
                                        <input type="hidden" name="images[]" value="{{ $thumbnail['id'] }}">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price_per_night">Price per Night</label>
                            <input type="number" class="form-control" id="price_per_night" name="price_per_night"
                                placeholder="Price per Night" step="0.01" value="{{ $record->price_per_night }}">
                        </div>
                        <div class="form-group">
                            <label for="price_per_hour">Price per Hour</label>
                            <input type="number" class="form-control" id="price_per_hour" name="price_per_hour"
                                placeholder="Price per Hour" step="0.01" value="{{ $record->price_per_hour }}">
                        </div>

                        <div class="form-group">
                            <label for="discount">Discount</label>
                            <input type="number" class="form-control" id="discount" name="discount"
                                placeholder="Discount" step="0.01" value="{{ $record->discount }}">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@include('admin.blocks.froala_script')
@section('my-script')
    @include('admin.pages.room_types.script')
@endsection
