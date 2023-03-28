<?php

namespace App\Mail\Host;

use App\Models\Job;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FillJobRequest extends Mailable
{
    use Queueable, SerializesModels;

    public User $applicant;

    public User $user;

    public Job $newJob;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicant, $user, $newJob)
    {
        $this->applicant = $applicant;
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
            subject: $this->applicant->name.' has applied to your '.$this->newJob->gig->event_type,
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
            view: 'emails.host.fill-job-request',
            with: [
                'applicant' => $this->applicant,
                'user' => $this->user,
                'job' => $this->newJob,
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
