<?php

namespace App\Jobs;

use App\Mail\Host\JobHasNotBeenBooked;
use App\Models\Gig;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class JobHasNotBeenBookedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $gigsWithUnfilledJobs = Gig::whereHas('jobs', function ($query) {
            $query->whereDoesntHave('users', function ($query) {
                $query->where('status', 'Booked');
            });
        })
        ->where('start_time', '>', Carbon::now()->addDays(5))
        ->where('start_time', '<', Carbon::now()->addDays(6))
        ->get();

        foreach ($gigsWithUnfilledJobs as $gig) {
            $user = User::find($gig->user_id);
            Mail::to($user->email)->send(new JobHasNotBeenBooked($gig, $user));
        }
    }
}
