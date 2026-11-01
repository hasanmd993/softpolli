<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewInquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Inquiry $inquiry)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $typeLabel = $this->inquiry->type === 'quote' ? 'New Quote Request' : 'New Contact Inquiry';

        return new Envelope(
            subject: "[SoftPolli] {$typeLabel} from {$this->inquiry->name}",
            replyTo: [$this->inquiry->email],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry_received',
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
