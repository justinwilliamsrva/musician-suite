<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        $validated = $request->validate([
            'event_type' => 'required|string|min:3|max:50',
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date',
            'street_address' => 'required|string|min:3|max:255',
            'city' => 'required|string|max:30',
            'musician-number' => 'numeric',
            'state' => ['required', Rule::in(config('gigs.states'))],
            'postal_code' => 'required|digits:5|integer',
            'description' => 'string|min:3|max:255|nullable',
            'musicians' => 'required|array|max:5',
            'musicians.*.fill_status' => 'required|string',
            'musicians.*.instruments' => 'required|array|min:1|max:10',
            'musicians.*.payment' => 'required|numeric|min:0',
            'musicians.*.extra_info' => 'string|min:3|max:255|nullable',
        ]);
        $gig = Gig::create([
            'event_type' => $validated['event_type'],
            'start_time' => $validated['start_date_time'],
            'end_time' => $validated['end_date_time'],
            'street_address' => $validated['street_address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['postal_code'],
            'description' => $validated['description'] ?? '',
            'user_id' => Auth::id(),
        ]);

        foreach ($validated['musicians'] as $job) {
            $newJob = Job::create([
                'instruments' => json_encode($job['instruments']),
                'payment' => $job['payment'],
                'extra_info' => $job['extra_info'] ?? '',
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

        return view('musician-finder.edit', ['gig' => $gig]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gig $gig)
    {
        $this->authorize('update', $gig);

        $validated = $request->validate([
            'event_type' => 'required|string|min:3|max:50',
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date',
            'street_address' => 'required|string|min:3|max:255',
            'city' => 'required|string|max:30',
            'musician-number' => 'numeric',
            'state' => ['required', Rule::in(config('gigs.states'))],
            'postal_code' => 'required|digits:5|integer',
            'description' => 'string|min:3|max:255|nullable',
            'musicians' => 'required|array|min:1|max:5',
            'musicians.*.id' => 'numeric|nullable',
            'musicians.*.fill_status' => 'string|nullable',
            'musicians.*.musician_picked' => 'max:15|nullable',
            'musicians.*.instruments' => 'required|array|min:1|max:10',
            'musicians.*.payment' => 'required|numeric|min:0',
            'musicians.*.extra_info' => 'string|min:3|max:255|nullable',
        ]);

        $gig->fill([
            'event_type' => $validated['event_type'],
            'start_time' => $validated['start_date_time'],
            'end_time' => $validated['end_date_time'],
            'street_address' => $validated['street_address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['postal_code'],
            'description' => $validated['description'] ?? '',
        ]);

        $gig->save();

        foreach ($validated['musicians'] as $job) {
            $newJob = Job::updateOrCreate([
                'id' => $job['id'] ?? Job::next(),
            ], [
                'instruments' => json_encode($job['instruments']),
                'payment' => $job['payment'],
                'extra_info' => $job['extra_info'] ?? '',
                'gig_id' => $gig->id,
            ]);

            $newJob->save();

            if (isset($job['fill_status'])) {
                if ($job['fill_status'] == 'filled') {
                    $newJob->users()->attach(1, ['status' => 'Booked']);
                }
                if ($job['fill_status'] == 'delete') {
                    $newJob->users()->detach();
                    Job::destroy($newJob->id);
                }
            }
            if (isset($job['musician_picked'])) {
                if ($job['musician_picked'] == 'filled') {
                    $newJob->users()->attach(1, ['status' => 'Booked']);
                }
                if ($job['musician_picked'] == 'delete') {
                    $newJob->users()->detach();
                    Job::destroy($newJob->id);
                }
                if (is_int($job['musician_picked'])) {
                    $newJob->users()->attach($job['musician_picked'], ['status' => 'Booked']);
                }
            }
        }

        return redirect()->back()->with('success', $gig->event_type.' Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gig $gig)
    {
        $this->authorize('update', $gig);

        Job::where('gig_id', $gig->id)->each(function ($job) {
            $job->users()->detach();
            $job->delete();
        });

        $event_type = $gig->event_type;
        $gig->delete();

        return redirect()->route('musician-finder.dashboard')->with('success', $event_type.' Deleted Successfully');
    }

    public function applyToJob(Job $job)
    {
        $this->authorize('apply-to-job', $job);
        $job->users()->attach(Auth::id(), ['status' => 'Applied']);

        return redirect()->back();
    }
}
