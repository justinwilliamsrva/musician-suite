<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">


        <title>{{ isset($title) ? $title.' - Classical Connection RVA' : 'Classical Connection RVA' }}</title>

        <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;400&display=swap" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="mb-3">
                @if(session('success'))
                    <div id="flash-message" class="flex justify-center">
                        <div class="min-w-[250px] bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-center" role="alert">
                            <strong class="font-bold">{{  session('success')  }}</strong>
                        </div>
                    </div>
                @endif
                @if(session('warning'))
                    <div id="warning-message" class="flex justify-center">
                        <div class="min-w-[250px] bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded text-center" role="alert">
                            <strong class="font-bold">{{  session('warning')  }}</strong>
                        </div>
                    </div>
                @endif
            </div>
            <div class="text-3xl text-[#7B7C7C] cursor-default">
                <h1 class="font-oswald font-extralight">CLASSICAL<span class="text-[#F26D5C] font-normal">CONNECTION</span>RVA</h1>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
