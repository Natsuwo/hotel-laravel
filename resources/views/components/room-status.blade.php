@props(['title', 'description', 'icon', 'icon-bg', 'time', 'value'])

<div class="preview-item border-bottom">
    <div class="preview-thumbnail">
        <div class="preview-icon {{ $iconBg }}">
            <i class="{{ $icon }}"></i>
        </div>
    </div>
    <div class="preview-item-content d-sm-flex flex-grow">
        <div class="flex-grow">
            <h6 class="preview-subject">{{ $title }}</h6>
            <p class="text-muted mb-0">
                {{ $description }}
            </p>
        </div>
        <div class="mr-auto text-sm-right pt-2 pt-sm-0">
            <p class="text-muted">{{ $time }}</p>
            <p class="text mb-0"><strong>{{ $value }}</strong></p>
        </div>
    </div>
</div>
