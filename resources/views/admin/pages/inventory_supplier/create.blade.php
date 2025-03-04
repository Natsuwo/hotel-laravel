@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Create Supplier</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.inventory_supplier.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="phone" name="phone" id="phone" class="form-control"
                            value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="form-control">{{ old('address') }}</textarea>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
