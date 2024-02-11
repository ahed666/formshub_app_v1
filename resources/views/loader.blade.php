
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
<body class="font-sans antialiased">
    <div class="min-h-screen max-h-fit bg-gray-100 ">
       <div class="flex justify-center items-center h-screen min-h-screen text-2xl text-secondary_blue">
           {{ __('Loading..') }}
       </div>
    </div>









</body>

</html>
