<?php

namespace App\Mail;

use App\Models\Check;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CheckDownAlertMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Check $check,
        public ?string $errorMessage = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "🔴 DOWN: {$this->check->name} is not responding",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.check_down_alert',
        );
    }
}






