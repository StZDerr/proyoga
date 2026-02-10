<?php

namespace App\Jobs;

use App\Mail\SpinWinMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendSpinEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    protected $adminEmail;

    /**
     * Create a new job instance.
     *
     * @param  mixed  $data
     * @param  string|array|null  $adminEmail
     */
    public function __construct($data, $adminEmail = null)
    {
        $this->data = $data;
        $this->adminEmail = $adminEmail ?? env('CONTACT_EMAIL');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $raw = $this->adminEmail;
        $recipients = is_array($raw)
            ? $raw
            : array_filter(array_map('trim', explode(',', (string) $raw)));

        Log::info('SendSpinEmail: start', [
            'recipients' => $recipients,
            'payload' => $this->data,
        ]);

        try {
            Mail::to($recipients)->send(new SpinWinMail($this->data));

            Log::info('SendSpinEmail: sent', [
                'recipients' => $recipients,
            ]);
        } catch (\Throwable $e) {
            Log::error('SendSpinEmail: error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'recipients' => $recipients,
            ]);
            throw $e;
        }
    }
}
