<?php

return [
  // [
  //   'title' => 'Dashboard',
  //   'icon' => 'mdi mdi-speedometer',
  //   'route' => 'admin.dashboard',
  //   'priority' => 25,
  // ],
  [
    'title' => 'Reservation',
    'icon' => 'mdi mdi-calendar',
    'route' => 'admin.reservation.index',
    'priority' => 50,
  ],
  [
    'title' => 'Members',
    'icon' => 'mdi mdi-account-multiple',
    'priority' => 50,
    'submenu' => [
      [
        'title' => 'Guests',
        'route' => 'admin.guest.index',
        'priority' => 50,
      ],
      [
        'title' => 'Memberships',
        'route' => 'admin.guest_membership.index',
        'priority' => 50,
      ],
    ],
  ],
  [
    'title' => 'Room',
    'icon' => 'mdi mdi-bed',
    'priority' => 50,
    'submenu' => [
      [
        'title' => 'All Rooms',
        'route' => 'admin.room_types.index',
        'priority' => 50,
      ],
      [
        'title' => 'New Room',
        'route' => 'admin.room.create',
        'priority' => 80,
      ],
      [
        'title' => 'New Room Type',
        'route' => 'admin.room_types.create',
        'priority' => 80,
      ],
    ],
  ],
  [
    'title' => 'Features',
    'icon' => 'mdi mdi-star',
    'priority' => 50,
    'submenu' => [
      [
        'title' => 'All Features',
        'route' => 'admin.feature.index',
        'priority' => 50,
      ],
      [
        'title' => 'Add Feature',
        'route' => 'admin.feature.create',
        'priority' => 80,
      ],
    ],
  ],
  [
    'title' => 'Floors',
    'icon' => 'mdi mdi-floor-plan',
    'priority' => 50,
    'submenu' => [
      [
        'title' => 'All Floors',
        'route' => 'admin.floor.index',
        'priority' => 50,
      ],
      [
        'title' => 'Add Floor',
        'route' => 'admin.floor.create',
        'priority' => 80,
      ],
    ],
  ],
  [
    'title' => 'Housekeeping',
    'icon' => 'mdi mdi-broom',
    'route' => 'admin.housekeeping.index',
    'priority' => 10,
  ],
  [
    'title' => 'Event Calendar',
    'icon' => 'mdi mdi-calendar',
    'route' => 'admin.event_calendar.index',
    'priority' => 50,
  ],
  [
    'title' => 'Financials',
    'icon' => 'mdi mdi-cash',
    'priority' => 80,
    'submenu' => [
      [
        'title' => 'Invoice',
        'route' => 'admin.invoice.index',
        'priority' => 80,
      ],
      [
        'title' => 'Expenses',
        'route' => 'admin.expense.index',
        'priority' => 80,
      ],
      [
        'title' => 'Transactions',
        'route' => 'admin.transaction.index',
        'priority' => 80,
      ],
    ],
  ],
  [
    'title' => 'Inventory',
    'icon' => 'mdi mdi-archive',
    'priority' => 80,
    'submenu' => [
      [
        'title' => 'All Inventory',
        'route' => 'admin.inventory.index',
        'priority' => 80,
      ],
      [
        'title' => 'Suppliers',
        'route' => 'admin.inventory_supplier.index',
        'priority' => 80,
      ],
    ],
  ],
  [
    'title' => 'Messages',
    'icon' => 'mdi mdi-message',
    'route' => 'admin.message.index',
    'priority' => 50,
  ],

  [
    'title' => 'Coupons',
    'icon' => 'mdi mdi-ticket-percent',
    'route' => 'admin.coupon.index',
    'priority' => 50,
  ],
  [
    'title' => 'Blog',
    'icon' => 'mdi mdi-post',
    'priority' => 25,
    'submenu' => [
      [
        'title' => 'Blogs',
        'route' => 'admin.blog.index',
        'priority' => 25,
      ],
      [
        'title' => 'Tags',
        'route' => 'admin.taxonomy-tag.index',
        'priority' => 25,
      ],
      [
        'title' => 'Categories',
        'route' => 'admin.taxonomy-category.index',
        'priority' => 25,
      ],
    ],
  ],
  [
    'title' => 'User Management',
    'icon' => 'mdi mdi-security',
    'priority' => 80,
    'submenu' => [
      [
        'title' => 'All Users',
        'route' => 'admin.user.index',
        'priority' => 80,
      ],
      [
        'title' => 'Roles',
        'route' => 'admin.roles.index',
        'priority' => 100,
      ],
      [
        'title' => 'Invite Users',
        'route' => 'admin.user_invite.index',
        'priority' => 100,
      ],
    ],
  ],
  [
    'title' => 'Gallery',
    'icon' => 'mdi mdi-image',
    'route' => 'admin.gallery.index',
    'priority' => 25,
  ],
  [
    'title' => 'Settings',
    'icon' => 'mdi mdi-cog',
    'route' => 'admin.setting.index',
    'priority' => 100,
  ],
];
