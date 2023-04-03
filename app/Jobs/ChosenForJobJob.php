<?php

namespace App\Jobs;

use App\Mail\Player\ChosenForJob;
use App\Models\Job;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ChosenForJobJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $user_id;

    public Job $newJob;

    public bool $canReject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $newJob, $canReject = false)
    {
        $this->user_id = $user_id;
        $this->newJob = $newJob;
        $this->canReject = $canReject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->user_id);
        Mail::to($user->email)->send(new ChosenForJob($user, $this->newJob, $this->canReject));
    }
}
