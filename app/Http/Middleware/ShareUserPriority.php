<?php

namespace App\Http\Middleware;

use App\Models\EventCalendar;
use App\Models\Message;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareUserPriority
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->shareUserDetails();
        return $next($request);
    }

    /**
     * Share user details with views.
     *
     * @return void
     */
    protected function shareUserDetails(): void
    {
        $user = Auth::user();
        $priority = optional($user?->roles()->first())->priority ?? 0;
        $messages = Message::latest()->take(3)->get();
        $unreadCount = Message::where('is_read', false)->count();
        $events = EventCalendar::where(function ($query) {
            $query->where('start', '<=', now())
                ->where('end', '>=', now());
        })->get();

        View::share('user', $user);
        View::share('userPriority', $priority);
        View::share('events_noti', $events);
        View::share('messages_noti', $messages);
        View::share('unreadCount', $unreadCount);
    }
}
