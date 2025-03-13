@extends('admin.layouts.master')

@section('content')
    <form class="forms-sample" role="form" method="POST" action="{{ route('admin.floor.update', $record->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Floor</h4>

                        <div class="form-group">
                            <label for="floor_number">Floor Number</label>
                            <input type="text" class="form-control" id="floor_number" name="floor_number"
                                placeholder="Floor Number" value="{{ $record->floor_number }}">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
