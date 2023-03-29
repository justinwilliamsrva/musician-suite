<?php

namespace App\Mail\Player;

use App\Models\Job;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GigRemoved extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public Job $removedJob;

    public string $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $removedJob, $reason)
    {
        $this->user = $user;
        $this->removedJob = $removedJob;
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'A gig has been removed from your upcoming performances.',
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
            view: 'emails.player.gig-removed',
            with: [
                'job' => $this->removedJob,
                'user' => $this->user,
                'reason' => $this->reason,
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
