@props(['$job, $musicianNumber, $user'])

<div class="overflow-hidden border-t-2 shadow sm:rounded-md more-job-template">
    <div class="bg-white px-4 py-5 sm:p-6">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-3 sm:col-span-2 lg:col-span-1 text-center lg:text-left order-1">
                <label for="musician_name" class="block text-sm font-medium text-gray-700">
                    Musician #{{ $musicianNumber }}
                </label>
                @if($job->jobHasBeenBooked($job))
                    <p>{{ $job->users()->select(['users.*'])->wherePivot('status', 'Booked')->first()->name }}</p>
                @elseif($job->users->contains(Auth::user()))
                    <form id="remove-application-form" action="{{ route('removeApp', ['job' => $job->id]) }}" method="POST">
                        @csrf
                        <button type="button" id="remove-application-button" class="max-w-fit rounded-md bg-red-500 py-1.5 px-4 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Remove Application
                        </button>
                    </form>
                @else
                    @can('apply-to-job', $job)
                        <form action="{{ route('applyToJob', ['job' => $job->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="max-w-fit rounded-md bg-green-500 py-1.5 px-4 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Apply to Job
                            </button>
                        </form>
                    @else
                        @if($job->users->count() > 0)
                            <p>Pending</p>
                        @else
                            <p>Open</p>
                        @endif
                    @endcan
                @endif
            </div>
            <div class="col-span-6 sm:col-span-2 lg:col-span-1 text-center lg:text-left order-3 sm:order-2">
                <label for="instrument" class="block text-sm font-medium text-gray-700">
                    Instrument(s)
                </label>
                <p>{{ implode(', ', json_decode($job->instruments)) }}</p>
            </div>
            <div class="col-span-3 sm:col-span-2 lg:col-span-1 text-center lg:text-left order-2 sm:order-3">
                <label for="payment" class="block text-sm font-medium text-gray-700">
                    Payment
                </label>
                <p>{{ ($job->payment > 0) ? '$'.$job->payment : 'Volunteer' }}</p>
            </div>
            <div class="col-span-6 lg:col-span-3 text-center lg:text-left order-4">
                <label for="extra_info" class="block text-sm font-medium text-gray-700">Extra Details</label>
                <p>{{ empty($gig->extra_info) ? 'None' : $gig->extra_info }}</p>

            </div>
        </div>
    </div>
</div>