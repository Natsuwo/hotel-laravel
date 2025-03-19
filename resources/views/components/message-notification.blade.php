@props(['messages', 'unreadCount'])

<li class="nav-item dropdown border-left">
    <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown"
        aria-expanded="false">
        <i class="mdi mdi-email"></i>
        @if ($unreadCount)
            <span class="count bg-success"></span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
        <h6 class="p-3 mb-0">Messages</h6>
        <div class="dropdown-divider"></div>
        @forelse ($messages as $message)
            <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    @php
                        $message->image = 'https://ui-avatars.com/api/?name=' . urlencode($message->name ?? 'User');
                    @endphp
                    <img src="{{ $message->image }}" alt="image" class="rounded-circle profile-pic">
                </div>
                <div class="preview-item-content"
                    onclick="window.location='{{ route('admin.message.show', $message->id) }}'">
                    <p class="preview-subject ellipsis mb-1">{{ $message->name }} sent you a message</p>
                    <p class="text-muted mb-0">{{ $message->created_at }}</p>
                </div>
            </a>
            <div class="dropdown-divider"></div>
        @empty
            <p class="p-3 mb-0 text-center">No new messages</p>
        @endforelse
        @if ($unreadCount)
            <p class="p-3 mb-0 text-center">{{ $unreadCount }} new messages</p>
        @endif
    </div>
</li>
