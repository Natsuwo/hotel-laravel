@extends('admin.layouts.master')
@php
    function avatar($name)
    {
        $avatar = 'https://ui-avatars.com/api/?name=' . $name;
        return $avatar;
    }
@endphp
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Message Details</h3>
                        <form action="{{ route('admin.message.markAsRead', $message->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">Mark as Read</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <img class="rounded" src="{{ avatar($message->name) }}" alt="{{ $message->name }}">
                        </div>
                        <p class="d-flex justify-content-center flex-column align-items-center">
                            <strong> {{ $message->name }}</strong>
                            <strong> {{ $message->email }}</strong>
                        </p>
                        <p>{!! $message->message !!}</p>
                    </div>
                    <div class="card-footer text-muted d-flex justify-content-between">
                        <p><strong>Sent At:</strong> {{ $message->created_at }}</p>
                        <p>
                            @if ($message->is_read)
                                <span class="badge badge-success">Read</span>
                            @else
                                <span class="badge badge-secondary" style="color: #000;">Unread</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
