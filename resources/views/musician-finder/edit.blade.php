@php
    $oldMusicians = old('musicians', []);
    $numberOfMusicians = (count($oldMusicians) > 0) ? count($oldMusicians) : $gig->jobs->count();
    $jobsArray = (count($oldMusicians) > 0) ? $oldMusicians : $jobsArray;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-center">
            <h2 class="font-semibold text-center text-3xl text-gray-800 leading-tight">
                @if(Auth::user()->isAdmin() && Auth::id() != $gig->user_id)
                    {{ 'Update '.$gig->user->name.'\'s '.$gig->event_type }}
                @else
                    {{ 'Update Your '.$gig->event_type }}
                @endif
            </h2>
            <div class="mx-auto">
                <a href="{{ route('musician-finder.dashboard') }}">
                    <button type="button" class="max-w-fit mt-4 rounded-md bg-[#ff9100] py-1.5 pl-1 pr-2 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                        Back to Dashboard
                    </button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mt-5 md:col-span-2 md:mt-0">
            <form action="{{ route('gigs.update', ['gig' => $gig->id]) }}" method="POST" id="update-gig-form">
                @csrf
                @method('PUT')
                <div class="flex flex-col space-y-4">
                    <h3 class="font-semibold text-center text-2xl text-gray-800 leading-tight">
                        {{ __('Gig Details') }}
                    </h3>
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="bg-white px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <!-- ROW 1 -->
                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="event_type" class="block text-sm font-medium text-gray-700">
                                        Event Type
                                    </label>
                                    <input type="text" name="event_type" id="event_type" value="{{ old('event_type', $gig->event_type) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="start_date_time" class="block text-sm font-medium text-gray-700">
                                        Start Date/Time
                                    </label>
                                    <input type="datetime-local" name="start_date_time" id="start_date_time" autocomplete="given-name"
                                        value="{{ old('start_date_time', $gig->start_time) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="end_date_time" class="block text-sm font-medium text-gray-700">
                                        End Date/Time
                                    </label>
                                    <input type="datetime-local" name="end_date_time" id="end_date_time" autocomplete="given-name"
                                     value="{{ old('end_date_time', $gig->end_time) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <!-- ROW 2 -->
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="street_address" class="block text-sm font-medium text-gray-700">Street address</label>
                                    <input type="text" value="{{ old('street_address', $gig->street_address) }}" name="street_address" id="street-address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" name="city" id="city"
                                      value="{{ old('city', $gig->city) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                                    <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                                    <select name="state" id="state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @foreach(config('gigs.states') as $state)
                                                <option value="{{ $state }}" @if($state == old('state', $gig->state)) selected @endif>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700">ZIP /
                                        Postal code</label>
                                    <input type="text" name="zip_code" id="zip-code"
                                        value="{{ old('zip_code', $gig->zip_code) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <!-- ROW 3 -->
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Payment</label>
                                    <label class="block text-sm font-medium text-gray-700">Will all musicians receive the same payment?</label>
                                    <fieldset class="mt-2">
                                        <legend class="sr-only">Payment Question</legend>
                                        <div class="flex items-center space-y-0 space-x-10">
                                            <div class="flex items-center">
                                                <input {{ (old('payment-method') == 'same' || !str_contains($gig->getPaymentRange($gig), '-')) ? 'checked' : '' }} id="payment-method-yes" name="payment-method" value="same" type="radio" checked class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <label for="payment-method-yes" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input {{ old('payment-method') == 'mixed' || str_contains($gig->getPaymentRange($gig), '-') ? 'checked' : '' }} id="payment-method-no" name="payment-method" value="mixed" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <label for="payment-method-no" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                                            </div>
                                            <div class="flex items-center">
                                                <label for="payment-all" class="mr-1 block text-sm font-medium text-gray-700">Payment</label>
                                                <input id="payment-all" name="payment-all" value="{{ old('payment-all', (!str_contains($gig->getPaymentRange($gig), '-')) ? ltrim($gig->getPaymentRange($gig), '$') : '' )}}" type="number" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Musicians</label>
                                    <label for="city" class="block text-sm font-medium text-gray-700">How many musicians do you need to book?</label>
                                    <fieldset class="mt-2">
                                        <legend class="sr-only">Musicians</legend>
                                        <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                                            <label class="{{ ($numberOfMusicians == 1) ? 'border-indigo-700 musician-number-button cursor-pointer hover:border-indigo-700' : 'opacity-50' }} border-2 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 focus:outline-none">
                                                <input type="radio" @if ($numberOfMusicians == 1) name="musician-number" @endif value="1" class="sr-only" aria-labelledby="musician-number-1-label">
                                                <span id="musician-number-1-label">1</span>
                                            </label>
                                            <label class="{{ ($numberOfMusicians == 2) ? 'border-indigo-700' : '' }} {{ $numberOfMusicians <= 2 ? 'musician-number-button cursor-pointer hover:border-indigo-700' : 'opacity-50' }} border-2 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 focus:outline-none">
                                                <input type="radio" @if ($numberOfMusicians <= 2) name="musician-number" @endif value="2" class="sr-only" aria-labelledby="musician-number-2-label">
                                                <span id="musician-number-2-label">2</span>
                                            </label>
                                            <label class="{{ ($numberOfMusicians == 3) ? 'border-indigo-700' : '' }} {{ $numberOfMusicians <= 3 ? 'musician-number-button cursor-pointer hover:border-indigo-700' : 'opacity-50' }} border-2 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 focus:outline-none">
                                                <input type="radio" @if ($numberOfMusicians <= 3) name="musician-number" @endif value="3" class="sr-only" aria-labelledby="musician-number-3-label">
                                                <span id="musician-number-3-label">3</span>
                                            </label>
                                            <label class="{{ ($numberOfMusicians == 4) ? 'border-indigo-700' : '' }} {{ $numberOfMusicians <= 4 ? 'musician-number-button cursor-pointer hover:border-indigo-700' : 'opacity-50' }} border-2 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 focus:outline-none">
                                                <input type="radio" @if ($numberOfMusicians <= 4) name="musician-number" @endif value="4" class="sr-only" aria-labelledby="musician-number-4-label">
                                                <span id="musician-number-4-label">4</span>
                                            </label>
                                            <label class="{{ ($numberOfMusicians == 5) ? 'border-indigo-700' : '' }} {{ $numberOfMusicians <= 5 ? 'musician-number-button cursor-pointer hover:border-indigo-700' : 'opacity-50' }} border-2 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 focus:outline-none">
                                                <input type="radio" @if ($numberOfMusicians <= 5) name="musician-number" @endif value="5" class="sr-only" aria-labelledby="musician-number-5-label">
                                                <span id="musician-number-5-label">5</span>
                                            </label>
                                            <label class="{{ ($numberOfMusicians == 6) ? 'border-indigo-700' : '' }} hover:border-indigo-700 musician-number-button border-2 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="6" class="sr-only" aria-labelledby="musician-number-6-label">
                                                <span id="musician-number-6-label">6</span>
                                            </label>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="description" name="description"class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-[69px]">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <h3 class="font-semibold text-center text-2xl text-gray-800 leading-tight">
                            {{ __('Musicians Needed') }}
                        </h3>
                        @if(count($gig->bookedMusicians()) > 0)
                            <div class="mx-auto">
                                <a href="mailto:{{ implode(', ', $gig->bookedMusicians()) }}">
                                    <button type="button" class="max-w-fit rounded-md bg-indigo-600 py-1.5 pl-3 pr-4 text-center items-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4 mb-[2px]">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                            </svg>
                                        Email Booked Musicians
                                    </button>
                                </a>
                            </div>
                        @endif
                        <div id="jobs-list" class="flex flex-col space-y-4">
                            @each('components.finder-components.edit-job', $jobsArray, 'job')
                        </div>
                    </div>
                    <div class="flex justify-between">
                    <button type="button" id="delete-gig-button" class="inline-flex items-center rounded-md border border-gray-300 bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Delete Gig
                    </button>
                    <button type="submit" id="update-gig-button" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Save
                    </button>
                    </div>
                </div>
            </form>
            <form action="{{ route('gigs.destroy', ['gig' => $gig->id]) }}" id="delete-gig-form" method="POST">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</x-app-layout>