<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PassportStatusRemoveMail extends Mailable
{
    use Queueable, SerializesModels;

    public $statusData;
    public $reference;

    /**
     * Create a new message instance.
     */
    public function __construct($statusData, $reference)
    {
        $this->statusData = $statusData;
        $this->reference = $reference;
    }

    public function build()
    {
        $viewContent = view('emails.status_error', ['statusData' => $this->statusData])->render();

        return $this->subject('Passport Status Update - ID ' . $this->reference)
            ->html($viewContent);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Passport Status Mail - ID ' . $this->reference,
        );
    }
}
