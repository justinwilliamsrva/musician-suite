<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-center">
            <h2 class="font-semibold text-center text-3xl text-gray-800 leading-tight">
                {{ __('Musician Finder') }}
            </h2>
            <div class="mx-auto">
                <a href="{{ route('gigs.create') }}">
                    <button type="button" class="max-w-fit mt-4 rounded-md bg-[#ff9100] py-1.5 pl-1 pr-2 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        Create A Gig
                    </button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 lg:divide-x-2 lg:divide-[#212121]">
            <!-- All Open Gigs -->
            <div id="openJobs" class="order-2 lg:order-1 px-6 lg:px-8 pt-8 lg:pt-0 col-span-1 ">
                <div class="sm:flex sm:items-center min-h-[80px]">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">Open Gigs</h1>
                        <p class="mt-2 text-sm text-gray-700">List of all open and pending jobs for every instrument.</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <button type="button" class="block rounded-md bg-indigo-600 py-1.5 px-3 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View Your Instrument(s)</button>
                    </div>
                </div>
                <div class="mt-8 flow-root @container">
                    <div class="-my-2 -mx-6 overflow-x-auto @2xl:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle @lg:px-6 @2xl:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 @lg:pl-0 ">Event</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date/Time</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Location</th>
                                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 @2xl:table-cell">Instrument(s)</th>
                                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 @2xl:table-cell">Payment</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($openJobs as $job)
                                        <tr>
                                            <td class="max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 @lg:w-auto @lg:max-w-none @lg:pl-0 align-top">
                                                @can('update', $job->gig)
                                                    <a href="{{ route('gigs.edit', $job->gig->id) }}" class="underline text-blue-500">{{ $job->gig->event_type }}</a>
                                                @else
                                                    <a href="{{ route('gigs.show', $job->gig->id) }}" class="underline text-blue-500">{{ $job->gig->event_type }}</a>
                                                @endcan
                                                <dl class="font-normal @2xl:hidden">
                                                    <dt class="sr-only">Instrument(s)</dt>
                                                    <dd class="mt-1 text-gray-700">{{ implode(', ', json_decode($job->instruments)) }}</dd>
                                                    <dt class="sr-only @lg:hidden">Payment</dt>
                                                    <dd class="mt-1 text-gray-500">{{ ($job->payment > 0) ? '$'.$job->payment : 'Volunteer' }}</dd>
                                                </dl>
                                            </td>
                                            <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                                {!! date_format($job->gig->start_time, 'D, m/d/y g:i a').$job->gig->getEndTime($job->gig) !!}
                                            </td>
                                            <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                                {{ $job->gig->street_address }} <br/> {{ $job->gig->city }}, {{ $job->gig->state }} {{ $job->gig->zip_code }}
                                            </td>
                                            <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">{{ implode(', ', json_decode($job->instruments)) }}</td>
                                            <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">{{ ($job->payment > 0) ? '$'.$job->payment : 'Volunteer' }}</td>
                                            <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                                {{ (count($job->users) > 0) ? 'Pending' : 'Open' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $openJobs->appends(['userGigs' => $userGigs->currentPage(), 'userJobs' => $userJobs->currentPage()])->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2 col-span-1">
                 <!-- All Jobs You Are Performing In -->
                 <div id="userJob" class="px-6 lg:px-8 col-span-1 pb-6">
                    <div class="sm:flex sm:items-center min-h-[80px]">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">Your Performances</h1>
                            <p class="mt-2 text-sm text-gray-700">List of your upcoming performances whether booked or pending.</p>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <button type="button" class="block rounded-md bg-indigo-600 py-1.5 px-3 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View All</button>
                        </div>
                    </div>
                    <div class="mt-8 flow-root @container">
                        <div class="-my-2 -mx-6 overflow-x-auto @2xl:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle @lg:px-6 @2xl:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 @lg:pl-0 ">Event</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date/Time</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Location</th>
                                            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 @2xl:table-cell">Instrument(s)</th>
                                            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 @2xl:table-cell">Payment</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach($userJobs as $job)
                                            <tr>
                                                <td class="max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 @lg:w-auto @lg:max-w-none @lg:pl-0 align-top">
                                                    @can('update', $job->gig)
                                                        <a href="{{ route('gigs.edit', $job->gig->id) }}" class="underline text-blue-500">{{ $job->gig->event_type }}</a>
                                                    @else
                                                        <a href="{{ route('gigs.show', $job->gig->id) }}" class="underline text-blue-500">{{ $job->gig->event_type }}</a>
                                                    @endcan
                                                    <dl class="font-normal @2xl:hidden">
                                                        <dt class="sr-only">Instrument(s)</dt>
                                                        <dd class="mt-1 text-gray-700">{{ implode(', ', json_decode($job->instruments)) }}</dd>
                                                        <dt class="sr-only @lg:hidden">Payment</dt>
                                                        <dd class="mt-1 text-gray-500">{{ ($job->payment > 0) ? '$'.$job->payment : 'Volunteer' }}</dd>
                                                    </dl>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                                    {!! date_format($job->gig->start_time, 'D, m/d/y g:i a').$job->gig->getEndTime($job->gig) !!}
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                                    {{ $job->gig->street_address }} <br/> {{ $job->gig->city }}, {{ $job->gig->state }} {{ $job->gig->zip_code }}
                                                </td>
                                                <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">{{ implode(', ', json_decode($job->instruments)) }}</td>
                                                <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">{{ ($job->payment > 0) ? '$'.$job->payment : 'Volunteer' }}</td>
                                                <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                                    {{ ($job->users->first()->pivot->status == 'Applied') ? 'Pending' : 'Booked' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $userJobs->appends(['userGigs' => $userGigs->currentPage(), 'openJobs' => $openJobs->currentPage()])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- All Gigs You Are Hosting -->
                 <div id="userGigs" class="px-6 lg:px-8 col-span-1 border-y-2 lg:border-b-0 pb-6 lg:pb-0 border-[#212121] pt-8">
                    <div class="sm:flex sm:items-center min-h-[80px]">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">Your Gigs</h1>
                            <p class="mt-2 text-sm text-gray-700">List of upcoming gigs you have created and how many jobs have been filled.</p>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <button type="button" class="block rounded-md bg-indigo-600 py-1.5 px-3 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View All</button>
                        </div>
                    </div>
                    <div class="mt-8 flow-root @container">
                        <div class="-my-2 -mx-6 overflow-x-auto @2xl:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle @lg:px-6 @2xl:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 @lg:pl-0 ">Event</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date/Time</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Location</th>
                                            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 @2xl:table-cell">Instrument(s)</th>
                                            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 @2xl:table-cell">Payment</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach($userGigs as $gig)
                                            <tr>
                                                <td class="max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 @lg:w-auto @lg:max-w-none @lg:pl-0 align-top">
                                                    <a href="{{ route('gigs.edit', $gig->id) }}" class="underline text-blue-500">{{ $gig->event_type }}</a>
                                                    <dl class="font-normal @2xl:hidden">
                                                        <dt class="sr-only">Status</dt>
                                                        <dd class="mt-1 text-gray-700">{{ $gig->getAllInstruments($gig) }}</dd>
                                                        <dt class="sr-only @lg:hidden">Payment</dt>
                                                        <dd class="mt-1 text-gray-500">{{ $gig->getPaymentRange($gig) }}</dd>
                                                    </dl>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                                {!! date_format($gig->start_time, 'D, m/d/y g:i a').$gig->getEndTime($gig) !!}
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                                    {{ $gig->street_address }} <br/> {{ $gig->city }}, {{ $gig->state }} {{ $gig->zip_code }}
                                                </td>
                                                <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">{{ $gig->getAllInstruments($gig) }}</td>
                                                <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">{{ $gig->getPaymentRange($gig) }}</td>
                                                <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                                    {{ $gig->numberOfFilledJobs().' Jobs Filled' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $userGigs->appends(['userJobs' => $userJobs->currentPage(), 'openJobs' => $openJobs->currentPage()])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
