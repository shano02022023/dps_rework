<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptApplicant extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;
    public $interview_date;
    public $interview_time;
    /**
     * Create a new message instance.
     */
    public function __construct($applicant)
    {
        $this->applicant = $applicant;
        $this->interview_date = Carbon::parse($applicant->application->interview_date)->format('F j, Y');
        $this->interview_time = Carbon::parse($applicant->application->interview_time)->format('g:i A');  // e.g., 10:00 AM
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Status',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.AcceptApplicant',
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
