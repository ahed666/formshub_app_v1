<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/fav_icon/favicon.ico') }}">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans text-gray-900 antialiased">
            <div   style="margin:0px"  class="px-10 pt-6 justify-end flex">

                <div   class="items-center	 flex flex-warp  justify-end ">

                    <img style="width:25px;height:25px" src="/images/world.png" alt="" >

                    @if (App::isLocale('en'))
                        <a class=" mr-1  ml-1 text-lg text-black-600 hover:text-gray-900" href="">
                            {{ __('AR') }}
                        </a>

                    @elseif (App::isLocale('ar'))
                        <a class=" mr-1  ml-1 text-lg text-black-600 hover:text-gray-900" href="">
                            {{ __('EN') }}
                        </a>

                  @endif

            </div>
            </div>
            <div class="min-h-screen flex flex-col  justify-start items-center pt-6 sm:pt-0  ">

                <div>
                    <a href="/">
                        <img class="w-[140px] h-[60px] object-contain" viewbox="0 0 58 58" fill="none" src="{{asset('images/logo_1_transparent_dark.png')}}" alt="">
                    </a>
                </div>

                <div class="w-full 2xl:max-w-md mt-10 px-4 py-4 bg-primary  shadow-md overflow-hidden sm:rounded-lg">
                            @php
                                $types='{
                                    "payment_subscriptions":"Payment & Billing",
                                    "notifications":"Notifications",
                                    "security":"Security",
                                    "offers_events":"Offers & Events"

                                }';
                                $types=json_decode($types,true);
                            @endphp
                           @if($token==auth()->user()->unsubscribe_token.auth()->user()->id)
                           <p>{{ __('You might miss important information, and reminders!
                            Are you sure you want to stop receiving :type notifications?',['type' => $types[$type]]) }}</p>
                            <div class="flex justify-center  items-center">
                                @if(session('success'))
                                    <div class="alert alert-success text-valid">
                                       <p>{{ __('You have been unsubscribed successfully. You may choose to re-enable this type of notification at a later time from your profile settings.') }}</p>
                                    </div>
                                @elseif(session('failed'))
                                <div class="alert alert-success text-primary_red">
                                    <p>{{ __('may be error ,please try again.') }}</p>
                                 </div>
                                @else
                                <form method="POST" action="{{ route('confirm_unsubscribe',['type'=>$type,'token'=>$token,'userid'=>$userid]) }}">
                                    @csrf
                                    <button class="bg-secondary hover:bg-secondary_1 p-1 rounded-lg w-30 text-white  ">{{ __('Yes,I am sure') }}</button>

                                </form>

                                @endif

                            </div>
                           @else
                           <p class="text-primary_red">{{ __('You are not authorized for this action, please login to your account.')}}</p>
                           @endif

                </div>
            </div>
            @stack('scripts')





    </body>
</html>
