@props(['$job, $musicianNumber, $user'])

<div class="overflow-hidden border-t-2 shadow sm:rounded-md more-job-template">
    <div class="bg-white px-4 py-5 sm:p-6">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2 lg:col-span-1">
                <label for="musician_name" class="block text-sm font-medium text-gray-700">
                    Musician #{{ $musicianNumber }}
                </label>
                @if($job->jobHasBeenBooked($job))
                    <p>{{ $job->users()->select(['users.*'])->wherePivot('status', 'Booked')->first()->name }}</p>
                @elseif($job->users->contains(Auth::user()))
                    <p>Applied</p>
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
            <div class="col-span-6 sm:col-span-2 lg:col-span-1">
                <label for="instrument" class="block text-sm font-medium text-gray-700">
                    Instrument(s)
                </label>
                <input readonly value="{{ implode(', ', json_decode($job->instruments)) }}" id="payment-all" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div class="col-span-6 sm:col-span-2 lg:col-span-1">
                <label for="payment" class="block text-sm font-medium text-gray-700">
                    Payment
                </label>
                <input readonly value="{{ ($job->payment > 0) ? '$'.$job->payment : 'Volunteer' }}" id="payment-all" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div class="col-span-6 lg:col-span-3">
                <label for="extra_details" class="block text-sm font-medium text-gray-700">Extra Details</label>
                <input type="text" readonly value="{{ $job->extra_info }}" name="extra_details" id="extra_details" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>
    </div>
</div>