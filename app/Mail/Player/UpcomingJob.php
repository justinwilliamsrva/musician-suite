<?php

namespace App\Mail\Player;

use App\Models\Job;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UpcomingJob extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public Job $newJob;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $newJob)
    {
        $this->user = $user;
        $this->newJob = $newJob;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Performance Reminder: Upcoming '.$this->newJob->gig->event_type.' on '.date_format($this->newJob->gig->start_time, 'l'),
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
            view: 'emails.player.upcoming-job',
            with: [
                'job' => $this->newJob,
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
