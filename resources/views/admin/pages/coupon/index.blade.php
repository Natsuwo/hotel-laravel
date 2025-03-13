@extends('admin.layouts.master')

@php
    use Carbon\Carbon;
@endphp

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Coupons
                    <a href="{{ route('admin.coupon.create') }}" class="btn btn-success float-right">New Coupon</a>
                </h4>
                </p>
                <div class="table-responsive">
                    <table class="table" style='min-height: 200px'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Discount</th>
                                <th>Type</th>
                                <th>Max Price</th>
                                <th>Max Usage</th>
                                <th>Usage</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount }}</td>
                                    <td>{{ $coupon->discount_type }}</td>
                                    <td>${{ $coupon->usage_limit_per_coupon }}</td>
                                    <td>{{ $coupon->usage_limit }}</td>
                                    <td>{{ $coupon->usage_count }}</td>
                                    <td>{{ Carbon::parse($coupon->start_date)->format('d/m/Y') }} <br>
                                        {{ Carbon::parse($coupon->end_date)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.coupon.show', $coupon->id) }}"
                                            class="btn btn-primary btn-sm">Show</a>
                                        <a href="{{ route('admin.coupon.edit', $coupon->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.coupon.destroy', $coupon->id) }}" method="POST"
                                            style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $coupons->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
@endsection
