@props(['$musicianNumber', '$payment', '$musician', '$errors', '$allMusicians'])

@php
    $instrumentErrors = !is_array($errors) && $errors->has('musicians.'.$musicianNumber.'.instruments');
@endphp

<div class="overflow-hidden shadow sm:rounded-md more-job-template">
    <div class="bg-white px-4 py-5 sm:p-6">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2 lg:col-span-1">
                <label for="musician_name" class="block text-sm font-medium text-gray-700">
                    Musician #{{ $musicianNumber }}
                </label>
                <select data-number="{{ $musicianNumber }}" name="musicians[{{ $musicianNumber }}][fill_status]" id="musician_name" class="@if(!is_array($errors) && $errors->has('musicians.'.$musicianNumber.'.fill_status')) border-red-500 @endif musician-name-with-specific-musicians mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option @if(old("musicians.$musicianNumber.fill_status") == 'unfilled') selected @endif value="unfilled">Need To Book</option>
                    <option @if(old("musicians.$musicianNumber.fill_status") == 'filled') selected @endif value="filled">Booked Outside CRRVA</option>
                    <option @if(old("musicians.$musicianNumber.fill_status") == 'myself') selected @endif value="myself">Book Myself</option>
                    <option @if(old("musicians.$musicianNumber.fill_status") == 'choose') selected @endif value="choose">Book Specific Musician</option>
                </select>
                @if(!is_array($errors) && $errors->has('musicians.'.$musicianNumber.'.fill_status'))
                    <div class="alert text-red-500">
                    {{ $errors->first('musicians.'.$musicianNumber.'.fill_status') }}
                    </div>
                @endif
                @if($errors && (!empty(old('musicians.'.$musicianNumber.'.musician_select')) || $errors->has('musicians.'.$musicianNumber.'.musician_select')))
                    @include('components.finder-components.musician-select2', ['musicianNumber' => $musicianNumber, 'allMusicians' => $allMusicians])
                @endif
                @if(!is_array($errors) && $errors->has('musicians.'.$musicianNumber.'.musician_select'))
                    <div class="alert text-red-500">
                        {{ $errors->first('musicians.'.$musicianNumber.'.musician_select') }}
                    </div>
                @endif
            </div>
            <div class="col-span-3 sm:col-span-2 lg:col-span-1">
                <label for="instrument" class="block text-sm font-medium text-gray-700">
                    Instrument(s)
                </label>
                <select id="{{ 'select'.$musicianNumber }}" name="musicians[{{ $musicianNumber }}][instruments][]" multiple="multiple" id="instrument" class="@if(!is_array($errors) && $errors->has('musicians.'.$musicianNumber.'.instruments')) input-validation-error @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach(config('gigs.instruments') as $instrument)
                        <option value="{{ $instrument }}" @if(in_array($instrument, old("musicians.$musicianNumber.instruments", []))) selected @endif>{{ $instrument }}</option>
                    @endforeach
                </select>
                @if(!is_array($errors) && $errors->has('musicians.'.$musicianNumber.'.instruments'))
                    <div class="alert text-red-500">
                    {{ $errors->first('musicians.'.$musicianNumber.'.instruments') }}
                    </div>
                @endif
            </div>
            <div class="col-span-3 sm:col-span-2 lg:col-span-1">
                <label for="payment" class="block text-sm font-medium text-gray-700">
                    Payment
                </label>
                <input id="payment-for-job" value="{{ old("musicians.$musicianNumber.payment") ?? ($payment ?? '') }}" name="musicians[{{ $musicianNumber }}][payment]" type="number" min="0" class="@if(!is_array($errors) && $errors->has('musicians.'.$musicianNumber.'.payment')) border-red-500 @endif mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @if(!is_array($errors) && $errors->has('musicians.'.$musicianNumber.'.payment'))
                    <div class="alert text-red-500">
                    {{ $errors->first('musicians.'.$musicianNumber.'.payment') }}
                    </div>
                @endif
            </div>
            <div class="col-span-6 lg:col-span-3">
                <label for="extra_info" class="block text-sm font-medium text-gray-700">Extra Details</label>
                <input type="text" name="musicians[{{ $musicianNumber }}][extra_info]" value="{{ old("musicians.$musicianNumber.extra_info") }}" id="extra_info" class="@if(!is_array($errors) && $errors->has('musicians.'.$musicianNumber.'.extra_info')) border-red-500 @endif mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @if(!is_array($errors) && $errors->has('musicians.'.$musicianNumber.'.extra_info'))
                    <div class="alert text-red-500">
                    {{ $errors->first('musicians.'.$musicianNumber.'.extra_info') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    var number = {{ $musicianNumber }};
    $('#select'+number).select2();
</script>
