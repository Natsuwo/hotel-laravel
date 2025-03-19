@props(['events'])
<li class="nav-item dropdown border-left">
    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
        <i class="mdi mdi-bell"></i>
        <span class="count bg-danger"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
        <h6 class="p-3 mb-0">Notifications</h6>
        <div class="dropdown-divider"></div>
        @foreach ($events as $event)
            <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-calendar" style="color: {{ $event->color }}"></i>
                    </div>
                </div>
                <div class="preview-item-content" onclick="window.location='{{ route('admin.event_calendar.index') }}'">
                    <p class="text-muted ellipsis mb-0">{{ $event->title }}</p>
                </div>
            </a>
            <div class="dropdown-divider"></div>
        @endforeach
        <p class="p-3 mb-0 text-center" style="cursor: pointer;"
            onclick="window.location='{{ route('admin.event_calendar.index') }}'">See all
            notifications</p>
    </div>
</li>
