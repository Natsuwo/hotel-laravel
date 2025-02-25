<div class="card mb-3">
    <div class="card-header">
        <h3>Booking Info</h3>
    </div>
    <div class="card-body">
        <h2 class="my-2 d-flex gap-1 align-items-center">Booking ID: {{ $booking->booking_id }}
            @if ($booking->status == 0)
                <span class="badge badge-info align-self-center">Pending</span>
            @elseif($booking->status == 1)
                <span class="badge badge-success align-self-center">Confirmed</span>
            @elseif($booking->status == 2)
                <span class="badge badge-danger align-self-center">Cancelled</span>
            @elseif($booking->status == 3)
                <span class="badge badge-warning align-self-center">Rejected</span>
            @endif
        </h2>
        <p class="text-muted">{{ $booking->created_at }}</p>
        <div class="row">
            <div class="col-md-4"><small class="text-muted">Room Type:</small>
                <br>
                {{ $room->roomType->title }}
            </div>
            <div class="col-md-4"><small class="text-muted">Room Number:</small>
                <br>
                {{ $room->room_number }}
            </div>
            <div class="col-md-4"><small class="text-muted">Price:</small>
                <br>
                ${{ $room?->roomType?->price_per_night }}
            </div>
            <div class="col-md-4"><small class="text-muted">Guests:</small><br>
                {{ $booking->adults }}
                Adults{{ $booking->children > 0 ? ', ' . $booking->children . ' Children' : '' }}</div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4"><small class="text-muted">Check-in:</small>
                        <br>
                        {{ formatDate($booking->check_in) }}
                    </div>
                    <div class="col-md-4"><small class="text-muted">Check-out:</small>
                        <br>
                        {{ formatDate($booking->check_out) }}
                    </div>
                    <div class="col-md-4"><small class="text-muted">Duration:</small>
                        <br>
                        {{ $booking->duration }} nights
                    </div>
                </div>
            </div>
        </div>
        <p class="mt-3"><small class="text-muted">Note:</small> {!! $booking->notes !!}</p>
    </div>
    <div class="card-footer">
        <small class="text-muted">Amenities:</small>
        <br>
        <ul class="row">
            @foreach ($room?->roomType?->amenities as $amenity)
                <li class="col-md-6 d-flex gap-1">
                    <i class="mdi mdi-check text-success"></i> {!! $amenity->feature->name !!}
                </li>
            @endforeach
        </ul>
        <div class="text-right">
            <button class="btn btn-primary">Edit Booking</button>
            <button class="btn btn-danger">Cancel Booking</button>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ $room?->roomType?->galleries[0]?->gallery?->thumbUrl() }}" class="img-fluid"
                    alt="Room Thumbnail">
                <div class="row mt-2">
                    <div class="col-md-4 d-flex">
                        <p><i class="mdi mdi-ruler"></i> {{ $room?->roomType?->acreage }} m²</p>
                    </div>
                    <div class="col-md-4 d-flex">
                        <p><i class="mdi mdi-bed"></i> {{ $room->roomType?->bed_count }}
                            {{ $room->roomType?->bed_type }}</p>
                    </div>
                    <div class="col-md-4 d-flex">
                        <p><i class="mdi mdi-account-multiple"></i>
                            {{ $room?->roomType?->guest_count }}
                            guests
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <p><strong class="text-muted">Price Summary</strong>
                    @if ($invoice->status == 'paid')
                        <span class="badge badge-success">Paid</span>
                    @elseif ($invoice->status == 'unpaid')
                        <span class="badge badge-warning">Unpaid</span>
                    @elseif ($invoice->status == 'partial')
                        <span class="badge badge-info">Partial</span>
                    @elseif ($invoice->status == 'cancelled')
                        <span class="badge badge-danger">Cancelled</span>
                    @elseif ($invoice->status == 'refunded')
                        <span class="badge badge-secondary">Refunded</span>
                    @endif
                </p>
                <p class="d-flex justify-content-between"><small class="text-muted">Room and
                        Offer:</small>
                    <span>${{ $invoice->price_per_night * $booking->duration }}</span>
                </p>
                {{-- <p><small class="text-muted">Extra:</small> {{ $room->extra }}</p> --}}
                <p class="d-flex justify-content-between"><small class="text-muted">VAT:</small>
                    <span>{{ $invoice->vat }}%</span>
                </p>
                <p class="d-flex justify-content-between"><small class="text-muted">Tax:</small>
                    <span>{{ $invoice->tax }}%</span>
                </p>
                <p class="d-flex justify-content-between"><small class="text-muted">Total Price:</small>
                    <span>${{ $invoice->amount }}</span>
                </p>
            </div>
        </div>
    </div>
</div>
