<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-center text-3xl text-gray-800 leading-tight">
            {{ __('Musician Suite Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 items-start gap-y-16 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 lg:gap-x-8">
            <a href="{{ route('musician-finder.dashboard') }}" class="flex flex-col-reverse sm:hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="mt-6 px-2 sm:px-0">
                    <h3 class="text-sm font-medium text-gray-900">Musician Finder</h3>
                    <p class="mt-2 text-sm text-gray-500">Book, Manage, and Accept Gigs for your preferred instrument</p>
                </div>
                <div class="relative aspect-w-1 aspect-h-1 overflow-hidden rounded-lg bg-gray-100">
                    <img src="https://images.pexels.com/photos/7097455/pexels-photo-7097455.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Green cardstock box containing white, beige, and brown cards." class="object-cover object-center">
                </div>
            </a>
            <a class="flex flex-col-reverse transition-all duration-300">
                <div class="mt-6 px-2 sm:px-0">
                    <h3 class="text-sm font-medium text-gray-900">Private Teacher Database</h3>
                    <p class="mt-2 text-sm text-gray-500">View and search for current private teachers in Central Virginia</p>
                </div>
                <div class="relative aspect-w-1 aspect-h-1 overflow-hidden rounded-lg bg-gray-100">
                    <img src="https://images.pexels.com/photos/7521177/pexels-photo-7521177.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Green cardstock box open with 50 cards inside." class="object-cover object-center">
                    <div class="absolute inset-0 bg-black opacity-70 transition-opacity"></div>
                    <p class="text-center absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white px-4 py-2 rounded-lg shadow-lg text-gray-800 font-bold opacity-100 transition-all duration-300">Coming Soon</p>
                </div>
            </a>
            <a class="flex flex-col-reverse transition-all duration-300">
                <div class="mt-6 px-2 sm:px-0">
                    <h3 class="text-sm font-medium text-gray-900">Job Openings</h3>
                    <p class="mt-2 text-sm text-gray-500">View performance and teaching job openings for churches, schools, music shops, theatres etc.</p>
                </div>
                <div class="relative aspect-w-1 aspect-h-1 overflow-hidden rounded-lg bg-gray-100">
                    <img src="https://images.unsplash.com/photo-1515527658517-0a52764f2fdf?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="Detail of white today card, beige next card, and brown someday card with dot grid." class="object-cover object-center">
                    <div class="absolute inset-0 bg-black opacity-70 transition-opacity"></div>
                    <p class="text-center absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white px-4 py-2 rounded-lg shadow-lg text-gray-800 font-bold opacity-100 transition-all duration-300">Coming Soon</p>
                </div>
            </a>
            <a class="flex flex-col-reverse transition-all duration-300">
                <div class="mt-6 px-2 sm:px-0">
                    <h3 class="text-sm font-medium text-gray-900">Local Music Organization Database</h3>
                    <p class="mt-2 text-sm text-gray-500">List and discover local chamber groups and ensembles</p>
                </div>
                <div class="relative aspect-w-1 aspect-h-1 overflow-hidden rounded-lg bg-gray-100">
                    <img src="https://images.unsplash.com/photo-1519412666065-94acb3f8838f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="Stack of three green cardstock boxes with 3 hole cutouts showing cards inside." class="object-cover object-center">
                    <div class="absolute inset-0 bg-black opacity-70 transition-opacity"></div>
                    <p class="text-center absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white px-4 py-2 rounded-lg shadow-lg text-gray-800 font-bold opacity-100 transition-all duration-300">Coming Soon</p>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
