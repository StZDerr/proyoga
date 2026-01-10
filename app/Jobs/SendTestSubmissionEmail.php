<?php

namespace App\Jobs;

use App\Mail\TestSubmissionMail;
use App\Models\TestSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTestSubmissionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected TestSubmission $submission;

    protected $adminEmail;

    public function __construct(TestSubmission $submission, $adminEmail = null)
    {
        $this->submission = $submission;
        $this->adminEmail = $adminEmail ?? env('CONTACT_EMAIL', env('ADMIN_EMAIL'));
    }

    public function handle(): void
    {
        $rawRecipients = $this->adminEmail;
        $recipients = is_array($rawRecipients)
            ? $rawRecipients
            : array_filter(array_map('trim', explode(',', (string) $rawRecipients)));

        $this->submission->loadMissing(['answers.question', 'answers.option']);

        Log::info('SendTestSubmissionEmail: start', [
            'recipients' => $recipients,
            'submission_id' => $this->submission->id,
        ]);

        try {
            Mail::to($recipients)->send(new TestSubmissionMail($this->submission));

            Log::info('SendTestSubmissionEmail: sent', [
                'recipients' => $recipients,
                'submission_id' => $this->submission->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('SendTestSubmissionEmail: error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'recipients' => $recipients,
            ]);

            throw $e;
        }
    }
}
