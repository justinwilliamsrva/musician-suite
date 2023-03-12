<?php

namespace App\Jobs;

use App\Mail\Player\NewJobAvailable;
use App\Models\Gig;
use App\Models\Job;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewJobAvailableJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Gig $gig;
    public Job|null $newJob;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($gig, $newJob = null)
    {
        $this->gig = $gig;
        $this->newJob = $newJob;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_null($this->newJob)) {
            foreach ($this->gig->jobs as $job) {
                $this->sendEmailsToNewJobs($job);
            }
        } else {
            $this->sendEmailsToNewJobs($this->newJob);
        }
    }

    public function sendEmailsToNewJobs($job)
    {
        $jobInstruments = json_decode($job->instruments);
        $userWithSameInstrument = User::where(function ($query) use ($jobInstruments) {
            foreach ($jobInstruments as $instrument) {
                $query->orWhere('instruments', 'like', '%"'.$instrument.'"%');
            }
        })
        ->whereNotIn('id', [1, $this->gig->user_id])
        ->get();
        foreach ($userWithSameInstrument as $user) {
            Mail::to($user->email)->send(new NewJobAvailable($this->gig, $job, $user));
        }
    }
}
