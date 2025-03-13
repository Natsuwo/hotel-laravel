<?php

namespace App\Listeners;

use App\Events\OrderSucceed;
use App\Jobs\SendMailProcess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMailToAdmin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderSucceed $event): void
    {
        // $guest = $event->invoice->guest;
        // $email = $guest->email;
        SendMailProcess::dispatch('natsunguyen42@gmail.com', $event->invoice);
    }
}
