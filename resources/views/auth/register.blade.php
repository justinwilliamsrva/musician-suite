<x-guest-layout>
    <x-slot name="title">
            {{ 'Register' }}
    </x-slot>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name*')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email*')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            @if($errors->has('email'))
                <div class="alert mt-2 text-sm text-red-600 space-y-1">
                    {!! html_entity_decode($errors->first('email')) !!}
                </div>
            @endif
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
            <x-input-label for="can_book" :value="__('Would you like to allow users to invite you to a gig directly?')" />
                <div class="flex items-center">
                    <input @if(old('can_book')) checked @endif checked class="mr-1" type="radio" id="yes" name="can_book" value=1>
                    <label class="mr-3"for="yes">Yes</label>
                    <input @if(old('can_book')) checked @endif class="mr-1" type="radio" id="no" name="can_book" value=0>
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
</x-guest-layout>
<script>
    $('#select2').select2();
</script>