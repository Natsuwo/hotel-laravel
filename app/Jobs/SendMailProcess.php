<?php

namespace App\Jobs;

use App\Mail\OrderSucceedMail;
use App\Models\Invoices;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMailProcess implements ShouldQueue
{
    use Queueable;
    public string $email;
    public Invoices $invoice;
    /**
     * Create a new job instance.
     */

    public function __construct(string $email, Invoices $invoice)
    {
        $this->email = $email;
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new OrderSucceedMail($this->invoice));
    }
}
