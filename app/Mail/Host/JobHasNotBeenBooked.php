<?php

namespace App\Mail\Host;

use App\Models\Gig;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobHasNotBeenBooked extends Mailable
{
    use Queueable, SerializesModels;

    public Gig $gig;

    public User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($gig, $user)
    {
        $this->gig = $gig;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Your upcoming '.$this->gig->event_type.' has '.$this->gig->numberOfUnfilledJobs().' unfilled jobs',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.host.job-has-not-been-booked',
            with: [
                'gig' => $this->gig,
                'user' => $this->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
