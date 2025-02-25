<div class="card">
    <div class="card-body">
        <div class="text-center">
            <img src="{{ $guest->avatar ?: asset('assets/avatar/default.png') }}" class="rounded-circle" alt="Avatar"
                width="100">
        </div>
        <h4 class="text-center">{{ $guest->name }}</h4>
        <p class="text-center text-muted">{{ $guest->uid }}</p>
        <hr>
        <p><i class="mdi mdi-phone"></i> {{ $guest->phone }}</p>
        <p><i class="mdi mdi-email"></i> {{ $guest->email }}</p>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <p><small class="text-muted">Date of Birth:</small><br> {{ $guest->dob }}</p>
            </div>
            <div class="col-md-6">
                <p><small class="text-muted">Gender:</small><br> {{ $guest->gender }}</p>
            </div>
            <div class="col-md-6">
                <p><small class="text-muted">Nationality:</small><br> {{ $guest->nationality }}</p>
            </div>
            <div class="col-md-6">
                <p><small class="text-muted">Passport:</small><br> {{ $guest->passport }}</p>
            </div>
        </div>
        <hr>
        <p><small class="text-muted">Membership:</small> <br><span
                class="badge badge-primary">{{ $membership->name }}</span></p>
        <div class="row">
            <div class="col-md-6">
                <p><small class="text-muted">Points:</small><br> {{ $guest->point }}</p>
            </div>
            <div class="col-md-6">
                <p><small class="text-muted">Discount:</small><br> {{ $membership->discount }}%</p>
            </div>
        </div>
    </div>
</div>
