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
            <!-- ALl Open Gigs -->
            <div class="px-6 lg:px-8 pb-6 lg:pb-0 col-span-1 lg:row-span-2">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">Open Gigs</h1>
                        <p class="mt-2 text-sm text-gray-700">List of all available jobs for every instrument including their date, location, instrument, and payment.</p>
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
                                    <tr>
                                        <td class="max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 @lg:w-auto @lg:max-w-none @lg:pl-0 align-top">
                                            Wedding
                                            <dl class="font-normal @2xl:hidden">
                                                <dt class="sr-only">Instrument(s)</dt>
                                                <dd class="mt-1 text-gray-700">Violin, Viola</dd>
                                                <dt class="sr-only @lg:hidden">Payment</dt>
                                                <dd class="mt-1 text-gray-500">$300</dd>
                                            </dl>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            01/17/14 7:30pm - <br/> 01/17/14 12:00pm
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            1234 Main Street <br/> Jacksonville, VA 12345
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">Violin, Viola</td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">$300</td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            Unconfirmed
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 @lg:w-auto @lg:max-w-none @lg:pl-0 align-top">
                                            Wedding
                                            <dl class="font-normal @2xl:hidden">
                                                <dt class="sr-only">Instrument(s)</dt>
                                                <dd class="mt-1 text-gray-700">Violin, Viola</dd>
                                                <dt class="sr-only @lg:hidden">Payment</dt>
                                                <dd class="mt-1 text-gray-500">$300</dd>
                                            </dl>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            01/17/14 7:30pm - <br/> 01/17/14 12:00pm
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            1234 Main Street <br/> Jacksonville, VA 12345
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">Violin, Viola</td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">$300</td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            Unconfirmed
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
             <!-- All Gigs You Are Performing In -->
             <div class="px-6 lg:px-8 col-span-1 lg:row-span-1 border-t-2 border-[#212121] lg:border-0 pt-6 lg:pt-0 pb-6">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">Your Performances</h1>
                        <p class="mt-2 text-sm text-gray-700">List of upcoming performances whether confirmed or pending. Click VIEW ALL to also see all previous performances.</p>
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
                                    <tr>
                                        <td class="max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 @lg:w-auto @lg:max-w-none @lg:pl-0 align-top">
                                            Wedding
                                            <dl class="font-normal @2xl:hidden">
                                                <dt class="sr-only">Instrument(s)</dt>
                                                <dd class="mt-1 text-gray-700">Violin, Viola</dd>
                                                <dt class="sr-only @lg:hidden">Payment</dt>
                                                <dd class="mt-1 text-gray-500">$300</dd>
                                            </dl>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            01/17/14 7:30pm - <br/> 01/17/14 12:00pm
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            1234 Main Street <br/> Jacksonville, VA 12345
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">Violin, Viola</td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">$300</td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            Unconfirmed
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 @lg:w-auto @lg:max-w-none @lg:pl-0 align-top">
                                            Wedding
                                            <dl class="font-normal @2xl:hidden">
                                                <dt class="sr-only">Instrument(s)</dt>
                                                <dd class="mt-1 text-gray-700">Violin, Viola</dd>
                                                <dt class="sr-only @lg:hidden">Payment</dt>
                                                <dd class="mt-1 text-gray-500">$300</dd>
                                            </dl>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            01/17/14 7:30pm - <br/> 01/17/14 12:00pm
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            1234 Main Street <br/> Jacksonville, VA 12345
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">Violin, Viola</td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">$300</td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            Unconfirmed
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
             <!-- All Gigs You Are Hosting -->
             <div class="px-6 lg:px-8 col-span-1 lg:row-span-1 border-t-2 border-[#212121] pt-6">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">Your Gigs</h1>
                        <p class="mt-2 text-sm text-gray-700">List of upcoming gigs you are hosting and how many jobs are still open. Click EDIT to update or delete gig and Click VIEW ALL to see previous gigs.</p>
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
                                    <tr>
                                        <td class="max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 @lg:w-auto @lg:max-w-none @lg:pl-0 align-top">
                                            Wedding
                                            <dl class="font-normal @2xl:hidden">
                                                <dt class="sr-only">Instrument(s)</dt>
                                                <dd class="mt-1 text-gray-700">Violin, Viola</dd>
                                                <dt class="sr-only @lg:hidden">Payment</dt>
                                                <dd class="mt-1 text-gray-500">$300</dd>
                                            </dl>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            01/17/14 7:30pm - <br/> 01/17/14 12:00pm
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            1234 Main Street <br/> Jacksonville, VA 12345
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">Violin, Viola</td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">$300</td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            Unconfirmed
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 @lg:w-auto @lg:max-w-none @lg:pl-0 align-top">
                                            Wedding
                                            <dl class="font-normal @2xl:hidden">
                                                <dt class="sr-only">Instrument(s)</dt>
                                                <dd class="mt-1 text-gray-700">Violin, Viola</dd>
                                                <dt class="sr-only @lg:hidden">Payment</dt>
                                                <dd class="mt-1 text-gray-500">$300</dd>
                                            </dl>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            01/17/14 7:30pm - <br/> 01/17/14 12:00pm
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            1234 Main Street <br/> Jacksonville, VA 12345
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">Violin, Viola</td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 @2xl:table-cell align-top">$300</td>
                                        <td class="px-3 py-4 text-sm text-gray-500 align-top">
                                            Unconfirmed
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
