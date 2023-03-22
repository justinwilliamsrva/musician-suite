@php
    $oldMusicians = old('musicians', []);
@endphp
<x-app-layout>
    <x-slot name="title">
            {{ 'Create A Gig' }}
    </x-slot>

    <x-slot name="header">
        <div class="flex flex-col justify-center">
            <h2 class="font-semibold text-center text-3xl text-gray-800 leading-tight">
                {{ __('Create a Gig') }}
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
        <div class="mt-5 md:col-span-2 md:mt-0">
            <form action="{{ route('gigs.store') }}" method="POST" id="create-gig-form">
                @csrf
                <div class="flex flex-col space-y-4">
                    <h3 class="font-semibold text-center text-2xl text-gray-800 leading-tight">
                        {{ __('Gig Details') }}
                    </h3>
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="bg-white px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <!-- ROW 1 -->
                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="event_type" class="block text-sm font-medium text-gray-700">Event Type</label>
                                    <input type="text" value="{{ old('event_type') }}" name="event_type" id="event_type" class="@error('event_type') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('event_type')
                                        <div class="alert text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="start_date_time" class="block text-sm font-medium text-gray-700">
                                        Start Date/Time
                                    </label>
                                    <input type="datetime-local" name="start_date_time" id="start_date_time"
                                        value="{{ old('start_date_time') }}" class="@error('event_type') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('start_date_time')
                                        <div class="alert text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="end_date_time" class="block text-sm font-medium text-gray-700">
                                        End Date/Time
                                    </label>
                                    <input type="datetime-local" name="end_date_time" id="end_date_time"
                                        value="{{ old('end_date_time') }}" class="@error('end_date_time') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('end_date_time')
                                        <div class="alert text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- ROW 2 -->
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="street_address" class="block text-sm font-medium text-gray-700">Street address</label>
                                    <input value="{{ old('street_address') }}" type="text" name="street_address" id="street-address" class="@error('street_address') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('street_address')
                                        <div class="alert text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" name="city" id="city"
                                        value="{{ old('city') }}" class="@error('city') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('city')
                                        <div class="alert text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                                    <label for="region" class="block text-sm font-medium text-gray-700">State</label>
                                    <select name="state" id="state" class="@error('state') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @foreach(config('gigs.states') as $state)
                                            <option value="{{ $state }}" @if($state == old('state', 'Virginia')) selected @endif>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <div class="alert text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700">ZIP /
                                        Postal code</label>
                                    <input value="{{ old('zip_code') }}" type="text" name="zip_code" id="postal-code"
                                        class="@error('zip_code') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('zip_code')
                                        <div class="alert text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- ROW 3 -->
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Payment</label>
                                    <label class="block text-sm font-medium text-gray-700">Will all musicians receive the same payment?</label>
                                    <fieldset class="mt-2">
                                        <legend class="sr-only">Payment Question</legend>
                                        <div class="flex items-center space-y-0 space-x-5 sm:space-x-3 md:space-x-10">
                                            <div class="flex items-center">
                                                <input id="payment-method-yes" @if(old('payment-method') == 'same') checked @endif value="same" name="payment-method" type="radio" checked class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <label for="payment-method-yes" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="payment-method-no" @if(old('payment-method') == 'mixed') checked @endif value="mixed" name="payment-method" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <label for="payment-method-no" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                                            </div>
                                            <div class="flex items-center">
                                                <label for="payment-all" class="mr-1 block text-sm font-medium text-gray-700">Payment</label>
                                                <input id="payment-all" value="{{ old('payment-all') }}" name="payment-all" type="number" min="0" class="@error('payment-all') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            </div>
                                        </div>
                                        @error('payment-all')
                                            <div class="block alert text-red-500">{{ $message }}</div>
                                        @enderror
                                    </fieldset>
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Musicians</label>
                                    <label for="city" class="block text-sm font-medium text-gray-700">How many musicians do you need to book?</label>
                                    <fieldset class="mt-2">
                                        <legend class="sr-only">Musicians</legend>
                                        <div class="grid grid-cols-3 gap-3 sm:gap-1 md:gap-3 sm:grid-cols-6">
                                            <label class="{{ count($oldMusicians) == 1 || empty($oldMusicians) ? 'border-indigo-700' : '' }} musician-number-button hover:border-indigo-700 border-2 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="1" class="sr-only" aria-labelledby="musician-number-1-label">
                                                <span id="musician-number-1-label">1</span>
                                            </label>
                                            <label class="{{ count($oldMusicians) == 2 ? 'border-indigo-700' : '' }} musician-number-button hover:border-indigo-700 border-2 border-gray-300 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="2" class="sr-only" aria-labelledby="musician-number-2-label">
                                                <span id="musician-number-2-label">2</span>
                                            </label>
                                            <label class="{{ count($oldMusicians) == 3 ? 'border-indigo-700' : '' }} musician-number-button hover:border-indigo-700 border-2 border-gray-300 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="3" class="sr-only" aria-labelledby="musician-number-3-label">
                                                <span id="musician-number-3-label">3</span>
                                            </label>
                                            <label class="{{ count($oldMusicians) == 4 ? 'border-indigo-700' : '' }} musician-number-button hover:border-indigo-700 border-2 border-gray-300 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="4" class="sr-only" aria-labelledby="musician-number-4-label">
                                                <span id="musician-number-4-label">4</span>
                                            </label>
                                            <label class="{{ count($oldMusicians) == 5 ? 'border-indigo-700' : '' }} musician-number-button hover:border-indigo-700 border-2 border-gray-300 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="5" class="sr-only" aria-labelledby="musician-number-5-label">
                                                <span id="musician-number-5-label">5</span>
                                            </label>
                                            <label class="{{ count($oldMusicians) == 6 ? 'border-indigo-700' : '' }} musician-number-button hover:border-indigo-700 border-2 border-gray-300 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="6" class="sr-only" aria-labelledby="musician-number-6-label">
                                                <span id="musician-number-6-label">6</span>
                                            </label>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="description" name="description" class=" @error('description') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-[69px]">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="alert text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <h3 class="font-semibold text-center text-2xl text-gray-800 leading-tight">
                            {{ __('Musicians Needed') }}
                        </h3>
                        <div id="jobs-list" class="flex flex-col space-y-4">
                            @forelse ($oldMusicians as $musician)
                                @include('components.finder-components.new-job', ['musician' => $musician, 'musicianNumber' => $loop->iteration, 'errors' => $errors])
                            @empty
                                @include('components.finder-components.new-job', ['musicianNumber' => 1, 'payment' => '', 'errors' => []])
                            @endforelse
                        </div>
                    </div>
                    <div class="flex justify-between">
                    <button type="button" id="clear-create-gig-form" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Clear
                    </button>
                    <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Submit
                    </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
