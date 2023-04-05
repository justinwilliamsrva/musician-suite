<?php

namespace App\Jobs;

use App\Mail\Player\GigRemoved;
use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class GigRemovedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Job|null $removedJob;

    public string $typeOfDelete;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($removedJob, $typeOfDelete)
    {
        $this->typeOfDelete = $typeOfDelete;
        $this->removedJob = $removedJob;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->typeOfDelete == 'all') {
            $reason = 'the gig was deleted';
            $usersWhoApplied = Job::find($this->removedJob->id)->users()->get();
            foreach ($usersWhoApplied as $user) {
                Mail::to($user->email)->send(new GigRemoved($user, $this->removedJob, $reason));
            }
        } elseif ($this->typeOfDelete == 'booked') {
            $reason = 'the Host booked another musician';
            $usersWhoApplied = Job::find($this->removedJob->id)->users()
                    ->wherePivot('status', 'Applied')
                    ->get();
            foreach ($usersWhoApplied as $user) {
                Mail::to($user->email)->send(new GigRemoved($user, $this->removedJob, $reason));
            }
        } elseif ($this->typeOfDelete == 'onlyBookedMusician') {
            $reason = 'the Host booked another musician';
            $bookedUser = Job::find($this->removedJob->id)->users()->select(['users.*'])
                    ->wherePivot('status', 'Booked')
                    ->first();
            $bookedUser->jobs()->updateExistingPivot($this->removedJob->id, ['status' => 'Applied']);
            Mail::to($bookedUser->email)->send(new GigRemoved($bookedUser, $this->removedJob, $reason));
        }
}
