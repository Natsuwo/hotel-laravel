@extends('admin.layouts.master')

@section('content')
    <style>
        .flex-50 {
            gap: 0.5rem;
            display: flex;
            flex-wrap: wrap
        }

        .flex-50>div {
            width: calc(50% - 0.5rem);
        }
    </style>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Edit Coupon</h1>
            </div>
            <div class="card-body">
                <form class="flex-50" action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ $coupon->code }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="discount">Discount (percent)</label>
                        <input type="number" class="form-control" id="discount" name="discount"
                            value="{{ $coupon->discount }}" required>
                    </div>
                    <div class="form-group">
                        <label for="discount_type">Discount Type</label>
                        <select class="form-control" id="discount_type" name="discount_type" required>
                            <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>
                                Percent</option>
                            <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="usage_per_user">Usage Per User</label>
                        <input type="number" class="form-control" id="usage_per_user" name="usage_per_user"
                            value="{{ $coupon->usage_per_user }}" required>
                    </div>
                    <div class="form-group">
                        <label for="usage_limit_per_coupon">Max Discount</label>
                        <input type="number" class="form-control" id="usage_limit_per_coupon" name="usage_limit_per_coupon"
                            value="{{ $coupon->usage_limit_per_coupon }}" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="usage_limit">Usage Limit</label>
                        <input type="number" class="form-control" id="usage_limit" name="usage_limit"
                            value="{{ $coupon->usage_limit }}" required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ $coupon->start_date }}" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ $coupon->end_date }}" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="0" {{ $coupon->status == 0 ? 'selected' : '' }}>Inactive</option>
                            <option value="1" {{ $coupon->status == 1 ? 'selected' : '' }}>Active</option>
                        </select>
                    </div>
                    <div></div>
                    <button type="submit" class="btn btn-primary">Update Coupon</button>
                </form>
            </div>
        </div>
    </div>
@endsection
