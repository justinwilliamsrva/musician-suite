<x-app-layout>

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                                    <input type="text" name="event_type" id="event_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="start_date_time" class="block text-sm font-medium text-gray-700">
                                        Start Date/Time
                                    </label>
                                    <input type="datetime-local" name="start_date_time" id="start_date_time" autocomplete="given-name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="end_date_time" class="block text-sm font-medium text-gray-700">
                                        End Date/Time
                                    </label>
                                    <input type="datetime-local" name="end_date_time" id="end_date_time" autocomplete="given-name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <!-- ROW 2 -->
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="street-address" class="block text-sm font-medium text-gray-700">Street address</label>
                                    <input type="text" name="street-address" id="street-address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" name="city" id="city" autocomplete="address-level2"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                                    <label for="region" class="block text-sm font-medium text-gray-700">State</label>
                                    <select name="musician_name" id="musician_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @foreach(config('gigs.states') as $state)
                                            <option value="{{ $state }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                                    <label for="postal-code" class="block text-sm font-medium text-gray-700">ZIP /
                                        Postal code</label>
                                    <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <!-- ROW 3 -->
                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Payment</label>
                                    <label class="block text-sm font-medium text-gray-700">Will all musicians receive the same payment?</label>
                                    <fieldset class="mt-2">
                                        <legend class="sr-only">Payment Question</legend>
                                        <div class="flex items-center space-y-0 space-x-10">
                                            <div class="flex items-center">
                                                <input id="payment-method-yes" value="same" name="payment-method" type="radio" checked class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <label for="payment-method-yes" class="ml-3 block text-sm font-medium text-gray-700">Yes</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="payment-method-no" value="mixed" name="payment-method" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <label for="payment-method-no" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                                            </div>
                                            <div class="flex items-center">
                                                <label for="payment-all" class="mr-1 block text-sm font-medium text-gray-700">Payment</label>
                                                <input id="payment-all" name="payment-all" type="number" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
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
                                            <label class="border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="1" class="sr-only" aria-labelledby="musician-number-1-label">
                                                <span id="musician-number-1-label">1</span>
                                            </label>
                                            <label class="border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="2" class="sr-only" aria-labelledby="musician-number-2-label">
                                                <span id="musician-number-2-label">2</span>
                                            </label>
                                            <label class="border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="3" class="sr-only" aria-labelledby="musician-number-3-label">
                                                <span id="musician-number-3-label">3</span>
                                            </label>
                                            <label class="border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="4" class="sr-only" aria-labelledby="musician-number-4-label">
                                                <span id="musician-number-4-label">4</span>
                                            </label>
                                            <label class="border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="5" class="sr-only" aria-labelledby="musician-number-5-label">
                                                <span id="musician-number-5-label">5</span>
                                            </label>
                                            <label class="border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                                                <input type="radio" name="musician-number" value="6" class="sr-only" aria-labelledby="musician-number-6-label">
                                                <span id="musician-number-6-label">6</span>
                                            </label>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-[69px]" ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="jobs-list" class="flex flex-col space-y-4">
                        <h3 class="font-semibold text-center text-2xl text-gray-800 leading-tight">
                            {{ __('Musicians Needed') }}
                        </h3>
                        <div id="jobs-list" class="flex flex-col space-y-4">
                            @include('components.finder-components.new-job', ['musicianNumber' => 1])
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select",
            allowClear: true,
        });
    });
</script>
</x-app-layout>
