<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="{{ route('admin.reservation.index') }}"><img
                src="/admin_assets/images/logo.svg" alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini" href="{{ route('admin.reservation.index') }}""><img
                src="/admin_assets/images/logo-mini.svg" alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <x-ui-avatar class="img-xs rounded-circle" :user="$user" />
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">{{ $user->name }}</h5>
                        <span>{{ $user?->roles?->first()?->name }}</span>
                    </div>
                </div>
                <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list"
                    aria-labelledby="profile-dropdown">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-cog text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-onepassword  text-info"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                        </div>
                    </a>
                </div>
            </div>
        </li>
        {{-- <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle " src="/admin_assets/images/faces/face15.jpg" alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
                        <span>Gold Member</span>
                    </div>
                </div>
                <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list"
                    aria-labelledby="profile-dropdown">
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-settings text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-onepassword  text-info"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-calendar-today text-success"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                        </div>
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-speedometer"></i>
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.reservation.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-calendar"></i>
                </span>
                <span class="menu-title">Reservation</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-guests" aria-expanded="false"
                aria-controls="ui-guests">
                <span class="menu-icon">
                    <i class="mdi mdi-account-multiple"></i>
                </span>
                <span class="menu-title">Members</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-guests">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.guest.index') }}">Guests</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('admin.guest_membership.index') }}">Memberships</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-room" aria-expanded="false" aria-controls="ui-room">
                <span class="menu-icon">
                    <i class="mdi mdi-bed"></i>
                </span>
                <span class="menu-title">Room</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-room">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.room_types.index') }}">All</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.room.create') }}">New Room</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.room_types.create') }}">New Room
                            Type</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-feature" aria-expanded="false"
                aria-controls="ui-feature">
                <span class="menu-icon">
                    <i class="mdi mdi-star"></i>
                </span>
                <span class="menu-title">Features</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-feature">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.feature.index') }}">All</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.feature.create') }}">Add
                            Feature</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-floor" aria-expanded="false"
                aria-controls="ui-floor">
                <span class="menu-icon">
                    <i class="mdi mdi-floor-plan"></i>
                </span>
                <span class="menu-title">Floors</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-floor">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.floor.index') }}">All</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.floor.create') }}">Add
                            Floor</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.housekeeping.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-broom"></i>
                </span>
                <span class="menu-title">Housekeeping</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.event_calendar.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-calendar"></i>
                </span>
                <span class="menu-title">Calendar</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-financials" aria-expanded="false"
                aria-controls="ui-financials">
                <span class="menu-icon">
                    <i class="mdi mdi-cash"></i>
                </span>
                <span class="menu-title">Financials</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-financials">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.invoice.index') }}">Invoice</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.expense.index') }}">Expenses</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('admin.transaction.index') }}">Transations</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-inventory" aria-expanded="false"
                aria-controls="ui-inventory">
                <span class="menu-icon">
                    <i class="mdi mdi-archive"></i>
                </span>
                <span class="menu-title">Inventory</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-inventory">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.inventory.index') }}">All</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ routE('admin.inventory_supplier.index') }}">Suppliers</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.message.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-message"></i>
                </span>
                <span class="menu-title">Messages</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.coupon.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-ticket"></i>
                </span>
                <span class="menu-title">Coupon</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-blog" aria-expanded="false"
                aria-controls="ui-blog">
                <span class="menu-icon">
                    <i class="mdi mdi-post"></i>
                </span>
                <span class="menu-title">Blog</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-blog">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.blog.index') }}">Blogs</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('admin.taxonomy-tag.index') }}">Tags</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('admin.taxonomy-category.index') }}">Categories</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="menu-icon">
                    <i class="mdi mdi-security"></i>
                </span>
                <span class="menu-title">User Pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.user.index') }}">All Members</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.roles.index') }}">Roles</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('admin.user_invite.index') }}">Invite</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.gallery.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-image"></i>
                </span>
                <span class="menu-title">Gallery</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.setting.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-cog"></i>
                </span>
                <span class="menu-title">Settings</span>
            </a>
        </li> --}}

        @foreach (config('menu') as $item)
            @php
                $hasSubmenu = isset($item['submenu']);
                $showParent = $hasSubmenu
                    ? collect($item['submenu'])->where('priority', '<=', $userPriority)->isNotEmpty()
                    : $userPriority >= $item['priority'];
            @endphp

            @if ($showParent)
                <li class="nav-item menu-items">
                    @if ($hasSubmenu)
                        <a class="nav-link" data-toggle="collapse" href="#menu-{{ Str::slug($item['title']) }}"
                            aria-expanded="false">
                            <span class="menu-icon">
                                <i class="{{ $item['icon'] }}"></i>
                            </span>
                            <span class="menu-title">{{ $item['title'] }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="menu-{{ Str::slug($item['title']) }}">
                            <ul class="nav flex-column sub-menu">
                                @foreach ($item['submenu'] as $subItem)
                                    @if ($userPriority >= $subItem['priority'])
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route($subItem['route']) }}">
                                                {{ $subItem['title'] }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <a class="nav-link" href="{{ route($item['route']) }}">
                            <span class="menu-icon">
                                <i class="{{ $item['icon'] }}"></i>
                            </span>
                            <span class="menu-title">{{ $item['title'] }}</span>
                        </a>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
</nav>
