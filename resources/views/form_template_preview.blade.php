<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('styles/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{ asset('styles/keyboard.css') }}" />
        <link rel="stylesheet" href="{{ asset('styles/score.css') }}" />
        <link rel="stylesheet" href="https://cdn.korzh.com/metroui/v4/css/metro-icons.min.css">
        <link rel="stylesheet" href="{{ asset('styles/datepicker.css') }}">
        {{-- <link rel="stylesheet" href="https://cdn.korzh.com/metroui/v4/css/metro-all.min.css"> --}}
        {{-- <link rel="stylesheet" href="https://cdn.korzh.com/metroui/v4/css/metro.min.css"> --}}

        <link rel="stylesheet" type="text/css" href="{{ asset('styles/jquery.signature.css') }} ">


        @stack('styles')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>

        <div style="overflow:hidden">
            @switch($form_type_id)
                @case(1)
                @livewire('forms.previews.previewtemplate-form-questions',["id"=>$id])

                    @break
                @case(2)
                @livewire('forms.previews.previewtemplate-form-media',["id"=>$id])

                    @break
                @default

            @endswitch
        </div>






@livewireScripts()

<script src="{{ asset('js/jquery.min.js')}}" ></script>
<link type="text/css" href="{{ asset('styles/jquery-ui.css')}}" rel="stylesheet">
<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('js/owl.carousel.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<script  src="{{ asset('js/keyboard.js') }}"></script>
<script  src="{{ asset('js/libphonenumber-max.js') }}"></script>
<script  src="{{ asset('js/metro.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/jquery.signature.js') }}"  ></script>

<script>module={};</script>
<script type="module" >
 import {getCountries} from "/../js/countries.js";
 module.getCountries=getCountries;
 console.log(module);
</script>
@stack('scripts')
    </body>
</html>
