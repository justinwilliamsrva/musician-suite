<?php

namespace App\Jobs;

use App\Mail\Player\UpcomingJob;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UpcomingJobJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $upcomingJobs = $this->getUpcomingJobs();
        foreach ($upcomingJobs as $job) {
            $user = $job->users()->select(['users.*'])->wherePivot('status', 'Booked')->first() ?? '';
            if (true) {
                Mail::to($user->email)->send(new UpcomingJob($user, $job));
            }
        }
    }

    public function getUpcomingJobs()
    {
        $upcomingJobs = Job::select('jobs.id as job_id', 'jobs.*', 'gigs.*')->whereHas('users', function ($query) {
            $query->where('status', 'Booked');
        })->join('gigs', 'jobs.gig_id', '=', 'gigs.id')
        ->where('gigs.start_time', '>', Carbon::now()->addDays(2))
        ->where('gigs.start_time', '<', Carbon::now()->addDays(3))
        ->get();

        $upcomingJobs->each(function ($job) {
            $job->id = $job->job_id;
        });

        return $upcomingJobs;
    }
}
