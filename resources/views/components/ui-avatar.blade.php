@props(['user', 'class' => 'img-xs rounded-circle'])

@php
    $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($user->name);
@endphp

<img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="{{ $class }}">
