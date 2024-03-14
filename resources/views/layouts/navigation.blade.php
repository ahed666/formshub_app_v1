@push('styles')

  <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .text-red{
            color:bisque;
        }
    </style>

@endpush
{{-- border-b border-gray-100 --}}
<nav x-data="{ open: false }" class="p-4  xs:bg-white    items-center   ">

    <div class="flex justify-between " >
        <span
        class="ml-2 mt-2   flex w-16 h-12 text-white text-4xl top-5 left-5 cursor-pointer"
        onclick="openSidebar()">
            <svg class=" bg-secondary_blue rounded-md"  fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
            </svg>

        </span>
        <a  class=" md:hidden lg:hidden 2xl:hidden " href="{{ route('dashboard') }}">
            <img class="block w-[140px] h-[60px] object-contain text-gray-800 " viewbox="0 0 58 58" fill="none" src="{{asset('images/logos/app_logo_nav.png')}}" alt="">

              </a>

    </div>

    <div class="sidebar  fixed z-[100] top-0 bottom-0 left-0 p-2   w-[12%] lg:w-[20%] md:w-[25%] sm:w-[50%] xs:w-[50%] xs:overflow-y-auto xs:no-scrollbar
    text-center bg-gray-900">
        <div class="text-gray-100 text-xl">
            <div class="">
                @if (Laravel\Jetstream\Jetstream::hasAccountFeatures())
                <div class="ml-1 relative flex items-center justify-end mr-1">

                    {{-- accounts --}}
                    <x-jet-dropdown align="right" width="60">
                        <x-slot  name="trigger">
                            <span class="inline-flex  rounded-md w-full">

                                <button  type="button" class="w-full no-underline hover:no-underline focus:no-underline
                               flex justify-between
                                 items-center px-[2px] py-[2px] border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white
                                  hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                 @php
                                                     try {
                                                        $currentAccount=DB::table('users')->join('accounts','users.id','=','accounts.user_id')
                                                     ->where('accounts.id','=',Auth::user()->currentAccount->id)->
                                                     where('accounts.personal_account','=','1')->select('users.*')->first();


                                                     } catch (\Throwable $th) {
                                                        $currentAccount=DB::table('users')->where('id','=',Auth::user()->id)->select('users.*')->first();
                                                     }

                                                 @endphp
                                    <h1 class="text-[10px] truncate pl-[4px]">{{ $currentAccount->name }} {{ __('(') }}<span class="text-[10px]">{{ $currentAccount->email }}</span>{{ __(')') }}</h1>
                                    <div class="flex justify-end">
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </div>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-max max-w-[200px] min-w-[200px] xs:max-w-min xs:min-w-fit">


                                <div class="border-t border-gray-100"></div>

                                <!-- Account Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Switch Accounts') }}
                                </div>

                                @foreach (Auth::user()->allAccounts() as $account)

                                    <x-jet-switchable-account :account="$account" />
                                @endforeach
                            </div>
                        </x-slot>
                    </x-jet-dropdown>


                </div>
                @endif
                <div class="flex justify-center items-center">
                    <svg onclick="openSidebar()"  class="cursor-pointer w-8 h-8  2xl:hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>

            </div>
            <div class="my-2 bg-gray-600 h-[1px]"></div>
        </div>
        <div class="p-2.5 flex items-center justify-center rounded-md px-4 duration-300 cursor-pointer  text-white">

             <a  href="{{ route('dashboard') }}">
            <img class="block w-[130px] h-[50px] object-contain text-gray-800 " viewbox="0 0 58 58" fill="none" src="{{asset('images/logos/app_logo_nav.png')}}" alt="">

              </a>
        </div>
        <div class="min-h-[75%] max-h-[75%] overflow-y-scroll
        no-scrollbar">
            {{-- dashboard --}}
            <div style="{{ (request()->is('dashboard')) ? 'background-color:#1277D1' : '' }}"
                class=" max-h-[44px] min-h-[44px] p-1 mt-20 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">


                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                <svg class="w-8"  viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                <g id="SVGRepo_iconCarrier"> <path d="M55.64 22.751H35.09C34.5596 22.751 34.0509 22.9617 33.6758 23.3368C33.3007 23.7118 33.09 24.2205 33.09 24.751V55.571C33.0916 56.1009 33.3028 56.6087 33.6775 56.9834C34.0523 57.3582 34.5601 57.5694 35.09 57.571H55.64C56.1699 57.5694 56.6777 57.3582 57.0525 56.9834C57.4272 56.6087 57.6384 56.1009 57.64 55.571V24.751C57.64 24.2205 57.4293 23.7118 57.0542 23.3368C56.6791 22.9617 56.1704 22.751 55.64 22.751Z" fill="#7a7a7a"/> <path d="M55.64 5.62695H35.09C34.5596 5.62695 34.0509 5.83767 33.6758 6.21274C33.3007 6.58781 33.09 7.09652 33.09 7.62695V17.8969C33.0916 18.4269 33.3028 18.9347 33.6775 19.3094C34.0523 19.6841 34.5601 19.8954 35.09 19.8969H55.64C56.1699 19.8954 56.6777 19.6841 57.0525 19.3094C57.4272 18.9347 57.6384 18.4269 57.64 17.8969V7.62695C57.64 7.09652 57.4293 6.58781 57.0542 6.21274C56.6791 5.83767 56.1704 5.62695 55.64 5.62695Z" fill="#f5f5f5"/> <path d="M28.24 36.451H7.7C6.59543 36.451 5.7 37.3465 5.7 38.451V55.5711C5.7 56.6756 6.59543 57.5711 7.7 57.5711H28.24C29.3446 57.5711 30.24 56.6756 30.24 55.5711V38.451C30.24 37.3465 29.3446 36.451 28.24 36.451Z" fill="#f5f5f5"/> <path d="M28.24 5.62697H7.70002C7.43712 5.62604 7.17661 5.67714 6.93355 5.77733C6.69048 5.87751 6.46964 6.02477 6.28373 6.21068C6.09783 6.39658 5.95054 6.61742 5.85035 6.86049C5.75017 7.10355 5.6991 7.36406 5.70002 7.62697V31.557C5.70002 32.0874 5.91074 32.5961 6.28581 32.9712C6.66088 33.3462 7.16959 33.557 7.70002 33.557H28.24C28.7704 33.557 29.2791 33.3462 29.6542 32.9712C30.0293 32.5961 30.24 32.0874 30.24 31.557V7.62697C30.2409 7.36406 30.1898 7.10355 30.0896 6.86049C29.9895 6.61742 29.8422 6.39658 29.6563 6.21068C29.4704 6.02477 29.2495 5.87751 29.0065 5.77733C28.7634 5.67714 28.5029 5.62604 28.24 5.62697Z" fill="#7a7a7a"/> </g>
                </svg>
                <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('dashboard')" :active="request()->routeIs('dashboard')">

                <span class="text-[15px] ml-4 text-gray-200 text-center text-red  {{ (request()->is('dashboard')) ? "font-bold" : "" }} ">  {{ __('main.dashboard') }}</span></x-dropdown-link>
            </div>

            {{-- forms --}}
            <div style="{{ (request()->is('forms')) ? 'background-color:#1277D1' : '' }}"
                class=" max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-secondary_blue text-white">


                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                    <svg class="w-8" viewBox="0 0 512 512" enable-background="new 0 0 512 512" id="Layer_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <g> <g> <path d="M450.255,434.511H61.745c-13.257,0-24.042-10.786-24.042-24.042V101.532 c0-13.257,10.785-24.042,24.042-24.042h388.511c13.257,0,24.042,10.786,24.042,24.042v308.937 C474.298,423.725,463.513,434.511,450.255,434.511z M61.745,97.489c-2.229,0-4.042,1.813-4.042,4.042v308.937 c0,2.229,1.813,4.042,4.042,4.042h388.511c2.229,0,4.042-1.813,4.042-4.042V101.532c0-2.229-1.813-4.042-4.042-4.042H61.745z" fill="#f5f5f5"/> </g> <g> <path d="M450.117,163.589H63.655c-13.298,0-24.118-10.785-24.118-24.042v-38.015 c0-13.257,10.819-24.042,24.118-24.042h386.462c13.298,0,24.118,10.786,24.118,24.042v38.015 C474.235,152.804,463.416,163.589,450.117,163.589z M63.655,97.489c-2.271,0-4.118,1.813-4.118,4.042v38.015 c0,2.229,1.847,4.042,4.118,4.042h386.462c2.271,0,4.118-1.813,4.118-4.042v-38.015c0-2.229-1.847-4.042-4.118-4.042H63.655z" fill="#f5f5f5"/> </g> <g> <path d="M93.73,128.69c-2.63,0-5.21-1.06-7.07-2.92c-1.86-1.87-2.93-4.44-2.93-7.07c0-2.64,1.07-5.21,2.93-7.08 c1.86-1.86,4.44-2.92,7.07-2.92c2.63,0,5.21,1.06,7.07,2.92c1.86,1.87,2.93,4.44,2.93,7.08c0,2.63-1.07,5.21-2.93,7.07 C98.94,127.63,96.36,128.69,93.73,128.69z" fill="#f5f5f5"/> </g> <g> <path d="M142.49,128.69c-2.64,0-5.21-1.06-7.07-2.92c-1.86-1.86-2.93-4.44-2.93-7.07c0-2.64,1.07-5.22,2.93-7.08 c1.86-1.86,4.43-2.92,7.07-2.92c2.63,0,5.21,1.06,7.07,2.92c1.86,1.86,2.93,4.44,2.93,7.08c0,2.63-1.07,5.21-2.93,7.07 C147.7,127.63,145.12,128.69,142.49,128.69z" fill="#f5f5f5"/> </g> <g> <path d="M130.769,224.768c-2.508,0-5.002-0.94-6.921-2.78l-10.631-10.188c-3.987-3.821-4.123-10.151-0.301-14.139 c3.821-3.987,10.15-4.123,14.139-0.301l4.694,4.498l23.393-16.432c4.52-3.173,10.757-2.083,13.931,2.435 c3.174,4.52,2.084,10.757-2.435,13.931l-30.123,21.158C134.78,224.169,132.77,224.768,130.769,224.768z" fill="#f5f5f5"/> </g> <g> <path d="M136.164,305.05c-2.508,0-5.002-0.94-6.921-2.78l-10.631-10.188c-3.987-3.821-4.123-10.151-0.301-14.139 c3.821-3.987,10.15-4.123,14.139-0.301l4.694,4.498l23.393-16.432c4.521-3.173,10.757-2.083,13.931,2.435 c3.174,4.52,2.084,10.757-2.435,13.931l-30.123,21.158C140.175,304.451,138.165,305.05,136.164,305.05z" fill="#f5f5f5"/> </g> <g> <path d="M151.512,374.753h-31.377c-5.523,0-10-4.477-10-10s4.477-10,10-10h31.377c5.523,0,10,4.477,10,10 S157.035,374.753,151.512,374.753z" fill="#f5f5f5"/> </g> <g> <path d="M379.69,214.189H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,214.189,379.69,214.189z" fill="#f5f5f5"/> </g> <g> <path d="M379.69,294.989H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,294.989,379.69,294.989z" fill="#f5f5f5"/> </g> <g> <path d="M379.69,374.753H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,374.753,379.69,374.753z" fill="#f5f5f5"/> </g> <g> <path d="M464.298,410.468c0,7.755-6.287,14.042-14.042,14.042H61.745c-7.755,0-14.042-6.287-14.042-14.042V101.532 c0-7.755,6.287-14.042,14.042-14.042h388.511c7.755,0,14.042,6.287,14.042,14.042V410.468z" fill="#7a7a7a"/> <path d="M450.255,434.511H61.745c-13.257,0-24.042-10.786-24.042-24.042V101.532 c0-13.257,10.785-24.042,24.042-24.042h388.511c13.257,0,24.042,10.786,24.042,24.042v308.937 C474.298,423.725,463.513,434.511,450.255,434.511z M61.745,97.489c-2.229,0-4.042,1.813-4.042,4.042v308.937 c0,2.229,1.813,4.042,4.042,4.042h388.511c2.229,0,4.042-1.813,4.042-4.042V101.532c0-2.229-1.813-4.042-4.042-4.042H61.745z" fill="#f5f5f5"/> </g> <g> <path d="M464.235,139.547c0,7.755-6.321,14.042-14.118,14.042H63.655c-7.797,0-14.118-6.287-14.118-14.042v-38.015 c0-7.755,6.321-14.042,14.118-14.042h386.462c7.797,0,14.118,6.287,14.118,14.042V139.547z" fill="#7a7a7a"/> <path d="M450.117,163.589H63.655c-13.298,0-24.118-10.785-24.118-24.042v-38.015 c0-13.257,10.819-24.042,24.118-24.042h386.462c13.298,0,24.118,10.786,24.118,24.042v38.015 C474.235,152.804,463.416,163.589,450.117,163.589z M63.655,97.489c-2.271,0-4.118,1.813-4.118,4.042v38.015 c0,2.229,1.847,4.042,4.118,4.042h386.462c2.271,0,4.118-1.813,4.118-4.042v-38.015c0-2.229-1.847-4.042-4.118-4.042H63.655z" fill="#f5f5f5"/> </g> <g> <path d="M93.73,128.69c-2.63,0-5.21-1.06-7.07-2.92c-1.86-1.87-2.93-4.44-2.93-7.07c0-2.64,1.07-5.21,2.93-7.08 c1.86-1.86,4.44-2.92,7.07-2.92c2.63,0,5.21,1.06,7.07,2.92c1.86,1.87,2.93,4.44,2.93,7.08c0,2.63-1.07,5.21-2.93,7.07 C98.94,127.63,96.36,128.69,93.73,128.69z" fill="#f5f5f5"/> </g> <g> <path d="M142.49,128.69c-2.64,0-5.21-1.06-7.07-2.92c-1.86-1.86-2.93-4.44-2.93-7.07c0-2.64,1.07-5.22,2.93-7.08 c1.86-1.86,4.43-2.92,7.07-2.92c2.63,0,5.21,1.06,7.07,2.92c1.86,1.86,2.93,4.44,2.93,7.08c0,2.63-1.07,5.21-2.93,7.07 C147.7,127.63,145.12,128.69,142.49,128.69z" fill="#f5f5f5"/> </g> <g> <path d="M130.769,224.768c-2.508,0-5.002-0.94-6.921-2.78l-10.631-10.188c-3.987-3.821-4.123-10.151-0.301-14.139 c3.821-3.987,10.15-4.123,14.139-0.301l4.694,4.498l23.393-16.432c4.52-3.173,10.757-2.083,13.931,2.435 c3.174,4.52,2.084,10.757-2.435,13.931l-30.123,21.158C134.78,224.169,132.77,224.768,130.769,224.768z" fill="#f5f5f5"/> </g> <g> <path d="M136.164,305.05c-2.508,0-5.002-0.94-6.921-2.78l-10.631-10.188c-3.987-3.821-4.123-10.151-0.301-14.139 c3.821-3.987,10.15-4.123,14.139-0.301l4.694,4.498l23.393-16.432c4.521-3.173,10.757-2.083,13.931,2.435 c3.174,4.52,2.084,10.757-2.435,13.931l-30.123,21.158C140.175,304.451,138.165,305.05,136.164,305.05z" fill="#f5f5f5"/> </g> <g> <path d="M151.512,374.753h-31.377c-5.523,0-10-4.477-10-10s4.477-10,10-10h31.377c5.523,0,10,4.477,10,10 S157.035,374.753,151.512,374.753z" fill="#f5f5f5"/> </g> <g> <path d="M379.69,214.189H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,214.189,379.69,214.189z" fill="#f5f5f5"/> </g> <g> <path d="M379.69,294.989H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,294.989,379.69,294.989z" fill="#f5f5f5"/> </g> <g> <path d="M379.69,374.753H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,374.753,379.69,374.753z" fill="#f5f5f5"/> </g> </g> </g>
                    </svg>
                <x-dropdown-link class="flex no-underline hover:no-underline focus:no-underline"  :href="route('forms')" :active="request()->routeIs('forms')">

                <span class="text-[15px] ml-4 text-gray-200 text-center {{ (request()->is('forms')) ? "font-bold" : "" }} ">  {{ __('main.myforms') }}</span></x-dropdown-link>
            </div>
            {{-- kiosks --}}
            <div  style="{{ (request()->is('kiosks')) ? 'background-color:#1277D1' : '' }}"
                class="max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300  cursor-pointer hover:bg-secondary_blue text-white">
                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                    <svg class="w-8" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" width="800px" height="800px" fill="#f5f5f5" stroke="#f5f5f5">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <g> <ellipse style="fill:#f5f5f5;" cx="256" cy="414.302" rx="93.936" ry="38.661"/> <path style="fill:#f5f5f5;" d="M265.404,414.302h-18.808c-5.771,0-10.449-4.678-10.449-10.449v-52.245h39.706v52.245 C275.853,409.624,271.175,414.302,265.404,414.302z"/> <path style="fill:#f5f5f5;" d="M483.265,351.608H28.735c-11.542,0-20.898-9.356-20.898-20.898V79.935 c0-11.542,9.356-20.898,20.898-20.898h454.531c11.542,0,20.898,9.356,20.898,20.898V330.71 C504.163,342.252,494.807,351.608,483.265,351.608z"/> </g> <rect x="39.184" y="90.384" style="fill:#7a7a7a;" width="433.633" height="219.429"/> <path d="M483.265,51.2H28.735C12.89,51.2,0,64.091,0,79.935V330.71c0,15.844,12.89,28.735,28.735,28.735H228.31v10.015 c-37.954,4.688-74.083,19.875-74.083,44.842c0,26.508,43.753,46.498,101.773,46.498s101.773-19.99,101.773-46.498 c0-24.967-36.129-40.152-74.083-44.842v-10.015h199.576c15.845,0,28.735-12.891,28.735-28.735V79.935 C512,64.091,499.11,51.2,483.265,51.2z M325.251,396.856c10.707,5.392,16.849,11.751,16.849,17.446 c0,12.871-32.755,30.824-86.1,30.824s-86.1-17.953-86.1-30.824c0-5.695,6.141-12.054,16.848-17.446 c10.747-5.413,25.283-9.443,41.561-11.595v18.592c0,10.082,8.203,18.286,18.286,18.286h18.808c10.082,0,18.286-8.204,18.286-18.286 v-18.592C299.967,387.414,314.504,391.444,325.251,396.856z M268.016,403.853c0,1.441-1.172,2.612-2.612,2.612h-18.808 c-1.44,0-2.612-1.171-2.612-2.612v-44.408h24.033V403.853z M496.327,330.71c0,7.203-5.859,13.061-13.061,13.061H28.735 c-7.202,0-13.061-5.859-13.061-13.061V79.935c0-7.202,5.859-13.061,13.061-13.061h454.531c7.202,0,13.061,5.859,13.061,13.061 V330.71z"/> <path d="M31.347,317.649h449.306V82.547H31.347V317.649z M47.02,98.22H464.98v203.755H47.02V98.22z"/> </g>
                    </svg>
                <x-dropdown-link class="flex no-underline hover:no-underline focus:no-underline" :href="route('kiosks')" :active="request()->routeIs('kiosks')">

                <span class="text-[15px] ml-4 text-gray-200 text-center {{ (request()->is('kiosks')) ? "font-bold" : "" }} ">  {{ __('main.mykiosks') }}</span></x-dropdown-link>
            </div>

            {{-- todo --}}

            <div  style="{{ (request()->is('todo')) ? 'background-color:#1277D1' : '' }}"
                class="max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300  cursor-pointer hover:bg-secondary_blue text-white">


                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                    <svg class="w-8"  viewBox="0 0 48 48" version="1" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 48 48" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <path fill="#f5f5f5" d="M5,38V14h38v24c0,2.2-1.8,4-4,4H9C6.8,42,5,40.2,5,38z"/> <path fill="#7a7a7a" d="M43,10v6H5v-6c0-2.2,1.8-4,4-4h30C41.2,6,43,7.8,43,10z"/> <g fill="#7a7a7a"> <circle cx="33" cy="10" r="3"/> <circle cx="15" cy="10" r="3"/> </g> <g fill="#f5f5f5"> <path d="M33,3c-1.1,0-2,0.9-2,2v5c0,1.1,0.9,2,2,2s2-0.9,2-2V5C35,3.9,34.1,3,33,3z"/> <path d="M15,3c-1.1,0-2,0.9-2,2v5c0,1.1,0.9,2,2,2s2-0.9,2-2V5C17,3.9,16.1,3,15,3z"/> </g> <g fill="#7a7a7a"> <rect x="13" y="20" width="4" height="4"/> <rect x="19" y="20" width="4" height="4"/> <rect x="25" y="20" width="4" height="4"/> <rect x="31" y="20" width="4" height="4"/> <rect x="13" y="26" width="4" height="4"/> <rect x="19" y="26" width="4" height="4"/> <rect x="25" y="26" width="4" height="4"/> <rect x="31" y="26" width="4" height="4"/> <rect x="13" y="32" width="4" height="4"/> <rect x="19" y="32" width="4" height="4"/> <rect x="25" y="32" width="4" height="4"/> <rect x="31" y="32" width="4" height="4"/> </g> </g>
                    </svg>
                    <x-dropdown-link class="flex no-underline hover:no-underline focus:no-underline"  :href="route('todolist')" :active="request()->routeIs('todolist')">

                    <span class="text-[15px] ml-4 text-gray-200 text-center {{ (request()->is('todo')) ? "font-bold" : "" }} ">  {{ __('main.todo_nav') }}</span></x-dropdown-link>
            </div>

             {{-- signpdf --}}
             <div  style="{{ (request()->is('signpdf.index')) ? 'background-color:#1277D1' : '' }}"
                class="max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300  cursor-pointer hover:bg-secondary_blue text-white">

                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                    <svg class="w-8" viewBox="0 0 48 48" version="1" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 48 48" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <path fill="#f5f5f5" d="M38.8,28.2C41.5,24.8,45,20.1,45,12c0-0.6-0.4-1-1-1s-1,0.4-1,1c0,6.7-2.5,10.7-5,13.9c-0.6-1.9-1-4.2-1-6.9 c0-0.5-0.4-1-1-1c-0.5,0-1,0.4-1,1c-0.1,1.7-0.6,3.6-1,3.8c-0.4,0-0.9-1.4-1-2.8c0-0.5-0.5-0.9-1-0.9c-0.5,0-1,0.3-1,0.9 c-0.3,1.7-1.1,4.1-2,4.1c-0.4,0-0.6-0.1-0.7-0.3c-0.3-0.3-0.4-1-0.4-1.6c0-0.4,0.1-0.8,0.1-1.2c0-0.5-0.4-1-0.9-1 c-0.5,0-1,0.3-1.1,0.8c0,0.1-0.1,0.5-0.1,1.1C25.7,23.6,25.1,27,23,27c-0.7,0-1.1-0.2-1.4-0.7c-0.5-0.8-0.5-2.1,0-3.3c0,0,0,0,0-0.1 c0.1-0.1,0.1-0.3,0.2-0.4c0,0,0,0,0,0c0.8-1.6,1.7-2.5,3.2-2.5c0.6,0,1-0.4,1-1s-0.4-1-1-1c-4.2,0-5.4,4.1-6.6,8 c-1.4,4.8-2.7,8-6.4,8c-5.1,0-7-6.6-7-11c0-8.6,4.7-14,9-14c2.9,0,4,2.3,4.1,2.4c0.2,0.5,0.8,0.7,1.3,0.5c0.5-0.2,0.7-0.8,0.5-1.3 C19.8,10.4,18.2,7,14,7C8.6,7,3,13,3,23c0,10.3,5.9,13,9,13c5.1,0,6.8-4.5,8.1-8.5c0.7,0.9,1.7,1.5,2.9,1.5c2.2,0,3.5-1.6,4.2-3.6 c0.5,0.4,1.1,0.6,1.8,0.6c1.4,0,2.4-1.2,3-2.4c0.4,0.7,1.1,1.2,2,1.2c0.6,0,1.1-0.3,1.5-0.7c0.3,1.4,0.7,2.7,1,3.8 C35.1,29.7,34,31.2,34,33c0,1.7,1.3,3,3,3c1.8,0,3-1.6,3-3c0-1.3-0.5-2.7-1.1-4.3C38.9,28.5,38.8,28.4,38.8,28.2z M37,34 c-0.7,0-1-0.5-1-1c0-0.9,0.5-1.8,1.3-2.9c0.4,1.2,0.7,2.1,0.7,2.9C38,33.3,37.7,34,37,34z"/> <rect x="3" y="40" fill="#7a7a7a" width="42" height="2"/> </g>
                    </svg>
                    <x-dropdown-link class="flex no-underline hover:no-underline focus:no-underline"  :href="route('signpdf.index')" :active="request()->routeIs('signpdf.index')">

                    <span class="text-[15px] ml-4 text-gray-200 text-center {{ (request()->is('signpdf.index')) ? "font-bold" : "" }} ">  {{ __('main.signpdf_nav') }}</span></x-dropdown-link>
            </div>
            {{-- support &account --}}
            <div class="min-h-[250px]">
                {{-- Account Settings --}}
                <div >
                    <div   class=" p-1 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">

                        <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                        <svg class="w-8" fill="#000000"  viewBox="0 0 32 32" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                        <g id="SVGRepo_iconCarrier"> <g transform="matrix(1,0,0,1,-96,-288)"> <path d="M115,294.459C116.414,294.903 117.693,295.654 118.76,296.633C118.76,296.633 119.362,296.286 120.026,295.902C120.983,295.35 122.206,295.677 122.758,296.634C123.08,297.191 123.437,297.809 123.758,298.366C124.311,299.323 123.983,300.546 123.026,301.098C122.363,301.481 121.763,301.827 121.763,301.827C121.918,302.527 122,303.254 122,304C122,304.746 121.918,305.473 121.763,306.173C121.763,306.173 122.363,306.519 123.026,306.902C123.486,307.167 123.821,307.604 123.958,308.116C124.095,308.629 124.024,309.175 123.758,309.634C123.437,310.191 123.08,310.809 122.758,311.366C122.206,312.323 120.983,312.65 120.026,312.098C119.362,311.714 118.76,311.367 118.76,311.367C117.693,312.346 116.414,313.097 115,313.541L115,315C115,316.105 114.105,317 113,317C112.356,317 111.644,317 111,317C109.895,317 109,316.105 109,315C109,314.234 109,313.541 109,313.541C107.586,313.097 106.307,312.346 105.24,311.367C105.24,311.367 104.638,311.714 103.974,312.098C103.017,312.65 101.794,312.323 101.242,311.366C100.92,310.809 100.563,310.191 100.242,309.634C99.689,308.677 100.017,307.454 100.974,306.902C101.637,306.519 102.237,306.173 102.237,306.173C102.082,305.473 102,304.746 102,304C102,303.254 102.082,302.527 102.237,301.827C102.237,301.827 101.637,301.481 100.974,301.098C100.514,300.833 100.179,300.396 100.042,299.884C99.905,299.371 99.976,298.825 100.242,298.366C100.563,297.809 100.92,297.191 101.242,296.634C101.794,295.677 103.017,295.35 103.974,295.902C104.638,296.286 105.24,296.633 105.24,296.633C106.307,295.654 107.586,294.903 109,294.459L109,293C109,291.895 109.895,291 111,291C111.644,291 112.356,291 113,291C114.105,291 115,291.895 115,293C115,293.766 115,294.459 115,294.459Z" style="fill:#7a7a7a;"/> <path d="M116,293.751L116,293C116,291.343 114.657,290 113,290L111,290C109.343,290 108,291.343 108,293L108,293.751C106.956,294.16 105.989,294.723 105.127,295.413C105.127,295.413 104.474,295.036 104.474,295.036C103.039,294.207 101.204,294.699 100.376,296.134L99.376,297.866C98.978,298.555 98.87,299.374 99.076,300.142C99.282,300.911 99.785,301.566 100.474,301.964C100.474,301.964 101.125,302.34 101.125,302.34C101.043,302.881 101,303.436 101,304C101,304.564 101.043,305.119 101.125,305.66C101.125,305.66 100.474,306.036 100.474,306.036C99.039,306.864 98.547,308.699 99.376,310.134L100.376,311.866C101.204,313.301 103.039,313.793 104.474,312.964C104.474,312.964 105.127,312.587 105.127,312.587C105.989,313.277 106.956,313.841 108,314.249C108,314.249 108,315 108,315C108,316.657 109.343,318 111,318L113,318C114.657,318 116,316.657 116,315L116,314.249C117.044,313.84 118.011,313.277 118.873,312.587C118.873,312.587 119.526,312.964 119.526,312.964C120.961,313.793 122.796,313.301 123.624,311.866L124.624,310.134C125.022,309.445 125.13,308.626 124.924,307.858C124.718,307.089 124.215,306.434 123.526,306.036C123.526,306.036 122.875,305.66 122.875,305.66C122.957,305.119 123,304.564 123,304C123,303.436 122.957,302.881 122.875,302.34C122.875,302.34 123.526,301.964 123.526,301.964C124.961,301.136 125.453,299.301 124.624,297.866L123.624,296.134C122.796,294.699 120.961,294.207 119.526,295.036C119.526,295.036 118.873,295.413 118.873,295.413C118.012,294.723 117.045,294.159 116,293.751ZM114,294.459C114,294.895 114.283,295.282 114.7,295.413C115.973,295.813 117.123,296.488 118.083,297.37C118.405,297.665 118.881,297.718 119.26,297.499L120.526,296.768C121.005,296.492 121.616,296.656 121.892,297.134C121.892,297.134 122.892,298.866 122.892,298.866C123.168,299.344 123.005,299.956 122.526,300.232L121.263,300.961C120.885,301.18 120.692,301.618 120.787,302.044C120.926,302.674 121,303.328 121,304C121,304.672 120.926,305.326 120.787,305.956C120.692,306.382 120.885,306.82 121.263,307.039L122.526,307.768C122.756,307.901 122.924,308.119 122.992,308.375C123.061,308.631 123.025,308.904 122.892,309.134C122.892,309.134 121.892,310.866 121.892,310.866C121.616,311.344 121.005,311.508 120.526,311.232C119.862,310.848 119.26,310.501 119.26,310.501C118.881,310.282 118.405,310.335 118.083,310.63C117.123,311.511 115.972,312.187 114.7,312.588C114.283,312.719 114,313.105 114,313.541L114,315C114,315.552 113.552,316 113,316C113,316 111,316 111,316C110.448,316 110,315.552 110,315C110,314.234 110,313.541 110,313.541C110,313.105 109.717,312.718 109.3,312.587C108.027,312.187 106.877,311.512 105.917,310.63C105.595,310.335 105.119,310.282 104.74,310.501L103.474,311.232C102.995,311.508 102.384,311.344 102.108,310.866C102.108,310.866 101.108,309.134 101.108,309.134C100.832,308.656 100.995,308.044 101.474,307.768L102.737,307.039C103.115,306.82 103.308,306.382 103.213,305.956C103.074,305.326 103,304.672 103,304C103,303.328 103.074,302.674 103.213,302.044C103.308,301.618 103.115,301.18 102.737,300.961L101.474,300.232C101.244,300.099 101.076,299.881 101.008,299.625C100.939,299.369 100.975,299.096 101.108,298.866C101.108,298.866 102.108,297.134 102.108,297.134C102.384,296.656 102.995,296.492 103.474,296.768C104.138,297.152 104.74,297.499 104.74,297.499C105.119,297.718 105.595,297.665 105.917,297.37C106.877,296.489 108.028,295.813 109.3,295.412C109.717,295.281 110,294.895 110,294.459L110,293C110,292.448 110.448,292 111,292C111,292 113,292 113,292C113.552,292 114,292.448 114,293C114,293.766 114,294.459 114,294.459ZM112,298C108.689,298 106,300.689 106,304C106,307.311 108.689,310 112,310C115.311,310 118,307.311 118,304C118,300.689 115.311,298 112,298ZM112,300C114.208,300 116,301.792 116,304C116,306.208 114.208,308 112,308C109.792,308 108,306.208 108,304C108,301.792 109.792,300 112,300Z" style="fill:#f5f5f5;"/> </g> </g>
                        </svg>
                        <x-dropdown-link onclick="ShowSubMenu()" class="flex items-center no-underline hover:no-underline focus:no-underline"  >

                        <span class="text-[15px] ml-4 text-gray-200 text-center whitespace-nowrap">  {{ __('main.account') }}</span>
                        <span class="ml-8 w-4 h-4" >
                            <svg id="svgdown" class="hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                            <svg id="svgright" class="" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path>
                            </svg>
                        </span>
                        </x-dropdown-link>
                    </div>
                    @php
                   try {
                   $id= Auth::user()->currentAccount->id;
                   } catch (\Throwable $th) {
                    $id=null;
                   }
                        $current_url= (request()->is("accounts/".$id   )) ? 'text-secondary' : ' text-gray-200' ;
                    @endphp
                    @if($id)
                        <div id="submenuaccount" class=" hidden pl-4  rounded-lg  ">
                            {{-- account settings --}}
                            <div
                                class=" mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:text-secondary text-white">

                                <x-dropdown-link class=" flex no-underline hover:no-underline text-[15px] ml-4 {{ $current_url }}  text-center   hover:text-secondary focus:no-underline"  :href="route('accounts.show', $id)">

                                {{ __('main.settings') }}</x-dropdown-link>
                            </div>
                            {{-- billings --}}
                            <div
                                class=" mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:text-secondary text-white">

                                <x-dropdown-link class="flex no-underline hover:no-underline text-[15px] ml-4 {{ (request()->is('billings')) ? 'text-secondary' : 'text-gray-200' }}  text-center   hover:text-secondary focus:no-underline"  :href="route('billings')">

                                {{ __('main.payamentbilling') }}</x-dropdown-link>
                            </div>
                            {{-- subscriptions --}}
                            <div
                                class=" mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:text-secondary text-white">

                                <x-dropdown-link class="flex no-underline hover:no-underline text-[15px] ml-4 {{  (request()->is('subscriptions')) ? 'text-secondary' : 'text-gray-200'  }}  text-center   hover:text-secondary focus:no-underline"  :href="route('subscriptions')">

                                {{ __('main.subscriptions') }}</x-dropdown-link>
                            </div>

                        </div>
                    @endif
                </div>
                {{-- support --}}
                <div  style="{{ (request()->is('support')) ? 'background-color:#1277D1' : '' }}"
                    class="max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300  cursor-pointer hover:bg-secondary_blue text-white">

                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                    <svg class="w-8"  viewBox="0 0 64.00 64.00" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <path d="M52.25 24.371H50.33V42.151H52.25C53.8752 42.1491 55.4333 41.5027 56.5825 40.3535C57.7317 39.2043 58.3782 37.6462 58.38 36.021V30.511C58.3803 28.8842 57.7348 27.3238 56.5854 26.1726C55.4361 25.0213 53.8768 24.3734 52.25 24.371Z" fill="#f5f5f5"/> <path d="M50.33 40.151V42.151H48.33C47.7996 42.151 47.2909 41.9403 46.9158 41.5652C46.5407 41.1902 46.33 40.6814 46.33 40.151C46.3291 39.8881 46.3802 39.6276 46.4804 39.3846C46.5805 39.1415 46.7278 38.9207 46.9137 38.7348C47.0996 38.5489 47.3205 38.4016 47.5635 38.3014C47.8066 38.2012 48.0671 38.1501 48.33 38.151C48.8605 38.151 49.3691 38.3617 49.7442 38.7368C50.1193 39.1119 50.33 39.6206 50.33 40.151Z" fill="#7a7a7a"/> <path d="M46.33 40.151V26.371C46.33 25.8405 46.5407 25.3318 46.9158 24.9568C47.2909 24.5817 47.7996 24.371 48.33 24.371H50.33V40.151C50.33 39.6205 50.1193 39.1118 49.7442 38.7368C49.3691 38.3617 48.8605 38.151 48.33 38.151C48.0671 38.15 47.8066 38.2011 47.5635 38.3013C47.3205 38.4015 47.0996 38.5488 46.9137 38.7347C46.7278 38.9206 46.5805 39.1415 46.4804 39.3845C46.3802 39.6276 46.3291 39.8881 46.33 40.151Z" fill="#7a7a7a"/> <path d="M48.33 42.151H50.33V47.027C50.3333 47.1374 50.3266 47.2478 50.31 47.357C50.2515 47.8414 50.0179 48.2876 49.6532 48.6118C49.2885 48.936 48.8179 49.1156 48.33 49.117C47.7996 49.117 47.2908 48.9063 46.9158 48.5312C46.5407 48.1561 46.33 47.6474 46.33 47.117V40.147C46.3295 40.41 46.3808 40.6705 46.4811 40.9136C46.5814 41.1567 46.7286 41.3776 46.9144 41.5638C47.1001 41.7499 47.3208 41.8976 47.5637 41.9984C47.8066 42.0991 48.067 42.151 48.33 42.151Z" fill="#7a7a7a"/> <path d="M50.31 47.361C50.2285 48.9291 49.5482 50.4061 48.4094 51.4872C47.2706 52.5683 45.7602 53.171 44.19 53.171H43C43.289 52.5438 43.4391 51.8616 43.44 51.171C43.4391 50.4804 43.289 49.7982 43 49.171H44.19C44.7419 49.1702 45.2723 48.9568 45.6709 48.575C46.0695 48.1931 46.3056 47.6724 46.33 47.121C46.33 47.6514 46.5407 48.1601 46.9158 48.5352C47.2908 48.9103 47.7996 49.121 48.33 49.121C48.8179 49.1196 49.2885 48.94 49.6532 48.6158C50.0179 48.2916 50.2514 47.8454 50.31 47.361Z" fill="#7a7a7a"/> <path d="M43 49.171C42.6196 48.3457 42.0103 47.647 41.2446 47.1577C40.4788 46.6685 39.5887 46.4093 38.68 46.411H30.42C29.159 46.4126 27.9502 46.9149 27.0594 47.8075C26.1687 48.7002 25.6689 49.91 25.67 51.171C25.671 52.4305 26.1719 53.638 27.0624 54.5286C27.953 55.4192 29.1605 55.92 30.42 55.921H38.68C39.5868 55.9199 40.4746 55.6608 41.2396 55.1738C42.0046 54.6868 42.6152 53.9922 43 53.171C43.289 52.5438 43.4391 51.8616 43.44 51.171C43.4391 50.4804 43.289 49.7982 43 49.171Z" fill="#f5f5f5"/> <path d="M46.33 26.3709V13.8409C46.3284 13.311 46.1172 12.8032 45.7425 12.4285C45.3678 12.0537 44.86 11.8425 44.33 11.8409H20.44C19.9096 11.8409 19.4008 12.0517 19.0258 12.4267C18.6507 12.8018 18.44 13.3105 18.44 13.8409V26.3709C18.4384 25.841 18.2272 25.3332 17.8525 24.9585C17.4777 24.5838 16.9699 24.3725 16.44 24.3709H14.44V13.8409C14.4429 12.2505 15.076 10.7261 16.2006 9.60153C17.3252 8.47694 18.8496 7.84385 20.44 7.84094H44.33C45.9199 7.84569 47.4432 8.47936 48.5674 9.60355C49.6916 10.7277 50.3253 12.2511 50.33 13.8409V24.3709H48.33C47.7996 24.3709 47.2908 24.5817 46.9158 24.9567C46.5407 25.3318 46.33 25.8405 46.33 26.3709Z" fill="#7a7a7a"/> <path d="M18.44 40.151C18.4384 40.6809 18.2272 41.1887 17.8525 41.5634C17.4777 41.9382 16.9699 42.1494 16.44 42.151C15.9096 42.151 15.4008 41.9403 15.0258 41.5652C14.6507 41.1901 14.44 40.6814 14.44 40.151V24.371H16.44C16.9699 24.3726 17.4777 24.5838 17.8525 24.9585C18.2272 25.3333 18.4384 25.841 18.44 26.371V40.151Z" fill="#7a7a7a"/> <path d="M14.44 40.151V24.371H12.51C10.8832 24.3734 9.32393 25.0213 8.17456 26.1726C7.02519 27.3238 6.37974 28.8842 6.38 30.511V36.021C6.38186 37.6462 7.02829 39.2043 8.17749 40.3535C9.32669 41.5027 10.8848 42.1491 12.51 42.151H16.44C15.9096 42.151 15.4008 41.9403 15.0258 41.5652C14.6507 41.1901 14.44 40.6814 14.44 40.151Z" fill="#f5f5f5"/> </g>
                    </svg>
                        <x-dropdown-link class="flex no-underline hover:no-underline focus:no-underline"  :href="route('support')" :active="request()->routeIs('support')">

                        <span class="text-[15px] ml-4 text-gray-200 text-center ">  {{ __('main.support') }}</span></x-dropdown-link>
                </div>
            </div>
        </div>
        <div class="border-gray-600 h-[1px]  border-t grid grid-cols-3 ">
              {{-- profile --}}
            <x-dropdown-link class="flex px-0 no-underline hover:no-underline focus:no-underline"  :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                <div class="p-2 mt-0 grid col-span-1 justify-center items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-secondary_blue text-white">

                    <div class="flex justify-center items-center">
                        <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                        <svg class="w-[20px]"  viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                        <g id="SVGRepo_iconCarrier"> <path d="M38.87 27.571C38.8647 25.6242 38.0883 23.7587 36.7108 22.3831C35.3333 21.0074 33.4668 20.2336 31.52 20.231C29.5748 20.2357 27.7106 21.0106 26.3351 22.386C24.9596 23.7615 24.1847 25.6257 24.18 27.571C24.1826 29.5178 24.9565 31.3842 26.3322 32.7617C27.7078 34.1393 29.5732 34.9157 31.52 34.921C33.4684 34.9178 35.336 34.1424 36.7137 32.7647C38.0914 31.387 38.8668 29.5193 38.87 27.571Z" fill="#7a7a7a"/> <path d="M32.39 38.921H30.65C27.3861 38.9239 24.2567 40.2218 21.9487 42.5298C19.6408 44.8377 18.3429 47.9671 18.34 51.231V57.601H44.7V51.231C44.6971 47.9671 43.3992 44.8377 41.0913 42.5298C38.7833 40.2218 35.6539 38.9239 32.39 38.921Z" fill="#7a7a7a"/> <path d="M51.52 5.60095H11.52C9.92869 5.60095 8.40256 6.23309 7.27734 7.35831C6.15213 8.48353 5.51999 10.0097 5.51999 11.601V51.601C5.51999 53.1922 6.15213 54.7184 7.27734 55.8436C8.40256 56.9688 9.92869 57.601 11.52 57.601H14.34V51.231C14.3425 48.0404 15.2795 44.9205 17.0354 42.2565C18.7912 39.5925 21.2889 37.5013 24.22 36.2409C22.9529 35.1797 21.9344 33.8531 21.2363 32.355C20.5382 30.8569 20.1776 29.2237 20.18 27.571C20.1845 24.5648 21.3807 21.683 23.5064 19.5573C25.6321 17.4316 28.5138 16.2355 31.52 16.231C34.5277 16.2333 37.4118 17.4285 39.5395 19.5544C41.6672 21.6802 42.865 24.5632 42.87 27.571C42.8724 29.2237 42.5118 30.8569 41.8137 32.355C41.1156 33.8531 40.0971 35.1797 38.83 36.2409C41.7587 37.5034 44.2539 39.5955 46.0078 42.2592C47.7617 44.9229 48.6976 48.0417 48.7 51.231V57.601H51.52C53.1113 57.601 54.6374 56.9688 55.7626 55.8436C56.8879 54.7184 57.52 53.1922 57.52 51.601V11.601C57.52 10.0097 56.8879 8.48353 55.7626 7.35831C54.6374 6.23309 53.1113 5.60095 51.52 5.60095Z" fill="#f5f5f5"/> </g>
                        </svg>
                    </div>
                    <div class="flex justify-center items-center">

                    <span class="text-md    text-gray-200 text-center ">  {{ __('main.profile') }}</span>

                    </div>
                </div>
            </x-dropdown-link>
            {{-- logout --}}
            <form method="POST" action="{{ route('logout') }}" class="flex justify-center items-center">
                @csrf
                <x-dropdown-link class="flex px-0 no-underline hover:no-underline focus:no-underline" :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                    <div  class="p-2 mt-0 grid col-span-1 justify-center items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-secondary_blue text-white">

                        <div class="flex justify-center items-center">
                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                            <svg fill="#000000" class="w-[20px]" viewBox="0 0 24 24" id="sign-out-alt-4" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier">
                            <path id="secondary" d="M9,11H5.41l1.3-1.29A1,1,0,0,0,5.29,8.29l-3,3a1,1,0,0,0,0,1.42l3,3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42L5.41,13H9a1,1,0,0,0,0-2Z" style="fill: #7a7a7a;"/>
                            <path id="primary" d="M20.48,3.84l-6-1.5A2,2,0,0,0,12,4.28V5H10A2,2,0,0,0,8,7V8a1,1,0,0,0,2,0V7h2V17H10V16a1,1,0,0,0-2,0v1a2,2,0,0,0,2,2h2v.72a2,2,0,0,0,2.48,1.94l6-1.5A2,2,0,0,0,22,18.22V5.78A2,2,0,0,0,20.48,3.84Z" style="fill: #f5f5f5;"/>
                            </g>
                            </svg>
                        </div>




                            <span class="text-md  text-gray-200 text-center ">  {{ __('main.logout') }}</span>

                    </div>
                </x-dropdown-link>
            </form>
            {{-- language --}}
            <a class="flex px-0 no-underline hover:no-underline focus:no-underline p-2 mt-0 grid col-span-1 justify-center items-center rounded-md px-4 duration-300 cursor-pointer  text-white"
            @if(App::getLocale()=="ar")  href="{{ route('setLocale','en') }}" @else href="{{ route('setLocale','ar') }}" @endif >
                <div class=" p-2 mt-0 grid col-span-1 justify-center items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-secondary_blue  text-white">
                        <div class="flex justify-center items-center">
                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                            <svg class="w-[20px]" fill="#000000"  viewBox="0 0 24 24" id="translate" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier">
                            <path id="secondary" d="M21,4V16a1,1,0,0,1-1,1H16l-4,4L8,17H4a1,1,0,0,1-1-1V4A1,1,0,0,1,4,3H20A1,1,0,0,1,21,4Z" style="fill: #7a7a7a; stroke-width: 2;"/>
                            <path id="primary" d="M10,11a8.14,8.14,0,0,0,4,3" style="fill: none; stroke: #f5f5f5; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                            <path id="primary-2" data-name="primary" d="M10,14c4-1,4-6,4-6" style="fill: none; stroke: #f5f5f5; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                            <path id="primary-3" data-name="primary" d="M8,8h8M12,7V8m8-5H4A1,1,0,0,0,3,4V16a1,1,0,0,0,1,1H8l4,4,4-4h4a1,1,0,0,0,1-1V4A1,1,0,0,0,20,3Z" style="fill: none; stroke: #f5f5f5; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                            </g>
                            </svg>
                        </div>
                        <div class="flex justify-center items-center" >
                            @if(App::getLocale()=="ar")
                            <span class="text-md  text-gray-200 text-center "> {{ __('EN') }}</span>
                            @else
                            <span class="text-md  text-gray-200 text-center "> {{ __('AR') }}</span>
                            @endif
                        </div>

                </div>
            </a>
        </div>
    </div>

</nav>
@push('scripts')

    <script>
       function ShowSubMenu(){
        var submenuaccount =document.getElementById('submenuaccount');

        var svgright=document.getElementById('svgright');
        var svgdown=document.getElementById('svgdown');
        svgright.classList.toggle('hidden');
        svgdown.classList.toggle('hidden');
        //if hidden
        submenuaccount.classList.toggle('hidden');
       }
    </script>
@endpush
