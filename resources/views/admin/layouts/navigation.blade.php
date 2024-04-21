
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
<nav x-data="{ open: false }" class="p-4  xs:bg-white    items-center  border-b border-gray-100 ">

    <div class="flex justify-between " >
        <span
        class="ml-2 mt-2   flex w-16 h-12 text-white text-4xl top-5 left-5 cursor-pointer"
        onclick="openSidebar()">
            <svg class=" bg-gray-900 rounded-md"  fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
            </svg>

        </span>
        <a  class=" lg:hidden 2xl:hidden " href="{{ route('dashboard') }}">
            <img class="block w-[140px] h-[60px] object-contain text-gray-800 " viewbox="0 0 58 58" fill="none" src="{{asset('images/logos/app_logo_nav.png')}}" alt="">

              </a>

    </div>
    {{-- <a  href="{{ route('accounts.show', Auth::user()->currentAccount->id) }}"  class="material-icons self-center ml-1 mr-1">
                        settings
                    </a> --}}
    <div class="sidebar fixed z-[100] top-0 bottom-0 left-0 p-2   min-w-[240px] max-w-[240px] overflow-y-scroll
    no-scrollbar
    text-center bg-gray-900">
       <div class="text-gray-100 text-xl">
        <div class="">
            <svg onclick="openSidebar()"  class="cursor-pointer ml-28 w-8 h-8  2xl:hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>

            </div>
            <div class="my-2 bg-gray-600 h-[1px]"></div>
        </div>

        <div class="p-2.5 flex items-center justify-center rounded-md px-4 duration-300 cursor-pointer  text-white">

             <a  href="{{ route('admin.dashboard') }}">
            <img class="block w-[130px] h-[50px] object-contain text-gray-800 " viewbox="0 0 58 58" fill="none" src="{{asset('images/logos/app_logo_nav.png')}}" alt="">

              </a>
        </div>
        <div class="p-2.5 mt-2 flex items-center justify-center rounded-md px-4 duration-300 cursor-pointer  text-white">

           <h1>{{ __('Admin Center') }}</h1>
       </div>
        {{-- dashboard --}}

        <div
            class="{{ Route::is('admin.dashboard') ?"bg-secondary_blue":"" }} max-h-[44px] min-h-[44px] p-1 mt-20 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">
            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg class="w-8 text-white" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
            <g id="SVGRepo_iconCarrier"> <title>dashboard-solid</title> <g id="Layer_2" data-name="Layer 2"> <g id="invisible_box" data-name="invisible box"> <rect width="48" height="48" fill="none"/> </g> <g id="icons_Q2" data-name="icons Q2"> <g> <path d="M26,19.4V14a2,2,0,0,0-4,0v5.4A5.1,5.1,0,0,0,19,24a5,5,0,0,0,10,0A5.1,5.1,0,0,0,26,19.4Z"/> <path d="M24,2A22.1,22.1,0,0,0,2,24,21.6,21.6,0,0,0,8.3,39.4a1.9,1.9,0,0,0,2.8,0h0l3-3a2,2,0,0,0-2.8-2.8L9.8,35.1A19.2,19.2,0,0,1,6.1,26H8a2,2,0,0,0,0-4H6.1a18.5,18.5,0,0,1,3.8-9.2h0l1.4,1.3a1.9,1.9,0,0,0,2.8,0,1.9,1.9,0,0,0,0-2.8L12.8,9.9h0A18.5,18.5,0,0,1,22,6.1h0V8a2,2,0,0,0,4,0V6.1h0a18.5,18.5,0,0,1,9.2,3.8h0l-1.3,1.4a1.9,1.9,0,0,0,0,2.8,1.9,1.9,0,0,0,2.8,0l1.4-1.3h0A18.5,18.5,0,0,1,41.9,22H40a2,2,0,0,0,0,4h1.9a19.2,19.2,0,0,1-3.7,9.1l-1.5-1.5a2,2,0,1,0-2.8,2.8L37,39.5a2,2,0,0,0,2.7-.1A21.6,21.6,0,0,0,46,24,22.1,22.1,0,0,0,24,2Z"/> </g> </g> </g> </g>
            </svg>
            <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">

            <span class="text-[15px] ml-4 text-gray-200 text-center text-red  {{ (request()->is('admin.dashboard')) ? "font-bold" : "" }} ">  {{ __('Dashboard') }}</span></x-dropdown-link>
        </div>
        {{-- accounts --}}
        <div
            class="{{ Route::is('admin.accounts') ?"bg-secondary_blue":"" }} max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">

            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg class="w-8 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
            <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M1 5C1 3.34315 2.34315 2 4 2H8.43845C9.81505 2 11.015 2.93689 11.3489 4.27239L11.7808 6H13.5H20C21.6569 6 23 7.34315 23 9V10C23 10.5523 22.5523 11 22 11C21.4477 11 21 10.5523 21 10V9C21 8.44772 20.5523 8 20 8H13.5H11.7808H4C3.44772 8 3 8.44772 3 9V10V19C3 19.5523 3.44772 20 4 20H8C8.55228 20 9 20.4477 9 21C9 21.5523 8.55228 22 8 22H4C2.34315 22 1 20.6569 1 19V10V9V5ZM3 6.17071C3.31278 6.06015 3.64936 6 4 6H9.71922L9.40859 4.75746C9.2973 4.3123 8.89732 4 8.43845 4H4C3.44772 4 3 4.44772 3 5V6.17071ZM17 19C14.2951 19 13 20.6758 13 22C13 22.5523 12.5523 23 12 23C11.4477 23 11 22.5523 11 22C11 20.1742 12.1429 18.5122 13.9952 17.6404C13.3757 16.936 13 16.0119 13 15C13 12.7909 14.7909 11 17 11C19.2091 11 21 12.7909 21 15C21 16.0119 20.6243 16.936 20.0048 17.6404C21.8571 18.5122 23 20.1742 23 22C23 22.5523 22.5523 23 22 23C21.4477 23 21 22.5523 21 22C21 20.6758 19.7049 19 17 19ZM17 17C18.1046 17 19 16.1046 19 15C19 13.8954 18.1046 13 17 13C15.8954 13 15 13.8954 15 15C15 16.1046 15.8954 17 17 17Z" fill="currentColor"/> </g>
            </svg>
            <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('admin.accounts')" :active="request()->routeIs('admin.accounts')">

            <span class="text-[15px] ml-4 text-gray-200 text-center text-red  {{ Route::is('admin.accounts') ?"font-bold":"" }} ">  {{ __('Accounts') }}</span></x-dropdown-link>
        </div>
        {{-- users --}}
        <div
            class="{{ Route::is('admin.users') ?"bg-secondary_blue":"" }} max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">
            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg class="w-8 text-white"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
            <g id="SVGRepo_iconCarrier"> <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M2 21V17C2 15.8954 2.89543 15 4 15H14C15.1046 15 16 15.8954 16 17V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M16 3C16.8604 3.2203 17.623 3.7207 18.1676 4.42231C18.7122 5.12392 19.0078 5.98683 19.0078 6.875C19.0078 7.76317 18.7122 8.62608 18.1676 9.32769C17.623 10.0293 16.8604 10.5297 16 10.75" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M19 15H20C21.1046 15 22 15.8954 22 17V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
            </svg>
            <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('admin.users')" :active="request()->routeIs('admin.users')">

            <span class="text-[15px] ml-4 text-gray-200 text-center text-red  {{ Route::is('admin.users') ?"font-bold":"" }} ">  {{ __('Users') }}</span></x-dropdown-link>
        </div>
         {{-- kiosks --}}
        <div
            class="{{ Route::is('admin.kiosks') ?"bg-secondary_blue":"" }} max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">
            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg class="text-white w-8"  viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
            <g id="SVGRepo_iconCarrier"> <path fill="var(--ci-primary-color, currentColor)" d="M472,232H424V120a24.028,24.028,0,0,0-24-24H40a24.028,24.028,0,0,0-24,24V366a24.028,24.028,0,0,0,24,24H212v50H152v32H304V440H244V390h92v58a24.027,24.027,0,0,0,24,24H472a24.027,24.027,0,0,0,24-24V256A24.027,24.027,0,0,0,472,232ZM336,256V358H48V128H392V232H360A24.027,24.027,0,0,0,336,256ZM464,440H368V264h96Z" class="ci-primary"/> </g>
            </svg>
            <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('admin.kiosks')" :active="request()->routeIs('admin.kiosks')">

            <span class="text-[15px] ml-4 text-gray-200 text-center text-red  {{ Route::is('admin.kiosks') ?"font-bold":"" }} ">  {{ __('Kiosks') }}</span></x-dropdown-link>
        </div>
        {{-- forms --}}


        {{-- subscriptions --}}
        <div
            class="{{ Route::is('admin.subscriptions') ?"bg-secondary_blue":"" }} max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">
            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg class="w-8 text-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
            <g id="SVGRepo_iconCarrier">
            <path d="M14,6a7.17,7.17,0,0,0-1,.08A4.49,4.49,0,0,0,4,6.5V7A2,2,0,0,0,2,9v9a1.94,1.94,0,0,0,2,2H8.73A8,8,0,1,0,14,6ZM6,6.5a2.51,2.51,0,0,1,5-.24V7H6ZM14,20a6,6,0,1,1,6-6A6,6,0,0,1,14,20Zm-1.5-8v1h4a1,1,0,0,1,1,1v3a1,1,0,0,1-1,1H15v1H13V18H10.5V16h5V15h-4a1,1,0,0,1-1-1V11a1,1,0,0,1,1-1H13V9h2v1h2.5v2Z"/>
            <rect width="24" height="24" fill="none"/>
            </g>
            </svg>
            <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('admin.subscriptions')" :active="request()->routeIs('admin.subscriptions')">

            <span class="text-[15px] ml-4 text-gray-200 text-center text-red  {{ Route::is('admin.subscriptions') ?"font-bold":"" }} ">  {{ __('Subscriptions') }}</span></x-dropdown-link>
        </div>
        {{-- invoices --}}
        <div
            class="{{ Route::is('admin.invoices') ?"bg-secondary_blue":"" }} max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">
            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg fill="currentColor" class="w-8 text-white"  viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
            <g id="SVGRepo_iconCarrier">
            <path d="M 6 3 L 6 29 L 22 29 L 22 27 L 8 27 L 8 5 L 18 5 L 18 11 L 24 11 L 24 13 L 26 13 L 26 9.5996094 L 25.699219 9.3007812 L 19.699219 3.3007812 L 19.400391 3 L 6 3 z M 20 6.4003906 L 22.599609 9 L 20 9 L 20 6.4003906 z M 10 13 L 10 15 L 22 15 L 22 13 L 10 13 z M 27 15 L 27 17 C 25.3 17.3 24 18.7 24 20.5 C 24 22.5 25.5 24 27.5 24 L 28.5 24 C 29.3 24 30 24.7 30 25.5 C 30 26.3 29.3 27 28.5 27 L 25 27 L 25 29 L 27 29 L 27 31 L 29 31 L 29 29 C 30.7 28.7 32 27.3 32 25.5 C 32 23.5 30.5 22 28.5 22 L 27.5 22 C 26.7 22 26 21.3 26 20.5 C 26 19.7 26.7 19 27.5 19 L 31 19 L 31 17 L 29 17 L 29 15 L 27 15 z M 10 18 L 10 20 L 17 20 L 17 18 L 10 18 z M 19 18 L 19 20 L 22 20 L 22 18 L 19 18 z M 10 22 L 10 24 L 17 24 L 17 22 L 10 22 z M 19 22 L 19 24 L 22 24 L 22 22 L 19 22 z"/>
            </g>
            </svg>
            <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('admin.invoices')" :active="request()->routeIs('admin.invoices')">

            <span class="text-[15px] ml-4 text-gray-200 text-center text-red  {{ Route::is('admin.invoices') ?"font-bold":"" }} ">  {{ __('Invoices') }}</span></x-dropdown-link>
        </div>
        {{-- tickets --}}
        <div
            class="{{ Route::is('admin.supportTickets') ?"bg-secondary_blue":"" }} max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">

            <svg class="w-8 text-white"  viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor">
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
            <g id="SVGRepo_iconCarrier"> <title>support</title> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="support" fill="currentColor" transform="translate(42.666667, 42.666667)"> <path d="M379.734355,174.506667 C373.121022,106.666667 333.014355,-2.13162821e-14 209.067688,-2.13162821e-14 C85.1210217,-2.13162821e-14 45.014355,106.666667 38.4010217,174.506667 C15.2012632,183.311569 -0.101643453,205.585799 0.000508304259,230.4 L0.000508304259,260.266667 C0.000508304259,293.256475 26.7445463,320 59.734355,320 C92.7241638,320 119.467688,293.256475 119.467688,260.266667 L119.467688,230.4 C119.360431,206.121456 104.619564,184.304973 82.134355,175.146667 C86.4010217,135.893333 107.307688,42.6666667 209.067688,42.6666667 C310.827688,42.6666667 331.521022,135.893333 335.787688,175.146667 C313.347976,184.324806 298.68156,206.155851 298.667688,230.4 L298.667688,260.266667 C298.760356,283.199651 311.928618,304.070103 332.587688,314.026667 C323.627688,330.88 300.801022,353.706667 244.694355,360.533333 C233.478863,343.50282 211.780225,336.789048 192.906491,344.509658 C174.032757,352.230268 163.260418,372.226826 167.196286,392.235189 C171.132153,412.243552 188.675885,426.666667 209.067688,426.666667 C225.181549,426.577424 239.870491,417.417465 247.041022,402.986667 C338.561022,392.533333 367.787688,345.386667 376.961022,317.653333 C401.778455,309.61433 418.468885,286.351502 418.134355,260.266667 L418.134355,230.4 C418.23702,205.585799 402.934114,183.311569 379.734355,174.506667 Z M76.8010217,260.266667 C76.8010217,269.692326 69.1600148,277.333333 59.734355,277.333333 C50.3086953,277.333333 42.6676884,269.692326 42.6676884,260.266667 L42.6676884,230.4 C42.6676884,224.302667 45.9205765,218.668499 51.2010216,215.619833 C56.4814667,212.571166 62.9872434,212.571166 68.2676885,215.619833 C73.5481336,218.668499 76.8010217,224.302667 76.8010217,230.4 L76.8010217,260.266667 Z M341.334355,230.4 C341.334355,220.97434 348.975362,213.333333 358.401022,213.333333 C367.826681,213.333333 375.467688,220.97434 375.467688,230.4 L375.467688,260.266667 C375.467688,269.692326 367.826681,277.333333 358.401022,277.333333 C348.975362,277.333333 341.334355,269.692326 341.334355,260.266667 L341.334355,230.4 Z"> </path> </g> </g> </g>
            </svg>
            <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('admin.supportTickets')" :active="request()->routeIs('admin.supportTickets')">

            <span class="text-[15px] ml-4 text-gray-200 text-center text-red  {{ Route::is('admin.supportTickets') ?"font-bold":"" }} ">  {{ __('Support Tickets') }}</span></x-dropdown-link>
        </div>
        {{-- deleted accounts --}}
        <div
            class="{{ Route::is('admin.deletedaccounts') ?"bg-secondary_blue":"" }} max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">

            <svg class="w-8 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 20V19C4 16.2386 6.23858 14 9 14H12.75M16 15L18.5 17.5M18.5 17.5L21 20M18.5 17.5L21 15M18.5 17.5L16 20M15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('admin.deletedaccounts')" :active="request()->routeIs('admin.deletedaccounts')">

            <span class="text-[15px] ml-4 text-gray-200 text-center text-red  {{ Route::is('admin.deletedaccounts') ?"font-bold":"" }} ">  {{ __('Deleted Accounts') }}</span></x-dropdown-link>
        </div>
        {{-- canceled plans --}}
        <div
            class="{{ Route::is('admin.canceledplans') ?"bg-secondary_blue":"" }} max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">


            <svg class="w-8 text-white"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 15L9 13M9 13L11 11M9 13H13C14.1046 13 15 13.8954 15 15V16M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M4 6H20M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('admin.canceledplans')" :active="request()->routeIs('admin.canceledplans')">

            <span class="text-[15px] ml-4 text-gray-200 text-center text-red  {{ Route::is('admin.canceledplans') ?"font-bold":"" }} ">  {{ __('Canceled Subs') }}</span></x-dropdown-link>
        </div>
        {{-- logout && order - settings --}}
        <div class="border-gray-600 h-[1px]  border-t mt-4 pt-4">



            @if(Auth()->user()->role=="super_admin")
            {{-- setting --}}
            <div
              class="{{ Route::is('admin.settings') ?"bg-secondary_blue":"" }} max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">


                <svg  class="w-8 text-white" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M600.704 64a32 32 0 0 1 30.464 22.208l35.2 109.376c14.784 7.232 28.928 15.36 42.432 24.512l112.384-24.192a32 32 0 0 1 34.432 15.36L944.32 364.8a32 32 0 0 1-4.032 37.504l-77.12 85.12a357.12 357.12 0 0 1 0 49.024l77.12 85.248a32 32 0 0 1 4.032 37.504l-88.704 153.6a32 32 0 0 1-34.432 15.296L708.8 803.904c-13.44 9.088-27.648 17.28-42.368 24.512l-35.264 109.376A32 32 0 0 1 600.704 960H423.296a32 32 0 0 1-30.464-22.208L357.696 828.48a351.616 351.616 0 0 1-42.56-24.64l-112.32 24.256a32 32 0 0 1-34.432-15.36L79.68 659.2a32 32 0 0 1 4.032-37.504l77.12-85.248a357.12 357.12 0 0 1 0-48.896l-77.12-85.248A32 32 0 0 1 79.68 364.8l88.704-153.6a32 32 0 0 1 34.432-15.296l112.32 24.256c13.568-9.152 27.776-17.408 42.56-24.64l35.2-109.312A32 32 0 0 1 423.232 64H600.64zm-23.424 64H446.72l-36.352 113.088-24.512 11.968a294.113 294.113 0 0 0-34.816 20.096l-22.656 15.36-116.224-25.088-65.28 113.152 79.68 88.192-1.92 27.136a293.12 293.12 0 0 0 0 40.192l1.92 27.136-79.808 88.192 65.344 113.152 116.224-25.024 22.656 15.296a294.113 294.113 0 0 0 34.816 20.096l24.512 11.968L446.72 896h130.688l36.48-113.152 24.448-11.904a288.282 288.282 0 0 0 34.752-20.096l22.592-15.296 116.288 25.024 65.28-113.152-79.744-88.192 1.92-27.136a293.12 293.12 0 0 0 0-40.256l-1.92-27.136 79.808-88.128-65.344-113.152-116.288 24.96-22.592-15.232a287.616 287.616 0 0 0-34.752-20.096l-24.448-11.904L577.344 128zM512 320a192 192 0 1 1 0 384 192 192 0 0 1 0-384zm0 64a128 128 0 1 0 0 256 128 128 0 0 0 0-256z"/></svg>
                <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('admin.settings')" :active="request()->routeIs('admin.settings')">

                <span class="text-[15px] ml-4 text-gray-200 text-center text-red  {{ Route::is('admin.settings') ?"font-bold":"" }} ">  {{ __('Settings') }}</span></x-dropdown-link>
            </div>
            {{-- orders --}}
            <div
              class="{{ Route::is('admin.orders') ?"bg-secondary_blue":"" }} max-h-[44px] min-h-[44px] p-1 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-secondary_blue text-white">


                <svg class="w-8 text-white"  version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 115.35 122.88" style="enable-background:new 0 0 115.35 122.88" xml:space="preserve">
                <g>
                <path fill="currentColor" d="M25.27,86.92c-1.81,0-3.26-1.46-3.26-3.26s1.47-3.26,3.26-3.26h21.49c1.81,0,3.26,1.46,3.26,3.26s-1.46,3.26-3.26,3.26 H25.27L25.27,86.92L25.27,86.92z M61.1,77.47c-0.96,0-1.78-0.82-1.78-1.82c0-0.96,0.82-1.78,1.78-1.78h4.65c0.04,0,0.14,0,0.18,0 c1.64,0.04,3.1,0.36,4.33,1.14c1.37,0.87,2.37,2.19,2.92,4.15c0,0.04,0,0.09,0.05,0.14l0.46,1.82h39.89c1,0,1.78,0.82,1.78,1.78 c0,0.18-0.05,0.36-0.09,0.55l-4.65,18.74c-0.18,0.82-0.91,1.37-1.73,1.37l0,0l-29.18,0c0.64,2.37,1.28,3.65,2.14,4.24 c1.05,0.68,2.87,0.73,5.93,0.68h0.04l0,0h20.61c1,0,1.78,0.82,1.78,1.78c0,1-0.82,1.78-1.78,1.78H87.81l0,0 c-3.79,0.04-6.11-0.05-7.98-1.28c-1.92-1.28-2.92-3.46-3.92-7.43l0,0L69.8,80.2c0-0.05,0-0.05-0.04-0.09 c-0.27-1-0.73-1.69-1.37-2.05c-0.64-0.41-1.5-0.59-2.51-0.59c-0.05,0-0.09,0-0.14,0H61.1L61.1,77.47L61.1,77.47z M103.09,114.13 c2.42,0,4.38,1.96,4.38,4.38s-1.96,4.38-4.38,4.38s-4.38-1.96-4.38-4.38S100.67,114.13,103.09,114.13L103.09,114.13L103.09,114.13z M83.89,114.13c2.42,0,4.38,1.96,4.38,4.38s-1.96,4.38-4.38,4.38c-2.42,0-4.38-1.96-4.38-4.38S81.48,114.13,83.89,114.13 L83.89,114.13L83.89,114.13z M25.27,33.58c-1.81,0-3.26-1.47-3.26-3.26c0-1.8,1.47-3.26,3.26-3.26h50.52 c1.81,0,3.26,1.46,3.26,3.26c0,1.8-1.46,3.26-3.26,3.26H25.27L25.27,33.58L25.27,33.58z M7.57,0h85.63c2.09,0,3.99,0.85,5.35,2.21 s2.21,3.26,2.21,5.35v59.98h-6.5V7.59c0-0.29-0.12-0.56-0.31-0.76c-0.2-0.19-0.47-0.31-0.76-0.31l0,0H7.57 c-0.29,0-0.56,0.12-0.76,0.31S6.51,7.3,6.51,7.59v98.67c0,0.29,0.12,0.56,0.31,0.76s0.46,0.31,0.76,0.31h55.05 c0.61,2.39,1.3,4.48,2.23,6.47H7.57c-2.09,0-3.99-0.85-5.35-2.21C0.85,110.24,0,108.34,0,106.25V7.57c0-2.09,0.85-4,2.21-5.36 S5.48,0,7.57,0L7.57,0L7.57,0z M25.27,60.25c-1.81,0-3.26-1.46-3.26-3.26s1.47-3.26,3.26-3.26h50.52c1.81,0,3.26,1.46,3.26,3.26 s-1.46,3.26-3.26,3.26H25.27L25.27,60.25L25.27,60.25z"/>
                </g>
                </svg>
                <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('admin.orders')" :active="request()->routeIs('admin.orders')">

                <span class="text-[15px] ml-4 text-gray-200 text-center text-red  {{ Route::is('admin.orders') ?"font-bold":"" }} ">  {{ __('Orders') }}</span></x-dropdown-link>
            </div>
             @endif

             {{-- logout --}}
             <div  class="p-2 mt-0 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-secondary_blue text-white">


                <svg fill="currentColor" class="w-[20px]"  viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.651 16.989h17.326c0.553 0 1-0.448 1-1s-0.447-1-1-1h-17.264l3.617-3.617c0.391-0.39 0.391-1.024 0-1.414s-1.024-0.39-1.414 0l-5.907 6.062 5.907 6.063c0.196 0.195 0.451 0.293 0.707 0.293s0.511-0.098 0.707-0.293c0.391-0.39 0.391-1.023 0-1.414zM29.989 0h-17c-1.105 0-2 0.895-2 2v9h2.013v-7.78c0-0.668 0.542-1.21 1.21-1.21h14.523c0.669 0 1.21 0.542 1.21 1.21l0.032 25.572c0 0.668-0.541 1.21-1.21 1.21h-14.553c-0.668 0-1.21-0.542-1.21-1.21v-7.824l-2.013 0.003v9.030c0 1.105 0.895 2 2 2h16.999c1.105 0 2.001-0.895 2.001-2v-28c-0-1.105-0.896-2-2-2z"></path>
                </svg>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf

                    <x-dropdown-link class="flex px-0 no-underline hover:no-underline focus:no-underline" :href="route('admin.logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                    <span class="text-md ml-4 text-gray-200 text-center ">  {{ __('Logout') }}</span>
                    </x-dropdown-link>
                </form>
            </div>
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
