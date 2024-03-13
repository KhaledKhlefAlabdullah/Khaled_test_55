<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PortalMails extends Mailable
{
    use Queueable, SerializesModels;

    public $customMessage;

    /**
     * Create a new message instance.
     */
    public function __construct($customMessage)
    {
        $this->customMessage = $customMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Portal Mails',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // todo we have to customize maile view
        return new Content(
            view: 'mail.maile_view',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
