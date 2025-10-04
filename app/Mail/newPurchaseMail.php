<?php

namespace App\Mail;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class newPurchaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Course $course)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Purchase',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.new-purchase',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
