@extends('admin.layouts.master')

@section('content')
    <form class="forms-sample" role="form" method="POST" action="{{ route('admin.room_types.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create New Room Type</h4>

                        <div class="form-group">
                            <label for="room_title">Room Title</label>
                            <input type="text" class="form-control" id="room_title" name="title" placeholder="Name"
                                value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="room_title">Slug</label>
                            <input type="text" class="form-control" id="room_slug" name="slug" placeholder="Slug"
                                value="{{ old('slug') }}">
                        </div>
                        <div class="form-group">
                            <label for="room_description">Description</label>
                            <textarea class="form-control froala-editor" id="room_description" rows="4" name="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="bed_type">Bed Type</label>
                            <select class="form-control" id="bed_type" name="bed_type">
                                <option value="Single" {{ old('bed_type') == 1 ? 'selected' : '' }}>Single</option>
                                <option value="Double" {{ old('bed_type') == 2 ? 'selected' : '' }}>Double</option>
                                <option value="Queen" {{ old('bed_type') == 3 ? 'selected' : '' }}>Queen</option>
                                <option value="King" {{ old('bed_type') == 4 ? 'selected' : '' }}>King</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bed_count">Bed Number</label>
                            <select class="form-control" id="bed_count" name="bed_count">
                                <option value="1" {{ old('bed_count') == 1 ? 'selected' : '' }}>1 Bed</option>
                                <option value="2" {{ old('bed_count') == 2 ? 'selected' : '' }}>2 Beds</option>
                                <option value="3" {{ old('bed_count') == 3 ? 'selected' : '' }}>3 Beds</option>
                                <option value="4" {{ old('bed_count') == 4 ? 'selected' : '' }}>4 Beds</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="room_acreage">Room Acreage</label>
                            <input type="number" class="form-control" id="room_acreage" name="acreage"
                                placeholder="Acreage" step="0.01" value="{{ old('acreage') }}">
                        </div>

                        <div class="form-group">
                            <label for="guest_count">Number of Guests</label>
                            <select class="form-control" id="guest_count" name="guest_count">
                                <option value="1" {{ old('guest_count') == 1 ? 'selected' : '' }}>1 Guest</option>
                                <option value="2" {{ old('guest_count') == 2 ? 'selected' : '' }}>2 Guests</option>
                                <option value="3" {{ old('guest_count') == 3 ? 'selected' : '' }}>3 Guests</option>
                                <option value="4" {{ old('guest_count') == 4 ? 'selected' : '' }}>4 Guests</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Features</label>
                            <div id="features-wrapper" class="row">
                                @foreach ($features as $feature)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                id="features-{{ $feature->id }}" name="features[]"
                                                value="{{ $feature->id }}"
                                                {{ in_array($feature->id, old('features', [])) ? 'checked' : '' }}>
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
                                            <input class="form-check-input" type="checkbox"
                                                id="facilities-{{ $facility->id }}" name="facilities[]"
                                                value="{{ $facility->id }}"
                                                {{ in_array($facility->id, old('facilities', [])) ? 'checked' : '' }}>
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
                                            <input class="form-check-input" type="checkbox"
                                                id="amenities-{{ $amenity->id }}" name="amenities[]"
                                                value="{{ $amenity->id }}"
                                                {{ in_array($amenity->id, old('amenities', [])) ? 'checked' : '' }}>
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
                        <div class="modal fade" id="galleryModal" tabindex="-1" role="dialog"
                            aria-labelledby="galleryModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content" style="max-height: 90%; overflow-y: auto;">
                                    <div class="modal-footer" style="z-index: 2;">
                                        <button type="button" class="btn btn-success" onclick="chooseFile()"
                                            data-dismiss="modal">Accept</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group select-image">
                            <label>Room Images</label>
                            <div id="drop-area" class="drop-area"
                                style="border: 2px dashed #ccc; padding: 20px; text-align: center;"
                                onclick="$('#galleryModal').modal('show');">
                                <p>Drag & Drop your files here or click to upload</p>
                                <div class="d-flex flex-wrap" id="image_preview_container"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price_per_night">Price per Night</label>
                            <input type="number" class="form-control" id="price_per_night" name="price_per_night"
                                placeholder="Price per Night" step="0.01" value="{{ old('price_per_night') }}">
                        </div>
                        <div class="form-group">
                            <label for="price_per_hour">Price per Hour</label>
                            <input type="number" class="form-control" id="price_per_hour" name="price_per_hour"
                                placeholder="Price per Hour" step="0.01" value="{{ old('price_per_hour') }}">
                        </div>

                        <div class="form-group">
                            <label for="discount">Discount</label>
                            <input type="number" class="form-control" id="discount" name="discount"
                                placeholder="Discount" step="0.01" value="{{ old('discount') }}">
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

    <script>
        $(document).ready(function() {
            let typingTimer;
            let doneTypingInterval = 2000;

            $('#room_title').on('input', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(function() {
                    $.ajax({
                        url: '{{ route('admin.room_types.slug') }}',
                        method: 'GET',
                        data: {
                            slug: $('#room_title').val()
                        },
                        success: function(response) {
                            if (response?.slug) {
                                $('#room_slug').val(response.slug);
                            }
                        },
                        error: function(xhr) {
                            console.error('Error slugifying title:', xhr);
                        }
                    });
                }, doneTypingInterval);
            });

            $('#room_title').on('keydown', function(e) {
                if (e.key === 'Tab') return;
                clearTimeout(typingTimer);
            });
        });
    </script>
@endsection
