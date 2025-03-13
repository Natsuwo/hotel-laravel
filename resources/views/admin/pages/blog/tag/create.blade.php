@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Create Taxonomy Tag</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.taxonomy-tag.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('admin.blocks.froala_script')
@section('my-script')
    <script>
        new FroalaEditor('textarea#description', {
            height: 300
        })

        $(document).ready(function() {
            $('#name').on('input', function() {
                $.ajax({
                    url: '{{ route('admin.taxonomy-tag.slug') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: $(this).val()
                    },
                    success: function(res) {
                        $('#slug').val(res.slug)
                    }
                })
            })
        })
    </script>
@endsection
