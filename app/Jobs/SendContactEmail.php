<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class SendContactEmail implements ShouldQueue
{
    use Queueable;

    protected $data;
    protected $adminEmail;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $adminEmail)
    {
        $this->data = $data;
        $this->adminEmail = $adminEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Отправка письма администратору
        Mail::to($this->adminEmail)->send(new ContactFormMail($this->data));
    }
}
