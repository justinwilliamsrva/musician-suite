<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-center">
            <h2 class="font-semibold text-center text-3xl text-gray-800 leading-tight">
                {{ $gig->event_type.' by '.$gig->user->name }}
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
                <div class="flex flex-col space-y-4">
                    <h3 class="font-semibold text-center text-2xl text-gray-800 leading-tight">
                        {{ __('Gig Details') }}
                    </h3>
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="bg-white px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <!-- ROW 1 -->
                                <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                                    <label for="event_type" class="block text-sm font-medium text-gray-700">
                                        Event Type
                                    </label>
                                    <!-- <input readonly value type="text"  id="event_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"> -->
                                    <p>{{ $gig->event_type }}</p>
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="start_date_time" class="block text-sm font-medium text-gray-700">
                                        Date/Time
                                    </label>
                                   <p>{!! date_format($gig->start_time, 'D, m/d/y g:i a').$gig->getEndTime($gig) !!}</p>
                                </div>
                                <div class="col-span-6 lg:col-span-3">
                                    <label for="end_date_time" class="block text-sm font-medium text-gray-700">
                                        Address
                                    </label>
                                    <a href="{{ $gig->getGoogleMapsLink($gig) }}" target="_blank" class="underline text-blue-500">
                                        <p>{{ $gig->street_address.', '. $gig->city.', '.$gig->state.' '.$gig->zip_code }}</p>
                                    </a>
                                </div>
                                <!-- ROW 2 -->
                                <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">Payment</label>
                                    <p>{{ $gig->getPaymentRange($gig) }}</p>

                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Musicians</label>
                                    <fieldset class="mt-2">
                                        <legend class="sr-only">Musicians</legend>
                                        <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                                            <label class="{{ count($gig->jobs) == 1 ? 'border-blue-500' : '' }} border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 focus:outline-none">
                                                <input disabled type="radio" value="1" class="sr-only" aria-labelledby="musician-number-1-label">
                                                <span id="musician-number-1-label">1</span>
                                            </label>
                                            <label class="{{ count($gig->jobs) == 2 ? 'border-blue-500' : '' }} border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 focus:outline-none">
                                                <input disabled type="radio" value="2" class="sr-only" aria-labelledby="musician-number-2-label">
                                                <span id="musician-number-2-label">2</span>
                                            </label>
                                            <label class="{{ count($gig->jobs) == 3 ? 'border-blue-500' : '' }} border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 focus:outline-none">
                                                <input disabled type="radio" value="3" class="sr-only" aria-labelledby="musician-number-3-label">
                                                <span id="musician-number-3-label">3</span>
                                            </label>
                                            <label class="{{ count($gig->jobs) == 4 ? 'border-blue-500' : '' }} border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 focus:outline-none">
                                                <input disabled type="radio" value="4" class="sr-only" aria-labelledby="musician-number-4-label">
                                                <span id="musician-number-4-label">4</span>
                                            </label>
                                            <label class="{{ count($gig->jobs) == 5 ? 'border-blue-500' : '' }} border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 focus:outline-none">
                                                <input disabled type="radio" value="5" class="sr-only" aria-labelledby="musician-number-5-label">
                                                <span id="musician-number-5-label">5</span>
                                            </label>
                                            <label class="{{ count($gig->jobs) == 6 ? 'border-blue-500' : '' }} border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 focus:outline-none">
                                                <input disabled type="radio" value="6" class="sr-only" aria-labelledby="musician-number-6-label">
                                                <span id="musician-number-6-label">6</span>
                                            </label>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-span-6 sm:col-span-6 lg:col-span-3">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea readonly id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-[69px]">{{ is_null($gig->description) ? 'No Description' : $gig->description }}</textarea>
                                </div>
                                <!-- ROW 4 -->
                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="event_type" class="block text-sm font-medium text-gray-700">
                                        Host's Name
                                    </label>
                                    <input readonly type="text" value="{{ $gig->user->name }}" id="event_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="start_date_time" class="block text-sm font-medium text-gray-700">
                                        Host's Email
                                    </label>
                                    <input readonly type="text" value="{{ $gig->user->email }}" id="start_date_time" autocomplete="given-name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="end_date_time" class="block text-sm font-medium text-gray-700">
                                        Host's Phone
                                    </label>
                                    <input readonly type="text" value="{{ $gig->user->phone_number }}"id="end_date_time" autocomplete="given-name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="jobs-list" class="flex flex-col space-y-4">
                        <h3 class="font-semibold text-center text-2xl text-gray-800 leading-tight">
                            {{ __('Musicians') }}
                        </h3>
                        <div id="jobs-list" class="flex flex-col space-y-4">
                            @foreach($gig->jobs as $job)
                                @include('components.finder-components.show-job', ['job' => $job, 'user' => $user, 'musicianNumber' => ($loop->index +1)])
                            @endforeach
                        </div>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>