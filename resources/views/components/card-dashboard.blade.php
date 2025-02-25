@props(['title', 'value', 'percentage', 'is_positive', 'icon' => null])
@php
    $is_positive = $is_positive == 'true' ? true : false;
    $classes = $is_positive ? 'mdi mdi-arrow-top-right icon-item' : 'mdi mdi-arrow-bottom-left icon-item';
@endphp

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-9">
                <div class="d-flex align-items-center align-self-start">
                    @if ($icon)
                        <span {{ $attributes->merge(['class' => $icon]) }}></span>
                    @endif
                    <p class="mb-0 text-muted{{ $icon ? ' ml-2' : '' }}">{{ $title }}</p>
                    <p class="text-{{ $is_positive ? 'success' : 'danger' }} ml-2 mb-0 font-weight-medium">
                        {{ $percentage }}</p>
                </div>
            </div>
            <div class="col-3">
                <div class="icon icon-box-{{ $is_positive ? 'success' : 'danger' }}">
                    <span {{ $attributes->merge(['class' => $classes]) }}></span>
                </div>
            </div>
        </div>
        <h6 class="text-muted font-weight-normal">{{ $value }}</h6>
    </div>
</div>
