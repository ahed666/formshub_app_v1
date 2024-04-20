<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('Forms Hub') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/fav_icon/favicon.ico') }}">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div   style="margin:0px"  class="px-10 pt-6 justify-end flex">
            <x-locale/>
        </div>
        <div class="min-h-max flex flex-col  justify-start items-center pt-6 sm:pt-0  ">

            <div>

                    <img class="w-[140px] h-[60px] object-contain" viewbox="0 0 58 58" fill="none" src="{{asset('images/logos/app_logo.png')}}" alt="">

            </div>

            <div class=" xl:max-w-md lg:max-w-md 2xl:max-w-md w-full mt-10 px-4 py-4 bg-primary  shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
