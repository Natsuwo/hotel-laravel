<?php

namespace App\Jobs;

use App\Mail\InviteMail;
use App\Models\UserInvite;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMailInvite implements ShouldQueue
{
    use Queueable;

    public UserInvite $invite;
    public string $email;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(string $email, UserInvite $invite)
    {
        $this->email = $email;
        $this->invite = $invite;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new InviteMail($this->invite));
    }
}
