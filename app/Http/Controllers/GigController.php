<?php

namespace App\Http\Controllers;

use App\Jobs\ChosenForJobJob;
use App\Jobs\FillJobRequestJob;
use App\Jobs\NewJobAvailableJob;
use App\Models\Gig;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFilter($filteredData = ['instrument_match' => 0, 'user_jobs_show_all' => 0, 'user_jobs_show_all' => 0])
    {
        // Get Auth User
        $user = User::find(Auth::id());

        // Get openJobs
        $userInstruments = ($filteredData['instrument_match']) ? json_decode($user->instruments) : config('gigs.instruments');
        $openJobs = Job::select('jobs.id as job_id', 'jobs.*', 'gigs.*')
        ->whereDoesntHave('users', function ($query) use ($user) {
            $query->where('status', 'Booked')
                ->orWhere(function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id)
                        ->where('status', 'Applied');
                });
        })
        ->join('gigs', 'jobs.gig_id', '=', 'gigs.id')
        ->where('gigs.end_time', '>', now())
        ->where(function ($query) use ($userInstruments) {
            foreach ($userInstruments as $instrument) {
                $query->orWhere('instruments', 'like', '%"'.$instrument.'"%');
            }
        })
        ->orderBy('gigs.start_time')
        ->paginate(10, ['*'], 'openJobs')
        ->fragment('openJobs');

        $openJobs->each(function ($job) {
            $job->id = $job->job_id;
        });

        // Get User's performances
        $userJobsShowAll = ($filteredData['user_jobs_show_all']) ? Carbon::create('1970', '1', '1') : now();
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
        ->select('jobs.*', 'gigs.start_time', 'gigs.end_time')
        ->where('gigs.end_time', '>', $userJobsShowAll)
        ->orderBy('gigs.start_time')
        ->paginate(4, ['*'], 'userJobs')
        ->fragment('userJobs');

        // Get Gigs created by User
        $userGigsShowAll = ($filteredData['user_gigs_show_all']) ? Carbon::create('1970', '1', '1') : now();
        $userGigs = $user->gigs()
        ->with('jobs')
        ->where('end_time', '>', $userGigsShowAll)
        ->orderBy('start_time')
        ->paginate(4, ['*'], 'userGigs')
        ->fragment('userGigs');

        return view('musician-finder.dashboard', ['openJobs' => $openJobs, 'userJobs' => $userJobs, 'userGigs' => $userGigs, 'filteredData' => $filteredData]);
    }

    public function index(Request $request)
    {
        if ($request->all()) {
            $filteredData = $request->validate([
                'instrument_match' => 'sometimes|boolean|nullable',
                'user_jobs_show_all' => 'sometimes|boolean|nullable',
                'user_gigs_show_all' => 'sometimes|boolean|nullable',
            ]);
        }

        $filteredData['instrument_match'] = $filteredData['instrument_match'] ?? false;
        $filteredData['user_jobs_show_all'] = $filteredData['user_jobs_show_all'] ?? false;
        $filteredData['user_gigs_show_all'] = $filteredData['user_gigs_show_all'] ?? false;

        return $this->indexFilter($filteredData);
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
            'end_date_time' => 'required|date|after_or_equal:start_date_time',
            'street_address' => 'required|string|min:3|max:255',
            'city' => 'required|string|max:30',
            'musician-number' => 'numeric',
            'state' => ['required', Rule::in(config('gigs.states'))],
            'zip_code' => 'required|digits:5|integer',
            'payment-all' => 'required_if:payment-method,same',
            'description' => 'string|min:3|max:255|nullable',
            'musicians' => 'required|array|max:6',
            'musicians.*.fill_status' => 'required|string',
            'musicians.*.instruments' => ['required', 'array', 'min:1', 'max:10', Rule::in(config('gigs.instruments'))],
            'musicians.*.payment' => 'required|numeric|min:0',
            'musicians.*.extra_info' => 'string|min:3|max:255|nullable',
        ], [
            'payment-all.required_if' => 'The payment field is required when the same payment question is answered is "Yes".',

            'musicians' => 'The number of musicians must be between 1 and 6',

            'musicians.*.instruments.required' => 'The instrument field is required.',
            'musicians.*.instruments.array' => 'The instrument field must be an array.',
            'musicians.*.instruments.min' => 'The instrument field must have at least :min items.',
            'musicians.*.instruments.max' => 'The instrument field may not have more than :max items.',
            'musicians.*.instruments.in' => 'The instrument field contains an invalid value.',

            'musicians.*.fill_status.required' => 'The fill status field is required.',
            'musicians.*.fill_status.string' => 'The fill status field must be a string.',

            'musicians.*.payment.required' => 'The payment field is required.',
            'musicians.*.payment.numeric' => 'The payment field must be a number.',
            'musicians.*.payment.min' => 'The payment field must be at least :min.',

            'musicians.*.extra_info.string' => 'The extra info field must be a string.',
            'musicians.*.extra_info.min' => 'The extra info field must be at least :min characters.',
            'musicians.*.extra_info.max' => 'The extra info field may not be greater than :max characters.',
        ]);

        $gig = Gig::create([
            'event_type' => $validated['event_type'],
            'start_time' => $validated['start_date_time'],
            'end_time' => $validated['end_date_time'],
            'street_address' => $validated['street_address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['zip_code'],
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

            if ($job['fill_status'] == 'myself') {
                $newJob->users()->attach(Auth::id(), ['status' => 'Booked']);
            }

            if ($job['fill_status'] == 'unfilled') {
                NewJobAvailableJob::dispatch($gig, $newJob);
            }
        }

        return redirect()->route('musician-finder.dashboard')->with('success', $gig->event_type.' Created Successfully.');
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
        if (Auth::user()->admin != 1) {
            $this->authorize('update', $gig);
        }

        $jobsArray = $gig->jobs->toArray();

        foreach ($gig->jobs as $key => $job) {
            $isJobBooked = $job->jobHasBeenBooked($job);
            $userBookedID = $job->users()->select(['users.*'])->wherePivot('status', 'Booked')->first()->id ?? '';
            $userBookedName = $job->users()->select(['users.*'])->wherePivot('status', 'Booked')->first()->name ?? '';
            $numberOfJobApplicants = $job->users()->count();
            $jobUsers = json_encode($job->users);

            $jobsArray[$key] = [
                'id' => $job->id,
                'payment' => $job->payment,
                'users' => $jobUsers,
                'extra_info' => $job->extra_info,
                'instruments' => json_decode($job->instruments),
                'isJobBooked' => $isJobBooked,
                'userBookedID' => $userBookedID,
                'userBookedName' => $userBookedName,
                'numberOfJobApplicants' => $numberOfJobApplicants,
            ];
        }

        return view('musician-finder.edit', ['gig' => $gig, 'jobsArray' => $jobsArray]);
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
        if (Auth::user()->admin != 1) {
            $this->authorize('update', $gig);
        }

        $data = $request->all();
        $data['musicians'] = array_filter($data['musicians'], function ($musician) {
            $status = $musician['fill_status'] ?? $musician['musician_picked'];

            return $status !== 'delete';
        });

        $requestDataWithoutDeletedJobs = $data;
        $validator = Validator::make($requestDataWithoutDeletedJobs, [
            'event_type' => 'required|string|min:3|max:50',
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date|after_or_equal:start_date_time',
            'street_address' => 'required|string|min:3|max:255',
            'city' => 'required|string|max:30',
            'payment-all' => 'required_if:payment-method,same',
            'musician-number' => 'numeric',
            'state' => ['required', Rule::in(config('gigs.states'))],
            'zip_code' => 'required|digits:5|integer',
            'description' => 'string|min:3|max:255|nullable',
            'musicians' => 'required|array|min:1|max:6',
            'musicians.*.id' => 'sometimes',
            'musicians.*.isJobBooked' => 'sometimes',
            'musicians.*.userBookedName' => 'sometimes',
            'musicians.*.userBookedID' => 'sometimes',
            'musicians.*.numberOfJobApplicants' => 'sometimes',
            'musicians.*.users' => 'sometimes',
            'musicians.*.fill_status' => 'sometimes|string|max:15',
            'musicians.*.musician_picked' => 'sometimes|string|max:15',
            'musicians.*.instruments' => ['required', 'array', 'min:1', 'max:10', Rule::in(config('gigs.instruments'))],
            'musicians.*.payment' => 'required|numeric|min:0',
            'musicians.*.extra_info' => 'string|min:3|max:255|nullable',
        ], [
            'payment-all.required_if' => 'The payment field is required when the same payment question is answered is "Yes".',

            'musicians' => 'The number of musicians must be between 1 and 6',

            'musicians.*.instruments.required' => 'The instrument field is required.',
            'musicians.*.instruments.array' => 'The instrument field must be an array.',
            'musicians.*.instruments.min' => 'The instrument field must have at least :min items.',
            'musicians.*.instruments.max' => 'The instrument field may not have more than :max items.',
            'musicians.*.instruments.in' => 'The instrument field contains an invalid value.',

            'musicians.*.fill_status.string' => 'This field must be a string.',
            'musicians.*.fill_status.max' => 'This field may not have more than :max items',
            'musicians.*.musician_picked.string' => 'This field must be a string.',
            'musicians.*.musician_picked.max' => 'This field may not have more than :max items',

            'musicians.*.payment.required' => 'The payment field is required.',
            'musicians.*.payment.numeric' => 'The payment field must be a number.',
            'musicians.*.payment.min' => 'The payment field must be at least :min.',

            'musicians.*.extra_info.string' => 'The extra info field must be a string.',
            'musicians.*.extra_info.min' => 'The extra info field must be at least :min characters.',
            'musicians.*.extra_info.max' => 'The extra info field may not be greater than :max characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $gig->fill([
            'event_type' => $request->input('event_type'),
            'start_time' => $request->input('start_date_time'),
            'end_time' => $request->input('end_date_time'),
            'street_address' => $request->input('street_address'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip_code' => $request->input('zip_code'),
            'description' => $request->input('description'),
        ]);

        $gig->save();

        foreach ($request->input('musicians') as $key => $job) {
            // Delete Before Validation
            $status = $job['fill_status'] ?? $job['musician_picked'];
            if ($status == 'delete') {
                if (! isset($job['id'])) {
                    continue;
                }

                if (count($request->input('musicians')) <= 1) {
                    continue;
                }

                $jobToDelete = Job::find($job['id']);
                $jobToDelete->users()->detach();
                Job::destroy($jobToDelete->id);

                continue;
            }

            // Create for update Jobs
            $newJob = Job::updateOrCreate([
                'id' => $job['id'] ?? Job::next(),
            ], [
                'instruments' => json_encode($job['instruments']),
                'payment' => $job['payment'],
                'extra_info' => $job['extra_info'] ?? '',
                'gig_id' => $gig->id,
            ]);

            $newJob->save();

            if ($newJob->wasRecentlyCreated) {
                NewJobAvailableJob::dispatch($gig, $newJob);
            }

            // Fill in pivot Table
            if ($status == 'filled') {
                $newJob->users()->attach(1, ['status' => 'Booked']);
                if (! empty($job['userBookedID'])) {
                    $newJob->users()->updateExistingPivot($job['userBookedID'], ['status' => 'Applied']);
                }
            }

            if ($status == 'myself') {
                $newJob->users()->attach(Auth::id(), ['status' => 'Booked']);
                if (! empty($job['userBookedID'])) {
                    $newJob->users()->updateExistingPivot($job['userBookedID'], ['status' => 'Applied']);
                }
            }

            if ($status == 'unfilled' && ! empty($job['userBookedID'])) {
                if ($job['userBookedID'] == 1) {
                    $filledOutsideCRRVA = User::find(1);
                    $filledOutsideCRRVA->jobs()->detach($newJob->id);
                } elseif ($job['userBookedID'] == Auth::id()) {
                    $authUser = User::find(Auth::id());
                    $authUser->jobs()->detach($newJob->id);
                } else {
                    $newJob->users()->updateExistingPivot($job['userBookedID'], ['status' => 'Applied']);
                }
                //Send email that job is back open
            }

            if (is_numeric($status)) {
                $newJob->users()->updateExistingPivot($job['musician_picked'], ['status' => 'Booked']);
                if ($job['musician_picked'] != Auth::id()) {
                    ChosenForJobJob::dispatch($job['musician_picked'], $newJob);
                }
            }
        }

        return redirect()->back()->with('success', $gig->event_type.' Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gig $gig)
    {
        if (Auth::user()->admin != 1) {
            $this->authorize('update', $gig);
        }

        Job::where('gig_id', $gig->id)->each(function ($job) {
            $job->users()->detach();
            $job->delete();
        });

        $event_type = $gig->event_type;
        $gig->delete();

        return redirect()->route('musician-finder.dashboard')->with('success', $event_type.' Deleted Successfully.');
    }

    public function applyToJob(Job $job)
    {
        $this->authorize('apply-to-job', $job);
        $job->users()->attach(Auth::id(), ['status' => 'Applied']);

        FillJobRequestJob::dispatch(Auth::id(), $job);

        return redirect()->back()->with('success', 'You\'ve applied to the gig successfully');
    }

    public function applyToJobGet()
    {
        $job_id = request()->query('job');
        $job = Job::find($job_id);

        $user_id = request()->query('user');
        $user = User::find($user_id);

        if (! Gate::forUser($user)->allows('apply-to-job', $job)) {
            abort(403);
        }

        $job->users()->attach($user->id, ['status' => 'Applied']);

        FillJobRequestJob::dispatch($user_id, $job);

        $message = 'You\'ve applied to the gig successfully.';

        return redirect()->route('gigs.show', ['gig' => $job->gig->id])->with('success', $message);
    }

    public function bookJobGet()
    {
        $job_id = request()->query('job');
        $job = Job::find($job_id);

        $user_id = request()->query('user');
        $user = User::find($user_id);

        if ($job->gig->user->id != Auth::id() || Auth::user()->isAdmin()) {
            abort(403);
        }

        $job->users()->updateExistingPivot($user->id, ['status' => 'Booked']);
        if ($user->id != Auth::id()) {
            ChosenForJobJob::dispatch($user->id, $job);
        }

        $message = 'You\'ve booked '.$user->name.' for the gig successfully.';

        return redirect()->route('gigs.edit', ['gig' => $job->gig->id])->with('success', $message);
    }

    public function removeApp(Job $job)
    {
        $job->users()->detach(Auth::id());

        return redirect()->back()->with('success', 'You\'ve successfully removed your application.');
    }
}
