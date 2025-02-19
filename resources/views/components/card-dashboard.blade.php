@props(['title', 'value', 'percentage', 'is_positive'])
@php
    $classes = $is_positive ?? false ? 'mdi mdi-arrow-top-right icon-item' : 'mdi mdi-arrow-bottom-left icon-item';
@endphp

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-9">
                <div class="d-flex align-items-center align-self-start">
                    <h3 class="mb-0">{{ $title }}</h3>
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
