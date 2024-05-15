{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <link rel="stylesheet" type="text/css" href="styles/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="styles/owl.theme.default.min.css">
    @stack('styles')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>
</html> --}}
<!DOCTYPE  html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Forms Hub') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/fav_icon/favicon.ico') }}">    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('styles/index.min.css')}}" />
    <link href="{{ asset('https://fonts.googleapis.com/icon?family=Material+Icons')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css')}}">
    <link rel="stylesheet" href="{{ asset('https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap')}}">
    <link rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap')}}">

    {{-- <link
        rel="stylesheet"
        href="{{ asset('https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css')}}" /> --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('styles/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/owl.theme.default.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/loading.css')}}">
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .text-red{
            color:bisque;
        }
    </style>
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body  class="{{ App::getLocale()=="ar"?"font-cairo":"font-sans" }}  antialiased">
    <div class="min-h-screen max-h-fit bg-gray-100 ">

        <div class=" flex xs:grid   xs:gap-0 md:gap-0 sm:gap-0">
            <div class="z-[100]  w-[12%] xs:w-[100%]  lg:mr-2 xl:mr-2 sm:mb-2 md:row-span-2 ">
                @include('layouts.navigation')
            </div>
            @if($accountActive)
            <div class="w-[88%] xs:w-[100%]  pt-2 pl-[14px] pr-[14px] pb-2  xs:px-1   ">
                {{ $slot }}
            </div>
            @elseif(!$accountActive&&(Route::currentRouteName() === 'support'||Route::currentRouteName() === 'profile.destroy'||Route::currentRouteName() === 'profile.update'||Route::currentRouteName() === 'profile.edit'))
            <div class="w-[88%] xs:w-[100%]   pt-2 pl-[14px] pr-[14px] pb-2  xs:px-0   ">
                {{ $slot }}
            </div>
            @else
            <div class="w-[88%] xs:w-[100%]  h-full   p-14  xs:px-0   ">
            <div class="grid justify-center items-center text-center ">
                <h1 >{{ __('This account has been suspended.') }}</h1>
                <h1>{{ __('This may be due to overdue payment or a violation of acceptable use terms. If you believe your account should not be suspended, please create a support ticket') }}<a href="{{ route('support') }}" class="text-secondary_blue hover:no-underline hover:cursor-pointer ml-1">{{ __('here') }}</a></h1>
            </div>
            </div>
            @endif
        </div>

    </div>

    @livewireScripts()
    <script type="text/javascript">
        function dropdown() {
            document.querySelector("#submenu").classList.toggle("hidden");
            document.querySelector("#arrow").classList.toggle("rotate-0");
        }
        dropdown();

        function openSidebar() {
            document.querySelector(".sidebar").classList.toggle("hidden");
        }

    </script>

    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>

    <link href="{{ asset('https://fonts.googleapis.com/icon?family=Material+Icons')}}" rel="stylesheet">
    <script src="{{ asset('js/Chart.min.js')}}"></script>
    <script src="{{ asset('js/cropper.min.js')}}"></script>
    <script src="{{ asset('js/index.min.js') }}"></script>
    <script src="{{ asset('js/flowbite.min.js')}}"></script>

    <script src="{{ asset('js/sort-list.js')}}"></script>




    <script>
        $('.owl-dashboard').owlCarousel({
            loop: false
            , margin: 10
            , nav: true
            , responsiveClass: true,
            // navText: ["<div class=''><</div>", "<div class=''>></div>"],

            responsive: {
                0: {
                    items: 1
                }
                , 600: {
                    items: 2
                }
                , 1000: {
                    items: 2
                }
                , 1800: {
                    items: 3
                }
            }
        })
        $('.owl-form').owlCarousel({
            loop: false,

            margin: 10
            , nav: false
            , responsiveClass: true,
            // navText: ["<div class=''><</div>", "<div class=''>></div>"],

            responsive: {
                0: {
                    items: 2
                }
                , 600: {
                    items: 2
                }
                , 1000: {
                    items: 3
                }
                , 1800: {
                    items: 3
                }
            }
        })

    </script>



    {{-- menubar for each form in owl carousel  --}}



    @stack('scripts')
    @stack('modals')
</body>

</html>
