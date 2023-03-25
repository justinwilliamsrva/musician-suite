<x-app-layout>
    <x-slot name="title">
            {{ $gig->event_type.' by '.$gig->user->name }}
    </x-slot>

    <x-slot name="header">
        <div class="flex flex-col justify-center">
            <h2 class="font-semibold text-center text-3xl text-gray-800 leading-tight">
                {{ $gig->event_type.' by '.$gig->user->name }}
            </h2>
            <div class="mx-auto">
                <a href="{{ route('musician-finder.dashboard') }}">
                    <button type="button" class="max-w-fit mt-4 rounded-md bg-[#ff9100] py-2 pl-3 pr-4 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
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
                    <div class="flex flex-col justify-center">
                        <h3 class="font-semibold text-center text-2xl text-gray-800 leading-tight">
                            {{ __('Gig Details') }}
                        </h3>
                        @if(Auth::user()->isAdmin())
                            <div class="mx-auto">
                                <a href="{{ route('gigs.edit', $gig->id) }}">
                                    <button type="button" class="max-w-fit mt-4 rounded-md bg-indigo-600 py-1.5 pl-3 pr-4 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                        Edit Gig
                                    </button>
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="bg-white px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <!-- ROW 1 -->
                                <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                                    <label for="event_type" class="block text-sm font-medium text-gray-700">
                                        Event Type
                                    </label>
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
                                    <label for="name" class="block text-sm font-medium text-gray-700">
                                        Host's Name
                                    </label>
                                    <p>{{ $gig->user->name }}</p>
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700">
                                        Host's Email
                                    </label>
                                    <a href="mailto:{{ $gig->user->email }}" class="underline text-blue-500">{{ $gig->user->email }}</a>
                                </div>
                                <div class="col-span-6 sm:col-span-6 lg:col-span-3">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <p>{{ empty($gig->description) ? 'No Description' : $gig->description }}</p>
                                </div>
                                <!-- ROW 4 -->

                            </div>
                        </div>
                    </div>
                    <div id="jobs-list" class="flex flex-col space-y-4">
                        <h3 class="font-semibold text-center text-2xl text-gray-800 leading-tight">
                            {{ 'Musicians('.$gig->jobs->count().')' }}
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