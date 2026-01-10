<?php

namespace App\Mail;

use App\Models\TestSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public TestSubmission $submission;

    public $answers;

    public string $submittedAt;

    public function __construct(TestSubmission $submission)
    {
        $this->submission = $submission;
        $this->answers = $submission->answers ?? collect();
        $this->submittedAt = ($submission->completed_at?->format('d.m.Y H:i')) ?? now()->format('d.m.Y H:i');
    }

    public function build()
    {
        return $this->subject('Новый результат теста с сайта йоги')
            ->view('emails.test-submission');
    }
}
