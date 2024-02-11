<html>
    <head>

    </head>
    <body>


     </div>
            <x-guest-layout>



                <div id="error" class="mb-4 font-medium text-sm text-red-600 justify-center items-center flex">
                    @if($exp=="unvalidsignature")
                    <span>{{ __('This link has been expired') }}</span>
                    @elseif($exp=="unuthorized")
                    <span>{{ __('This link is not authorized') }}</span>
                    @endif
                </div>

               <div class="flex justify-center items-center" >
                 <a class="text-link" href="{{ route('login') }}">login</a>

               </div>



            </x-guest-layout>





@livewireScripts()
    </body>
</html>

