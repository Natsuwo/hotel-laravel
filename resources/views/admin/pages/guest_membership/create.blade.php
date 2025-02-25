@extends('admin.layouts.master')

@section('content')
    <form class="forms-sample" role="form" method="POST" action="{{ route('admin.guest_membership.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Guest Membership</h4>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                                value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount</label>
                            <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount"
                                value="{{ old('discount') }}">
                        </div>
                        <div class="form-group">

                            <label for="spending_required">Spending Required</label>
                            <input type="text" class="form-control" id="spending_required" name="spending_required"
                                placeholder="Spending Required" value="{{ old('spending_required') }}">
                        </div>
                        <div class="form-group">
                            <label for="point_required">Point Required</label>
                            <input type="text" class="form-control" id="point_required" name="point_required"
                                placeholder="Point Required" value="{{ old('point_required') }}">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
