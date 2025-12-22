<?php

namespace App\Mail;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent when a job recovers from failed/overdue state.
 */
class JobRecoveredMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Job $job
    ) {}

    public function envelope(): Envelope
    {
        $emoji = $this->job->isHeartbeat() ? '💚' : '✅';
        $type = $this->job->isHeartbeat() ? 'Heartbeat' : 'Job';
        
        return new Envelope(
            subject: "{$emoji} {$type} Recovered: {$this->job->name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.job-recovered',
            with: [
                'job' => $this->job,
                'isHeartbeat' => $this->job->isHeartbeat(),
            ],
        );
    }
}







