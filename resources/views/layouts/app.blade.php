<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-white flex flex-col overflow-y-auto">
            <div class="flex-1 pb-4">
                <!-- Navigation -->
                @include('layouts.navigation')
                <!-- Header -->
                @if (isset($header))
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <div class="p-6 text-gray-900">
                                    {{ $header }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>

            <!-- footer -->
            @include('layouts.footer')
        </div>
    </body>
</html>
