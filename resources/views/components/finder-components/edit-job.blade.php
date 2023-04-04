@props(['$job', '$musicianNumber', '$payment', '$allMusicians', '$key'])

@php
    $musicianNumber = $musicianNumber ?? $key;
    $jobId = $job['id'] ?? null;
    $isJobBooked = $job['isJobBooked'] ?? false;
    $userBookedName = $job['userBookedName'] ?? '';
    $userBookedID = $job['userBookedID'] ?? '';
    $numberOfJobApplicants = $job['numberOfJobApplicants'] ?? 0;
    $musicianPicked = $job['musician_picked'] ?? '';
    $fillStatus = $job['fill_status'] ?? 'booked';
    $jobInstruments = $job['instruments'] ?? [];
    $jobUsers = $job['users'] ?? json_encode([]);
    $extra_info = $job['extra_info'] ?? '';
    $payment = $job['payment'] ?? ($payment ?? '');
    $errors = $job['errors'] ?? [];
@endphp

<input type="hidden" name="musicians[{{ $musicianNumber }}][id]" value="{{ $jobId }}" />
<input type="hidden" name="musicians[{{ $musicianNumber }}][isJobBooked]" value="{{ $isJobBooked }}" />
<input type="hidden" name="musicians[{{ $musicianNumber }}][userBookedName]" value="{{ $userBookedName }}" />
<input type="hidden" name="musicians[{{ $musicianNumber }}][userBookedID]" value="{{ $userBookedID }}" />
<input type="hidden" name="musicians[{{ $musicianNumber }}][numberOfJobApplicants]" value="{{ $numberOfJobApplicants }}" />
<input type="hidden" name="musicians[{{ $musicianNumber }}][users]" value="{{ $jobUsers }}" />

<div class="overflow-hidden shadow sm:rounded-md more-job-template">
    <div class="bg-white px-4 py-5 sm:p-6">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2 lg:col-span-1">
                <label for="musician_name" class="block text-sm font-medium text-gray-700">
                    Musician #{{ isset($key) ? (int) $key + 1: (int) $musicianNumber + 1 }}
                </label>
                @if($isJobBooked)
                    <select data-number="{{ $musicianNumber }}" name="musicians[{{ $musicianNumber }}][fill_status]" class="@if(isset($errors['fill_status'])) border-red-500 @endif musician-name-with-specific-musicians booked-user mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option @if($fillStatus == 'booked') selected @endif value="booked">{{ $userBookedName }}</option>
                        <option disabled>---Other Options---</option>
                        <option @if($fillStatus == 'unfilled') selected @endif value="unfilled">Open Job Back Up</option>
                        @if ($userBookedName != 'Filled Outside CRRVA')
                            <option @if($fillStatus == 'filled') selected @endif value="filled">Booked Outside CRRVA</option>
                        @endif
                        @if ($userBookedName != Auth::id() && !Auth::user()->isAdmin())
                            <option @if($fillStatus == 'myself') selected @endif value="myself">Book Myself</option>
                        @endif
                        <option @if($fillStatus == 'choose') selected @endif value="choose">Select Specific Musician</option>
                        <option @if($fillStatus == 'delete') selected @endif value="delete">Remove Musician</option>
                    </select>
                @elseif($numberOfJobApplicants > 0)
                    <select data-number="{{ $musicianNumber }}" name="musicians[{{ $musicianNumber }}][musician_picked]" class="@if(isset($errors['musician_picked'])) border-red-500 @endif musician-name-with-specific-musicians mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option @if($musicianPicked == 'booked') selected @endif value="booked">Select an Applicant</option>
                        <option disabled>---Applicants---</option>
                            @foreach(json_decode($jobUsers, true) as $user)
                                <option @if($musicianPicked == $user['id']) selected @endif value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                            @endforeach
                        <option disabled>---Other Options---</option>
                        <option @if($musicianPicked == 'filled') selected @endif value="filled">Booked Outside CRRVA</option>
                        @if(!Auth::user()->isAdmin())
                            <option @if($musicianPicked == 'myself') selected @endif value="myself">Book Myself</option>
                        @endif
                        <option @if($musicianPicked == 'choose') selected @endif value="choose">Select Specific Musician</option>
                        <option @if($musicianPicked == 'delete') selected @endif value="delete">Remove Musician</option>
                    </select>
                @else
                    <select data-number="{{ $musicianNumber }}" name="musicians[{{ $musicianNumber }}][fill_status]" class="@if(isset($errors['fill_status'])) border-red-500 @endif musician-name-with-specific-musicians mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option @if($fillStatus == 'unfilled' || $fillStatus == 'booked' ) selected @endif value="unfilled">Need To Book</option>
                        <option disabled>---Other Options---</option>
                        <option @if($fillStatus == 'filled') selected @endif value="filled">Booked Outside CRRVA</option>
                        @if(!Auth::user()->isAdmin())
                            <option @if($fillStatus == 'myself') selected @endif value="myself">Book Myself</option>
                        @endif
                        <option @if($fillStatus == 'choose') selected @endif value="choose">Select Specific Musician</option>
                        <option @if($fillStatus == 'delete') selected @endif value="delete">Remove Musician</option>
                    </select>
                @endif
                @if($errors && (!empty(old('musicians.'.$musicianNumber.'.musician_select')) || $errors->has('musicians.'.$musicianNumber.'.musician_select')))
                    @include('components.finder-components.musician-select2', ['musicianNumber' => $musicianNumber, 'allMusicians' => $allMusicians])
                @endif
                @if(isset($errors['fill_status']))
                    <div class="alert text-red-500">{{ $errors['fill_status'] }}</div>
                @elseif(isset($errors['musician_picked']))
                    <div class="alert text-red-500">{{ $errors['musician_picked'] }}</div>
                @elseif(isset($errors['musician_select']))
                    <div class="alert text-red-500">{{ $errors['musician_picked'] }}</div>
                @endif
            </div>
            <div class="col-span-3 sm:col-span-2 lg:col-span-1">
                <label for="instrument" class="block text-sm font-medium text-gray-700">
                    Instrument(s)
                </label>
                <select id="{{ 'select'.$musicianNumber }}" name="musicians[{{ $musicianNumber }}][instruments][]" multiple="multiple" id="instrument" class="@if(isset($errors['instruments'])) input-validation-error @endif mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach(config('gigs.instruments') as $instrument)
                        <option value="{{ $instrument }}" @if(in_array($instrument, ($jobInstruments ?? []))) selected @endif>{{ $instrument }}</option>
                    @endforeach
                </select>
                @if(isset($errors['instruments']))
                    <div class="alert text-red-500">{{ $errors['instruments'] }}</div>
                @endif
            </div>
            <div class="col-span-3 sm:col-span-2 lg:col-span-1">
                <label for="payment-for-job" class="block text-sm font-medium text-gray-700">
                    Payment
                </label>
                <input id="payment-for-job" name="musicians[{{ $musicianNumber }}][payment]" value="{{ $payment }}" type="number" min="0" class="@if(isset($errors['payment'])) border-red-500 @endif mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @if(isset($errors['payment']))
                    <div class="alert text-red-500">{{ $errors['payment'] }}</div>
                @endif
            </div>
            <div class="col-span-6 lg:col-span-3">
                <label for="extra_info" class="block text-sm font-medium text-gray-700">Extra Details</label>
                <textarea id="extra_info" name="musicians[{{ $musicianNumber }}][extra_info]" class="@if(isset($errors['extra_info'])) border-red-500 @endif mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-[69px]">{{ $extra_info }}</textarea>
                @if(isset($errors['extra_info']))
                    <div class="alert text-red-500">{{ $errors['extra_info'] }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    var number = {{ $musicianNumber }};
        $('#select'+number).select2();
</script>