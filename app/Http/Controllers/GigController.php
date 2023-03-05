<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());

        $openJobs = Job::select('jobs.id as job_id', 'jobs.*', 'gigs.*')
        ->whereDoesntHave('users', function ($query) {
            $query->where('status', 'Booked');
        })
        ->join('gigs', 'jobs.gig_id', '=', 'gigs.id')
        ->where('gigs.start_time', '>', now())
        ->orderBy('gigs.start_time')
        ->paginate(10, ['*'], 'openJobs')
        ->fragment('openJobs');

        $openJobs->each(function ($job) {
            $job->id = $job->job_id;
        });

        $userJobs = Job::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->whereDoesntHave('users', function ($query) use ($user) {
            $query->where('user_id', '<>', $user->id)
                ->where('status', '=', 'booked');
        })
        ->with(['users' => function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->select('users.id', 'name', 'email', 'phone_number', 'instruments', 'admin', 'email_verified_at', 'status');
        }])
        ->join('gigs', 'jobs.gig_id', '=', 'gigs.id')
        ->select('jobs.*', 'gigs.start_time')
        ->where('gigs.start_time', '>', now())
        ->orderBy('gigs.start_time')
        ->paginate(5, ['*'], 'userJobs')
        ->fragment('userJobs');

        $userGigs = $user->gigs()
        ->with('jobs')
        ->where('start_time', '>', now())
        ->orderBy('start_time')
        ->paginate(5, ['*'], 'userGigs')
        ->fragment('userGigs');

        return view('musician-finder.dashboard', ['openJobs' => $openJobs, 'userJobs' => $userJobs, 'userGigs' => $userGigs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('musician-finder.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $gig = Gig::create([
            'event_type' => $request->event_type,
            'start_time' => $request->start_date_time,
            'end_time' => $request->end_date_time,
            'street_address' => $request->street_address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->postal_code,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        foreach ($request->musicians as $job) {
            $newJob = Job::create([
                'instruments' => json_encode($job['instruments']),
                'payment' => $job['payment'],
                'extra_info' => $job['extra_info'],
                'gig_id' => $gig->id,
            ]);

            if ($job['fill_status'] == 'filled') {
                $newJob->users()->attach(1, ['status' => 'Booked']);
            }
        }

        return redirect()->route('musician-finder.dashboard')->with('success', $gig->event_type.' Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gig $gig)
    {
        $user = Auth::user();

        return view('musician-finder.show', ['gig' => $gig, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Gig $gig)
    {
        $this->authorize('update', $gig);

        $jobs = [
            ['musicianNumber' => 1],
            ['musicianNumber' => 2],
            ['musicianNumber' => 3],
            ['musicianNumber' => 4],
            ['musicianNumber' => 5],
            ['musicianNumber' => 6],
        ];

        return view('musician-finder.edit', ['jobs' => $jobs]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return view('musician-finder.dashboard');
    }

    public function applyToJob(Job $job)
    {
        $this->authorize('apply-to-job', $job);
        $job->users()->attach(Auth::id(), ['status' => 'Applied']);

        return redirect()->back();
    }
}
