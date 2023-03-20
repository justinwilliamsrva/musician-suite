@props(['$job', 'musicianNumber', '$payment'])

@php
    $job = $job ?? [
        'isJobBooked' => false,
        'userBookedName' => '',
        'userBookedID' => '',
        'numberOfJobApplicants' => 0,
        'users' => json_encode([]),
        'instruments' => [],
        'extra_info' => '',
        'fill_status' => '',
    ];
    $musicianNumber = $musicianNumber ?? $key;
    $jobId = $job['id'] ?? null;
    $musicianPicked = $job['musician_picked'] ?? '';
    $fillStatus = $job['fill_status'] ?? 'booked';
@endphp

<input type="hidden" name="musicians[{{ $musicianNumber }}][id]" value="{{ $jobId }}" />
<input type="hidden" name="musicians[{{ $musicianNumber }}][isJobBooked]" value="{{ $job['isJobBooked'] }}" />
<input type="hidden" name="musicians[{{ $musicianNumber }}][userBookedName]" value="{{ $job['userBookedName'] }}" />
<input type="hidden" name="musicians[{{ $musicianNumber }}][userBookedID]" value="{{ $job['userBookedID'] }}" />
<input type="hidden" name="musicians[{{ $musicianNumber }}][numberOfJobApplicants]" value="{{ $job['numberOfJobApplicants'] }}" />
<input type="hidden" name="musicians[{{ $musicianNumber }}][users]" value="{{ $job['users'] }}" />

<div class="overflow-hidden shadow sm:rounded-md more-job-template">
    <div class="bg-white px-4 py-5 sm:p-6">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2 lg:col-span-1">
                <label for="musician_name" class="block text-sm font-medium text-gray-700">
                    Musician #{{ isset($key) ? $key + 1: $musicianNumber + 1 }}
                </label>
                @if($job['isJobBooked'])
                    <p>{{ $job['userBookedName'] }}</p>
                    <select name="musicians[{{ $musicianNumber }}][fill_status]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option @if($fillStatus == 'booked') selected @endif value="booked">Keep Booked Musician</option>
                        <option disabled>----------------</option>
                        <option @if($fillStatus == 'unfilled') selected @endif value="unfilled">Open Job Back Up</option>
                        @if ($job['userBookedName'] != 'Filled Outside CRRVA')
                            <option @if($fillStatus == 'filled') selected @endif value="filled">Booked Outside CRRVA</option>
                        @endif
                        @if ($job['userBookedName'] != Auth::id())
                            <option @if($fillStatus == 'myself') selected @endif value="myself">Book Myself</option>
                        @endif
                        <option @if($fillStatus == 'delete') selected @endif value="delete">Delete Job</option>
                    </select>
                @elseif($job['numberOfJobApplicants'] > 0)
                    <select name="musicians[{{ $musicianNumber }}][musician_picked]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option @if($musicianPicked == 'booked') selected @endif value="booked">Select a Applicant</option>
                        <optgroup label="Applicants">
                            @foreach(json_decode($job['users'], true) as $user)
                                <option @if($musicianPicked == $user['id']) selected @endif value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Other Options">
                            <option @if($musicianPicked == 'filled') selected @endif value="filled">Booked Outside CRRVA</option>
                            <option @if($musicianPicked == 'myself') selected @endif value="myself">Book Myself</option>
                            <option @if($musicianPicked == 'delete') selected @endif value="delete">Delete Job</option>
                        </optgroup>
                    </select>
                @else
                    <select name="musicians[{{ $musicianNumber }}][fill_status]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option @if($fillStatus == 'unfilled' || $fillStatus == 'booked' ) selected @endif value="unfilled">Need To Book</option>
                        <option @if($fillStatus == 'filled') selected @endif value="filled">Booked Outside CRRVA</option>
                        <option @if($fillStatus == 'myself') selected @endif value="myself">Book Myself</option>
                        <option @if($fillStatus == 'delete') selected @endif value="delete">Delete Job</option>
                    </select>
                @endif
            </div>
            <div class="col-span-3 sm:col-span-2 lg:col-span-1">
                <label for="instrument" class="block text-sm font-medium text-gray-700">
                    Instrument(s)
                </label>
                <select id="{{ 'select'.$musicianNumber }}" name="musicians[{{ $musicianNumber }}][instruments][]" multiple="multiple" id="instrument" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach(config('gigs.instruments') as $instrument)
                        <option value="{{ $instrument }}" @if(in_array($instrument, ($job['instruments'] ?? []))) selected @endif>{{ $instrument }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-3 sm:col-span-2 lg:col-span-1">
                <label for="payment-for-job" class="block text-sm font-medium text-gray-700">
                    Payment
                </label>
                <input id="payment-for-job" name="musicians[{{ $musicianNumber }}][payment]" value="{{ $job['payment'] ?? ($payment ?? '') }}" type="number" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div class="col-span-6 lg:col-span-3">
                <label for="extra_info" class="block text-sm font-medium text-gray-700">Extra Details</label>
                <input type="text" value="{{ $job['extra_info'] }}" name="musicians[{{ $musicianNumber }}][extra_info]" id="extra_info" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>
    </div>
</div>
<script>
    var number = {{ $musicianNumber }};
        $('#select'+number).select2();
</script>