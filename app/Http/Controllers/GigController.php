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

        $openJobs = Job::whereDoesntHave('users', function ($query) {
            $query->where('status', 'Booked');
        })
        ->join('gigs', 'jobs.gig_id', '=', 'gigs.id')
        ->where('gigs.start_time', '>', now())
        ->orderBy('gigs.start_time')
        ->paginate(10)
        ->fragment('openGigs');

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
        ->get();

        $userGigs = $user->gigs()->with('jobs')->where('start_time', '>', now())->orderBy('start_time')->get();

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
        return redirect()->back();
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
