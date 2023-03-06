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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-white flex flex-col overflow-y-auto">
            <div class="flex-1 pb-4">
                <!-- Navigation -->
                @include('layouts.navigation')
                <!-- Flash Message -->
                    @if(session('success'))
                        <div id="flash-message" class="absolute top-20 left-0 right-0 flex justify-center mt-4">
                            <div class="min-w-[250px] bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-center" role="alert">
                                <strong class="font-bold">{{ session('success') }}</strong>
                            </div>
                        </div>
                    @endif
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
    <script>
        setTimeout(function() {
            $('#flash-message').fadeOut('fast');
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>

</html>
