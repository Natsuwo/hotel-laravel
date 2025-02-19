@extends('admin.layouts.master')

@section('content')
    <form class="forms-sample" role="form" method="POST" action="{{ route('admin.feature.update', $record->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            @if (session('success'))
                <div class="col-md-12">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create New Feature</h4>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" placeholder="Description">{{ $record->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="feature" {{ $record->type == 'feature' ? 'selected' : '' }}>Feature</option>
                                <option value="amenity" {{ $record->type == 'amenity' ? 'selected' : '' }}>Amenity</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </div>
                </div>
            </div>
    </form>
@endsection

@include('admin.blocks.froala_script')
@section('my-script')
    <script type="text/javascript">
        $(document).ready(function() {
            new FroalaEditor('#description', {
                theme: 'dark',
            });
        });
    </script>
@endsection
