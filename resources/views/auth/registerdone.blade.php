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
    <body class="font-sans text-gray-900 antialiased">
                        <div    class="px-10 pt-6 justify-between flex">
                            <a href="/">
                                <div style="width:100%;height:100%">    <img class="w-48 h-24 object-fill" viewbox="0 0 58 58" fill="none" src="{{asset('images/logo_1_transparent_dark.png')}}" alt=""></div>
                            </a>
                            <x-locale/>

                    </div>

                    <div class="min-h-screen flex flex-col sm:justify-inherit items-center pt-6 sm:pt-0 bg-while">
                    <div  class="lg:w-4/5 md:w-4/5 sm:w-4/5 xl:w-3/5 mt-6 px-4 py-2 bg-white  overflow-hidden sm:rounded-lg">
                                <div class="container py-10 px-10 mx-0 min-w-full flex flex-col items-center">
                                    @if (session('error'))
                                    <div id="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                        <span class="font-bold">{{ __('Oops!') }}</span>
                                        <span>{{ __('Too many attempts,you can try again in:') }}</span> <span id="count" ></span>
                                    </div>
                                @endif
                                    <h1 class="mb-4 text-2xl">It's All Done:)</h1>
                                        <p class="mb-4 text-xl text-center">We have sent you a verification link to “

                                            <a class="font-medium text-blue-600 hover:underline " href="">{{ $user->email }}</a>

                                            ”, please access your email to verify your account
                                            </p>
                                            <p class="mb-4 text-lg"> Did not get the verification email?
                                                <form method="POST" action="{{ route('verification.send') }}">
                                                    @csrf

                                                    <div>
                                                        <button disabled type="submit" id="resend" class="disabled:opacity-50 text-blue-600 hover:underline  font-medium  ">
                                                            {{ __('Resend Verification Email') }}
                                                        </button>
                                                        <span id="count" class="text-red-600 font-extralight" ></span>
                                                    </div>
                                                </form>
                                                </p>
                                                @if (session('status') == 'verification-link-sent')
                                                <div class="mb-4 font-medium text-sm text-green-600">
                                                    {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                                                </div>
                                            @endif
                                </div>
                            <div class="container py-10 px-10 mx-0 min-w-full flex flex-col items-center">
                                <a href="{{ route('loginfromregister',$user->id) }}" class=" text-center lg:w-2/5 md:w-full items-center px-4 py-2 bg-btn border border-transparent
                                        rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none
                                    focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ">
                                            {{ __('login') }}
                                </a>
                            </div>
                    </div>

                    </div>

                    @livewireScripts()
    <script>

// for disable resend button for 2 minutes
var btn = document.getElementById("resend");
var spn = document.getElementById("count");
var count = 120;     // Set count
var timer = null;  // For referencing the timer

(function countDown(){
       // Display counter and start counting down
       spn.textContent = count;

  // Run the function again every second if the count is not zero
  if(count !== 0){
    timer = setTimeout(countDown, 1000);
    count--; // decrease the timer
  } else {
    // Enable the button
    btn.removeAttribute("disabled");
    spn.textContent ="";

  }
}());
        </script>
    @if(Session::has('error'))
         <script>
            var div=document.getElementById("error");
            var count = {{ Session::get('error') }};
        var spn = document.getElementById("count");
            // Set count
        var timer = null;  // For referencing the timer

        (function countDown(){
            var m = Math.floor(count/60);
        var s = count - m * 60;
        var mDisplay = m > 0 ? (m < 10 ? "0" + m  : m ) : "00";
        var sDisplay = s > 0 ? (s < 10 ? "0" + s : s) : "00";
               // Display counter and start counting down

               spn.textContent =
               mDisplay+":"+sDisplay
               ;

          // Run the function again every second if the count is not zero
          if(count !== 0){
            timer = setTimeout(countDown, 1000);
             // decrease the timer
          } else {
            // Enable the button
            div.classList.add("hidden");
            spn.textContent ="";

          }
        }());
        </script>
        @endif
{{-- we can uncommnet this script to enable block user of use the inspect --}}

{{-- <script>
    document.addEventListener('contextmenu', event=> event.preventDefault());
    document.onkeydown = function(e) {
    if(event.keyCode == 123) {
    return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
    return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
    return false;
    }
    if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
    return false;
    }
    }
    </script> --}}
    </body>
</html>
