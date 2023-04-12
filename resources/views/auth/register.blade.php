<x-guest-layout>
    <x-slot name="title">
            {{ 'Register' }}
    </x-slot>
    @php
        $emailVerified = old('emailVerified') ?? $emailVerified;
    @endphp

    @if(!$emailVerified)
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h2 class="text-xl text-center">Register Email Address</h2>
            <input type="hidden" value="register-email" name="task" />
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email*')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                @if($errors->has('email') && !str_contains($errors->first('email'), 'The selected email is invalid'))
                    <div class="alert mt-2 text-sm text-red-600 space-y-1">
                       {{  $errors->first('email') }}
                    </div>
                @elseif($errors->has('email'))
                    <div class="alert mt-2 text-sm text-red-600 space-y-1">
                        This email could not be found in CRRVA's database. Please try registering with a different email address or complete the 'Add New Email Request' below to add your email address to the database.
                    </div>
                @endif
            </div>

            <div class="flex items-start justify-between mt-5">
                <div>
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                    <a class="block underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="mailto:info@classicalconnectionrva.com?subject=Need help registering for Classical Connection RVA">
                        {{ __('Having trouble registering?') }}
                    </a>
                </div>
                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
        @if(str_contains($errors->first('email'), 'The selected email is invalid'))
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" value="send-to-CCRVA" name="task" />
                <hr class="mt-8"/>
                <div class="mt-4">
                    <h2 class="text-xl text-center">Add New Email Request</h2>

                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Email*')" />
                        <p class='text-sm'>{{ old('email') }}</p>
                        <input type="hidden" value="{{ old('email') }}" name="email" />
                        @if($errors->has('email') && !str_contains($errors->first('email'), 'The selected email is invalid'))
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        @endif
                    </div>

                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Name*')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="recent_performance" :value="__('Input a Classical Revolution RVA event you performed for recently.*')" />
                        <x-text-input id="recent_performance" placeholder='ex: Performed violin for Incarnation in May 2022' class="block mt-1 w-full text-sm" type="text" name="recent_performance" :value="old('recent_performance')" required />
                        <x-input-error :messages="$errors->get('recent_performance')" class="mt-2" />
                    </div>
                    <div class="flex justify-end">
                        <button id="emailCCRVAbutton" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Send
                        </button>
                    </div>
                </div>
            </form>
        @endif
    @elseif($emailVerified)
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="hidden" value="store" name="task" />
            <input type="hidden" value=true name="emailVerified" />


            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name*')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="First and Last Name" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email*')" />
                <p class='text-sm'>{{ $email ?? old('email') }}</p>
                <input type="hidden" value="{{ $email ?? old('email')}}" name="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password*')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password*')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <hr class="mt-6"/>

            <!-- Phone Number -->
            <div class="mt-4">
                <x-input-label for="phone_number" :value="__('Phone Number')" />
                <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')"/>
                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            </div>


            <!-- Instruments -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Instruments You Play Professionally*')" />

                <select id="select2" name="instruments[]" multiple="multiple" id="instrument" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach(config('gigs.instruments') as $instrument)
                        <option @if(in_array($instrument, (old('instruments') ?? []))) selected @endif value="{{ $instrument }}">{{ $instrument }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('instruments')" class="mt-2" />
            </div>

            <!-- Can Book -->
            <div class="mt-4">
                <x-input-label for="can_book" :value="__('Would you like to allow users to select you for gigs directly?')" />
                    <div class="flex items-center">
                        <input @if(old('can_book') == 1) checked @endif checked class="mr-1" type="radio" id="yes" name="can_book" value=1>
                        <label class="mr-3"for="yes">Yes</label>
                        <input @if(!is_null(old('can_book')) && old('can_book') == 0) checked @endif class="mr-1" type="radio" id="no" name="can_book" value=0>
                        <label for="no">No</label>
                    </div>
                <x-input-error class="mt-2" :messages="$errors->get('can_book')" />
            </div>

            <div class="flex items-start justify-between mt-5">
                <div>
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                    <a class="block underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="mailto:info@classicalconnectionrva.com?subject=Need help registering for Classical Connection RVA">
                        {{ __('Having trouble registering?') }}
                    </a>
                </div>
                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    @endif
</x-guest-layout>
<script>
    $('#select2').select2();
</script>