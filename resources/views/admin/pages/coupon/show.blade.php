@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <h1>Coupon Details</h1>
        <div class="card">
            <div class="card-body">
                <p class="card-text">Code: {{ $coupon->code }}</p>
                <p class="card-text">Discount: {{ $coupon->discount }}%</p>
                <p class="card-text">Valid Until: {{ $coupon->end_date }}</p>
            </div>
        </div>

        <h2 class="mt-5">Usage List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Used At</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupon->couponItems as $usage)
                    <tr>
                        <td>{{ $usage->guest->name }}</td>
                        <td>{{ $usage->used_at }}</td>
                        <td>{{ $usage->invoice?->reservation?->booking_id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
