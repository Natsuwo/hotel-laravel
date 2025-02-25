@props(['status'])
<span
    {{ $attributes->merge(['class' => 'badge badge-' . ($status == 'available' ? 'success' : ($status == 'occupied' ? 'info' : 'danger'))]) }}>
    {{ ucfirst($status) }}
</span>
