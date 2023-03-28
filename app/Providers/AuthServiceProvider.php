<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('apply-to-job', function (User $user, Job $job) {
            $userHasSameInstrumentAsJob = count(array_intersect(json_decode($user->instruments), json_decode($job->instruments))) > 0;
            $userIsAdminOrAuthOrOwnerOfJob = ($user->id == Auth::id() || Auth::user()->isAdmin() || $job->gig->user->id == Auth::id());
            if ($userHasSameInstrumentAsJob && $userIsAdminOrAuthOrOwnerOfJob) {
                return true;
            }

            return false;
        });
    }
}
