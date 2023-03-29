<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <body class="font-sans antialiased bg-[#212121]">
        <div class="min-h-screen bg-gray-100 flex flex-col overflow-y-auto">
            <div class="flex-1 pb-4">
                <!-- Navigation -->
                @include('layouts.navigation')

                <!-- Flash Message -->
                <div class="pt-3 pb-6">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        @if(session('success'))
                            <div id="flash-message" class="flex justify-center">
                                <div class="min-w-[250px] bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-center" role="alert">
                                    <strong class="font-bold">{{  session('success')  }}</strong>
                                </div>
                            </div>
                        @endif
                        @if(session('warning'))
                            <div id="flash-message" class="flex justify-center">
                                <div class="min-w-[250px] bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded text-center" role="alert">
                                    <strong class="font-bold">{{  session('warning')  }}</strong>
                                </div>
                            </div>
                        @endif
                        @if($errors->any())
                            <div id="flash-message" class="flex justify-center">
                                <div class="min-w-[250px] bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-center" role="alert">
                                    <strong class="font-bold">Invalid Information Entered</strong>
                                </div>
                            </div>
                        @endif
                        <!-- Header -->
                        @if (isset($header))
                            <div class="overflow-hidden">
                                <div class="p-6 text-gray-900">
                                    {{ $header }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>

            <!-- footer -->
            @include('layouts.footer')
        </div>
    </body>
    <script>
        $('#flash-message').delay(5000).slideUp(300);
    </script>

</html>
