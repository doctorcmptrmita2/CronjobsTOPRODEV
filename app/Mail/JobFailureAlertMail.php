<?php

namespace App\Mail;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobFailureAlertMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Job $job)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cronjobs.to - Job Failure Alert',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.job_failure_alert',
            with: [
                'job' => $this->job,
                'user' => $this->job->user,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
