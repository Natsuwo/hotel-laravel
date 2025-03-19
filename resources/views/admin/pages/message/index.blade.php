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
            <div class="col-md-12">
                <h2>Messages</h2>
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('admin.message.create') }}" class="btn btn-success">Create</a>
                </div>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ request('filter') == 'unread' ? 'active' : '' }}"
                            href="{{ route('admin.message.index', ['filter' => 'unread']) }}">Unread</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('filter') == 'readed' ? 'active' : '' }}"
                            href="{{ route('admin.message.index', ['filter' => 'readed']) }}">Read</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('filter') == 'all' ? 'active' : '' }}"
                            href="{{ route('admin.message.index', ['filter' => 'all']) }}">All</a>
                    </li>
                </ul>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th>Name</th>
                            <th>Message</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr>
                                <td><input type="checkbox" class="checkItem"></td>
                                <td>
                                    <img src="{{ avatar($message->name) }}" alt="{{ $message->name }}">
                                    {{ $message->name }}
                                </td>
                                <td>{{ Str::limit($message->message, 30) }}</td>
                                <td>{{ $message->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin.message.show', $message->id) }}" class="btn btn-info">View</a>
                                    <a href="{{ route('admin.message.edit', $message->id) }}"
                                        class="btn btn-warning">Edit</a>
                                    <form action="{{ route('admin.message.destroy', $message->id) }}" method="POST"
                                        style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this message?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('checkAll').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('.checkItem');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    </script>
@endsection
