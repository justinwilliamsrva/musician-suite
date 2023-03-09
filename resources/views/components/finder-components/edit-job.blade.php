@props(['$job'])

@php
    $musicianNumber = $key + 1;
    $jobId = $job->id ?? null;
    $oldInstruments = old('instruments', []);
@endphp


<div class="overflow-hidden shadow sm:rounded-md more-job-template">
    <div class="bg-white px-4 py-5 sm:p-6">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2 lg:col-span-1">
                <input type="hidden" name="musicians[{{ $musicianNumber }}][id]" value="{{ $jobId }}" />
                <label for="musician_name" class="block text-sm font-medium text-gray-700">
                    Musician #{{ $musicianNumber }}
                </label>
                @if($job->jobHasBeenBooked($job))
                    <p>{{ $job->users()->select(['users.*'])->wherePivot('status', 'Booked')->first()->name }}</p>
                @elseif($job->users()->count() > 0)
                    <select name="musicians[{{ $musicianNumber }}][musician_picked]" id="musician_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="" selected>Select a Musician</option>
                        @foreach($job->users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                        <option value="filled">--Filled Outside CRRVA--</option>
                        <option value="delete">--Delete Job--</option>
                    </select>
                @else
                <select name="musicians[{{ $musicianNumber }}][fill_status]" id="musician_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="unfilled">Need To Book</option>
                    <option value="filled">Already Booked</option>
                    <option value="delete">Delete Job</option>
                </select>
                @endif
            </div>
            <div class="col-span-3 sm:col-span-2 lg:col-span-1">
                <label for="instrument" class="block text-sm font-medium text-gray-700">
                    Instrument(s)
                </label>
                <select id="{{ 'select'.$musicianNumber }}" name="musicians[{{ $musicianNumber }}][instruments][]" multiple="multiple" id="instrument" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach(config('gigs.instruments') as $instrument)
                        <option value="{{ $instrument }}" @if(in_array($instrument, json_decode($job->instruments)) || in_array($instrument, $oldInstruments)) selected @endif>{{ $instrument }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-3 sm:col-span-2 lg:col-span-1">
                <label for="payment-for-job" class="block text-sm font-medium text-gray-700">
                    Payment
                </label>
                <input id="payment-for-job" name="musicians[{{ $musicianNumber }}][payment]" value="{{ $job->payment }}" type="number" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div class="col-span-6 lg:col-span-3">
                <label for="extra_info" class="block text-sm font-medium text-gray-700">Extra Details</label>
                <input type="text" value="{{ $job->extra_info }}" name="musicians[{{ $musicianNumber }}][extra_info]" id="extra_info" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>
    </div>
</div>
<script>
    var number = {{ $musicianNumber }};
        $('#select'+number).select2();
</script>