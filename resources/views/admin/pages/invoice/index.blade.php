@extends('admin.layouts.master')

@php
    use Carbon\Carbon;
@endphp

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Invoice
                    {{-- <a href="{{ route('admin.invoice.create') }}" class="btn btn-primary float-right">Add Booking</a> --}}
                </h4>
                </p>
                <div class="table-responsive">
                    <table class="table" style='min-height: 200px'>
                        <thead>
                            <tr>
                                <th>Guest Name</th>
                                <th>Booking ID</th>
                                <th>Room</th>
                                <th>Price per night</th>
                                <th>Duration</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->guest?->name }}</td>
                                    <td>{{ $invoice->reservation?->booking_id }}</td>
                                    <td>{{ $invoice->room?->roomType?->title }} {{ $invoice->room?->room_number }}</td>
                                    <td>{{ $invoice->room?->roomType?->price_per_night }}</td>
                                    <td>{{ $invoice->reservation?->duration }} nights
                                    </td>
                                    <td>${{ $invoice->amount }}</td>
                                    <td>
                                        @if ($invoice->status == 'pending')
                                            <span class="badge badge-warning">{{ ucfirst($invoice->status) }}</span>
                                        @elseif ($invoice->status == 'paid')
                                            <span class="badge badge-success">{{ ucfirst($invoice->status) }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ ucfirst($invoice->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.invoice.show', $invoice->id) }}"
                                            class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('admin.invoice.edit', $invoice->id) }}"
                                            class="btn btn-primary btn-sm">Download</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $invoices->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
@endsection
