<html>
    <head>

    </head>
    <body>


     </div>
            <x-guest-layout>

                {{-- <x-slot name="logo">
                    <x-jet-authentication-card-logo />
                </x-slot> --}}

                <div class="mb-4 text-sm text-gray-600">
                    {{ __('auth.verfiyemail_title') }}

                    <h1 class="text-secondary mt-1">{{ __('auth.verfiyemail_note1') }}</h1>
                    <h1 class="mt-1">{{ __('auth.questionifnotreciveemail') }}</h1>

                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ __('auth.emailverifysendsuccessfully') }}
                    </div>
                @elseif (session('error'))
                <div id="error" class="mb-4 font-medium text-sm text-red-600">
                    <span>{{ __('auth.tryagain') }}</span> <span id="count" ></span>
                </div>
                @endif


                <div class="mt-4 flex items-center justify-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <div>
                            <x-jet-button type="submit">
                                {{ __('auth.resendemail') }}
                            </x-jet-button>
                        </div>
                    </form>

                    <div>
                        <a
                            href="{{ route('profile.show') }}"
                            class="underline text-sm text-gray-600 hover:text-gray-900"
                        >
                            {{ __('auth.changeemail') }}</a>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf

                            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 ml-2">
                                {{ __('main.logout') }}
                            </button>
                        </form>
                    </div>
                </div>

            </x-guest-layout>





@if(Session::has('error'))
    <script>

        var btn = document.getElementById("login");
        var div=document.getElementById("error");

        var count = {{ Session::get('error') }};
         var spn = document.getElementById("count");
        // Set count
        var timer = null;  // For referencing the timer
       // spn.textContent=count;
        (function countDown(){
        var m = Math.floor(count/60);
        var s = count - m * 60;
        var mDisplay = m > 0 ? (m < 10 ? "0" + m  : m ) : "00";
        var sDisplay = s > 0 ? (s < 10 ? "0" + s : s) : "00";
        // Display counter and start counting down

        spn.textContent = mDisplay+" m "+sDisplay+" s";

        // Run the function again every second if the count is not zero
        if(count !== 0){
            btn.setAttribute("disabled","");
            timer = setTimeout(countDown, 1000);
            // decrease the timer
        } else {
            // Enable the button
            div.classList.add("hidden");
            btn.removeAttribute("disabled");
            spn.textContent ="";

        }
        }());
</script>
@endif
@livewireScripts()
    </body>
</html>

