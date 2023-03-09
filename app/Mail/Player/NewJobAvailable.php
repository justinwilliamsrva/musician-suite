<?php

namespace App\Mail\Player;

use App\Models\Gig;
use App\Models\Job;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewJobAvailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The job instance.
     *
     * @var Job
     */
    public $job;

    /**
     * The user instance.
     *
     * @var User
     */
    public $user;

    /**
     * The user instance.
     *
     * @var Gig
     */
    public $gig;

    /**
     * Create a new message instance.
     *
     * @param  Job  $job
     */
    public function __construct(Gig $gig, Job $job, User $user)
    {
        $this->gig = $gig;
        $this->job = $job;
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
            subject: 'New Gig Available For '.$this->getInstruments(),
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
            view: 'emails.player.new-job-available',
            with: [
                'gig' => $this->gig,
                'job' => $this->job,
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

    public function getInstruments()
    {
        return implode(', ', json_decode($this->job->instruments));
    }
}
