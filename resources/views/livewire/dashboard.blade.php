@push('styles')
<link rel="stylesheet" href="{{ asset('styles/score.css') }}" />
@endpush
<div class="">
    @php
      $count=count($forms);
    //   $timezones = \DateTimeZone::listIdentifiers();
    //    dd($timezones);
    @endphp

    @if($current_subscribe!=null)
             @php

                 if($current_subscribe->subscription_status=="Valid")
                 {
                   $status=trans('main.active_status');
                   $statuslogic="active";
                   $color="valid";
                 }
                 elseif($current_subscribe->subscription_status=="Locked"){
                    $status=trans('main.expiredlocked_status');
                    $statuslogic="expiredlocked";
                   $color="primary_red";
                 }
                 else
                 {
                    $status=trans('main.expiredgrace_status');
                    $statuslogic="expiredgrace";
                   $color="primary_red";
                 }

             @endphp
    @endif
    {{-- end of notifactions --}}
    <div class=" grid grid-cols-12  px-2 pb-2 mt-2   gap-4   max-h-fit   xs:max-h-full" >

         {{-- info --}}
        <div class="min-h-[250px] max-h-[250px] h-[250px] xs:h-full xs:max-h-full rounded-[0.5rem] col-span-5 row-span-1 xs:row-span-5 sm:row-span-5 md:row-span-5 lg:row-span-5 p-4 bg-white xs:col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-12 max-h-1/3 ">
             {{-- welcome message --}}
                <div class="flex  items-center xs:grid">
                    {{ __('main.welcomeAccount',['name' => Auth::user()->name,'currentaccount'=>$currentAccount->account_name]) }}
                  {{-- <div class=" xs:w-full whitespace-nowrap overflow-hidden">
                    <h1 class="text-sm">{{ __('Welcome ') }} <span class="font-bold">{{ Auth::user()->name }}</span> {{ __(' ,') }}</h1>
                  </div>
                  <div class=" xs:w-full whitespace-nowrap overflow-hidden">
                    <h1 class="text-sm">{{ __(' You are in  ') }} <span class="font-bold">{{ $currentAccount->account_name }}</span> {{ __(' Account') }} </h1>
                  </div> --}}
                </div>
            <div class="flex mt-10  xs:grid xs:gap-1">
                {{-- responses --}}
                <div class="hover:bg-gray-50 hover:shadow hover:border-secondary_blue xs:flex xs:justify-between xs:items-center grid grid-rows-3 gap-2 border-2  rounded-[0.5rem] p-2 mx-1 xs:my-1 w-full {{ $current_subscribe->num_of_responses<=100?"border-primary_red":"border-black"  }}">
                    <h1 class="row-span-1 text-md text-center">{{ __('main.responses') }}</h1>
                    <h1 class="text-md row-span-1 text-secondary_blue text-center ">{{ $numResponses }}</h1>
                    <div class="row-span-1">
                        <div class="flex flex-col  h-full text-xs text-center justify-end">
                            <h1 class="mb-2">{{ __('main.onmysubscription') }}</h1>
                          <h1 ><span class="text-valid">{{ __('main.available') }}</span>{{ $current_subscribe->num_of_responses }}</h1>
                        </div>
                    </div>
                </div>
                {{-- forms --}}
                <div class="hover:bg-gray-50 hover:shadow hover:border-secondary_blue xs:flex xs:justify-between xs:items-center grid grid-rows-3 gap-2 border-2 border-black rounded-[0.5rem] p-2 mx-1 xs:my-1 w-full">
                    <h1 class="row-span-1 text-md text-center">{{ __('main.forms') }}</h1>
                    <h1 class="text-md row-span-1 text-secondary_blue text-center ">{{ $numForms }}</h1>
                    <div class="row-span-1">
                        <div class="flex flex-col  h-full text-xs text-center justify-end">
                          <h1>{{ __('main.max_num',['num'=>$current_subscribe->num_forms]) }}</h1>

                        </div>
                    </div>
                </div>
                {{-- kiosks --}}
                <div class="hover:bg-gray-50 hover:shadow hover:border-secondary_blue xs:flex xs:justify-between xs:items-center grid grid-rows-3 gap-2 border-2 border-black rounded-[0.5rem] p-2 mx-1 xs:my-1 w-full">
                    <h1 class="row-span-1 text-md text-center">{{ __('main.kiosks') }}</h1>
                    <h1 class="text-md row-span-1 text-secondary_blue text-center ">{{ $numKiosks }}</h1>
                    <div class="row-span-1 ">
                        <div class="flex flex-col  h-full text-xs text-center justify-end ">
                          <h1>{{__('main.max_num',['num'=>$current_subscribe->num_kiosks]) }}</h1>

                        </div>
                    </div>
                </div>
                {{-- todo --}}
                <div class="hover:bg-gray-50 hover:shadow hover:border-secondary_blue xs:flex xs:justify-between xs:items-center grid grid-rows-4 gap-2 border-2  rounded-[0.5rem] p-2 mx-1 xs:my-1 w-full {{ $Todos['Open']>0?"border-primary_red":"border-black"  }}">
                    <h1 class="row-span-1 text-md text-center">{{ __('main.todo') }}</h1>
                    <h1 class="text-md row-span-1 text-secondary_blue text-center ">{{ __('main.open_num',['num'=> $Todos['Open'] ]) }}</h1>
                    <div class="row-span-2">
                        <div class="flex flex-col  h-full text-xs text-center justify-end">
                          <h1 class="my-1">{{ __('main.pending_num',['num'=> $Todos['Pending'] ]) }}</h1>
                          <h1 class="my-1">{{ __('main.inprogress_num',['num'=> $Todos['In Progress'] ]) }}</h1>
                          <h1 class="my-1">{{ __('main.closed_num',['num'=> $Todos['Closed'] ]) }}</h1>
                        </div>
                    </div>
                </div>
                {{-- tickets --}}

            </div>

        </div>
        {{-- actions --}}
        <div class="min-h-[250px] max-h-[250px] h-[250px] rounded-[0.5rem] col-span-5 row-span-1 xs:row-span-5 sm:row-span-5 md:row-span-5 lg:row-span-5 p-4 bg-white xs:col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-12">
            <div class="flex justify-between items-center">

                <div class="flex justify-between items-center">
                    <h1 class="text-sm">{{ __('main.notifications') }}</h1>
                    <div>
                        @if(count($actions)>0)
                            <svg class="w-6 h-6" viewBox="0 0 24 24" id="_24x24_On_Light_Notification-Alert" data-name="24x24/On Light/Notification-Alert" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                <g id="SVGRepo_iconCarrier"> <rect id="view-box" width="24" height="24" fill="none"/> <path id="Shape" d="M6,17v-.5H2.25A2.253,2.253,0,0,1,0,14.25v-.382a2.542,2.542,0,0,1,1.415-2.289A1.247,1.247,0,0,0,2.1,10.572l.446-4.91A6.227,6.227,0,0,1,10.618.286a5.477,5.477,0,0,0-.635,1.374A4.794,4.794,0,0,0,8.75,1.5,4.7,4.7,0,0,0,4.045,5.8L3.6,10.708A2.739,2.739,0,0,1,2.089,12.92a1.055,1.055,0,0,0-.589.949v.382A.751.751,0,0,0,2.25,15h13A.751.751,0,0,0,16,14.25v-.382a1.053,1.053,0,0,0-.586-.948A2.739,2.739,0,0,1,13.9,10.708l-.2-2.18a5.473,5.473,0,0,0,1.526.221l.166,1.822a1.26,1.26,0,0,0,.686,1.005,2.547,2.547,0,0,1,1.418,2.29v.382a2.252,2.252,0,0,1-2.25,2.25H11.5V17A2.75,2.75,0,0,1,6,17Zm1.5,0A1.25,1.25,0,0,0,10,17v-.5H7.5ZM15.047,6.744A3.486,3.486,0,0,1,13.5,6.28L13.456,5.8a4.7,4.7,0,0,0-1.648-3.185,3.5,3.5,0,0,1,.61-1.417A6.221,6.221,0,0,1,14.95,5.662l.1,1.081v0Z" transform="translate(3.25 2.25)" fill="#757575"/> <path id="Shape-2" data-name="Shape" d="M3.5,7A3.5,3.5,0,1,1,7,3.5,3.5,3.5,0,0,1,3.5,7Z" transform="translate(15 2)" fill="#ff5447"/> </g>
                            </svg>
                        @else
                        <svg class="w-6 h-6" viewBox="0 0 24 24" id="_24x24_On_Light_Notification-Alert" data-name="24x24/On Light/Notification-Alert" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier"> <rect id="view-box" width="24" height="24" fill="none"/> <path id="Shape" d="M6,17v-.5H2.25A2.253,2.253,0,0,1,0,14.25v-.382a2.542,2.542,0,0,1,1.415-2.289A1.247,1.247,0,0,0,2.1,10.572l.446-4.91A6.227,6.227,0,0,1,10.618.286a5.477,5.477,0,0,0-.635,1.374A4.794,4.794,0,0,0,8.75,1.5,4.7,4.7,0,0,0,4.045,5.8L3.6,10.708A2.739,2.739,0,0,1,2.089,12.92a1.055,1.055,0,0,0-.589.949v.382A.751.751,0,0,0,2.25,15h13A.751.751,0,0,0,16,14.25v-.382a1.053,1.053,0,0,0-.586-.948A2.739,2.739,0,0,1,13.9,10.708l-.2-2.18a5.473,5.473,0,0,0,1.526.221l.166,1.822a1.26,1.26,0,0,0,.686,1.005,2.547,2.547,0,0,1,1.418,2.29v.382a2.252,2.252,0,0,1-2.25,2.25H11.5V17A2.75,2.75,0,0,1,6,17Zm1.5,0A1.25,1.25,0,0,0,10,17v-.5H7.5ZM15.047,6.744A3.486,3.486,0,0,1,13.5,6.28L13.456,5.8a4.7,4.7,0,0,0-1.648-3.185,3.5,3.5,0,0,1,.61-1.417A6.221,6.221,0,0,1,14.95,5.662l.1,1.081v0Z" transform="translate(3.25 2.25)" fill="#cfcfcf"/> <path id="Shape-2" data-name="Shape" d="M3.5,7A3.5,3.5,0,1,1,7,3.5,3.5,3.5,0,0,1,3.5,7Z" transform="translate(15 2)" fill="#cfcfcf"/> </g>
                            </svg>
                        @endif
                    </div>
                </div>
                <div>
                    <a class="text-sm hover:cursor-pointer hover:no-underline text-secondary_blue" wire:click="showActions()">{{ __('main.showdismissedaction') }}</a>
                </div>
            </div>
            <ul class="  min-h-[200px] max-h-[200px] h-[200px] overflow-y-auto mt-2 ">
                @foreach ($actions as $action )

                 {{-- responses today --}}

                 @php
                  $desc=  app()->getLocale()=="ar"? $action->description_ar :$action->description;
                 @endphp
                   <li class="my-1"><x-action :actionType="$action->type" :action="$desc" :actionId="$action->id" :currentsubscribe="$current_subscribe"  /></li>



                @endforeach
                {{-- <x-action :action="'Your subscription is expired!'" :actionType="'subscription_expired'" actionText="Fix it" actionRoute="{{ route('subscriptions') }}" /> --}}

                    </ul>
        </div>
        {{-- chart2 --}}
        <div class=" rounded-[0.5rem] col-span-2 p-4 row-span-1 xs:row-span-5 sm:row-span-5 md:row-span-5  lg:row-span-5 bg-white xs:col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-12">
            <div class="flex justify-start items-center">
                <h1 class="text-sm">{{ __('main.mysubscription') }}</h1>
            </div>
            @if($current_subscribe!=null)
            <div class="text-md mt-4 " >


                        <span class="">{{ __('(') }}
                            <span class="{{ $current_subscribe->type=="Free"?"text-gray-400":"text-yellow-500" }}">{{$current_subscribe->type   }}</span>
                            {{ __(')') }}</span>
                        <span class="text-{{ $color }}">{{ $status }}</span>
                        <h1 class="text-{{ $color }} {{$current_subscribe->allowed_days<10?"animate-pulse":""}} mt-1">{{ __('main.daysremaining',['days'=>$current_subscribe->allowed_days]) }}</h1>

                <div class="min-h-[125px] max-h-auto h-auto flex justify-center items-center">

                      @if($statuslogic=="active")

                        <svg fill="currentColor" class="w-16 h-16 text-valid" viewBox="0 0 200 200" data-name="Layer 1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"><title/><path d="M100,15a85,85,0,1,0,85,85A84.93,84.93,0,0,0,100,15Zm0,150a65,65,0,1,1,65-65A64.87,64.87,0,0,1,100,165Zm25-91.5-29,35L76,94c-4.5-3.5-10.5-2.5-14,2s-2.5,10.5,2,14c6,4.5,12.5,9,18.5,13.5,4.5,3,8.5,7.5,14,8,1.5,0,3.5,0,5-1l3-3,22.5-27c4-5,8-9.5,12-14.5,3-4,4-9,.5-13L138,71.5c-3.5-2.5-9.5-2-13,2Z"/></svg>
                      @elseif($statuslogic=="expiredgrace")

                        <svg class="w-16 h-16"  viewBox="0 0 14 14" role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(.23100119 .14285704) scale(.28571)">
                        <circle cx="17" cy="17" r="14" fill="gray"/>
                        <circle cx="17" cy="17" r="11" fill="#eee"/>
                        <path d="M16 8h2v9h-2z"/>
                        <path d="M22.6545993 20.9544007l-1.69680008 1.69680008-4.80760014-4.80760014 1.69680007-1.69680007z"/>
                        <circle cx="17" cy="17" r="2"/>
                        <circle cx="17" cy="17" r="1" fill="gray"/>
                        <path fill="#ffc107" d="M11.9 42l14.4-24.1c.8-1.3 2.7-1.3 3.4 0L44.1 42c.8 1.3-.2 3-1.7 3H13.6c-1.5 0-2.5-1.7-1.7-3z"/>
                        <path d="M26.4 39.9c0-.2 0-.4.1-.6.1-.2.2-.3.3-.5.1-.2.3-.2.5-.3.2-.1.4-.1.6-.1.2 0 .5 0 .7.1.2.1.4.2.5.3.1.1.2.3.3.5.1.2.1.4.1.6 0 .2 0 .4-.1.6-.1.2-.2.3-.3.5-.1.2-.3.2-.5.3-.2.1-.4.1-.7.1-.3 0-.5 0-.6-.1-.1-.1-.4-.2-.5-.3-.1-.1-.2-.3-.3-.5-.1-.2-.1-.4-.1-.6zm2.8-3.1h-2.3l-.4-9.8h3l-.3 9.8z"/>
                        </g>
                        </svg>
                      @else

                        <svg class="w-16 h-16" fill="#545454" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" stroke="#545454">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                        <g id="SVGRepo_iconCarrier"> <g> <path d="M33,85h34c5.514,0,10-4.605,10-10.119v-22c0-5.514-4.486-10-10-10v-8.167C67,25.432,59.545,18,50.382,18h-0.334 C40.647,18,33,25.432,33,34.714v8.167c-5.514,0-10,4.486-10,10v22C23,80.395,27.486,85,33,85z M37,34.714 C37,27.638,42.854,22,50.048,22h0.334C57.457,22,63,27.518,63,34.714V43H37V34.714z M73,75c0,3.313-2.687,6-6,6H33 c-3.313,0-6-2.687-6-6V53c0-3.313,2.687-6,6-6h34c3.313,0,6,2.687,6,6V75z"/> <path d="M47,66.785v4.221C47,72.594,48.287,74,49.875,74h0.25C51.713,74,53,72.594,53,71.006v-4.359 c1.798-1.068,3.007-3.023,3.007-5.266c0-3.383-2.742-6.125-6.125-6.125s-6.125,2.742-6.125,6.125 C43.757,63.722,45.07,65.754,47,66.785z"/> </g> </g>
                        </svg>
                      @endif
                </div>
                @if($current_subscribe->expired_at->isPast())
                <div class="flex justify-end items-center  ">
                    <a class="inline-flex items-center p-1 bg-secondary_blue
                    border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                    active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3 " href="{{ route('subscriptions') }}">{{ __('Fix it') }}
                    </a>
                </div>
                @endif
            </div>
            @endif
        </div>
        {{-- forms --}}
        <div wire:ignore class="rounded-[0.5rem] col-span-5 row-span-2 xs:row-span-5 sm:row-span-5 md:row-span-5 lg:row-span-5 p-4 bg-white xs:col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-12 ">
            <div class="flex justify-between" >
                <h1 class=" text-sm" >{{ __('main.forms') }}</h1>
                <div class="" >
                  @php
                      $active_num=0;
                      $inactive_num=0;
                      foreach($forms as $form)
                      if($form->form_type_id == 1)
                      $form->active?$active_num+=1:$inactive_num+=1;
                  @endphp
                  <span class="text-btn text-xs mr-2 ml-2" >{{ __('main.active_num',['num'=>$active_num]) }}</span>
                  <span class="text-btn text-xs mr-2 ml-2 " >{{ __('main.inactive_num',['num'=>$inactive_num]) }}</span>
                 </div>
              </div>
              <div class="mt-2    w-full overflow-hidden h-auto" >
                  <div class="mt-2 min-h-[150px] max-h-[150px] h-[150px] owl_forms owl-carousel owl-theme flex justify-center align--center  px-2">



                  @foreach($forms as $form)


                      <div  wire:key="{{ $form->id }}"    class="  item relative  w-full " >

                        <div
                        data-bs-toggle="tooltip"  data-bs-html="true"
                        @if($form->form_type_id == 1) title="Click to View Statistics of this form" @endif
                        {{ $form->form_type_id == 1 ? 'onclick=ShowStatisticsForm('.$form->id.')' : '' }}
                          class="hover:cursor-pointer max-h-28 min-h-28 h-28 px-2 pb-2 border-secondary_blue border-[1px] hover:border-2 hover:z-50 hover:shadow-inner hover:-translate-y-2 p-3 rounded-[0.5rem] xs:w-full w-full " >
                                <div class=" mb-2   flex justify-between items-center  " >
                                    <div class="flex items-center justify-start" >
                                        @if($form->form_type_id == 1)
                                        <svg class="w-8 h-8" viewBox="0 0 512 512" enable-background="new 0 0 512 512" id="Layer_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                            <g id="SVGRepo_iconCarrier"> <g> <g> <path d="M450.255,434.511H61.745c-13.257,0-24.042-10.786-24.042-24.042V101.532 c0-13.257,10.785-24.042,24.042-24.042h388.511c13.257,0,24.042,10.786,24.042,24.042v308.937 C474.298,423.725,463.513,434.511,450.255,434.511z M61.745,97.489c-2.229,0-4.042,1.813-4.042,4.042v308.937 c0,2.229,1.813,4.042,4.042,4.042h388.511c2.229,0,4.042-1.813,4.042-4.042V101.532c0-2.229-1.813-4.042-4.042-4.042H61.745z" fill="#2d4b71"/> </g> <g> <path d="M450.117,163.589H63.655c-13.298,0-24.118-10.785-24.118-24.042v-38.015 c0-13.257,10.819-24.042,24.118-24.042h386.462c13.298,0,24.118,10.786,24.118,24.042v38.015 C474.235,152.804,463.416,163.589,450.117,163.589z M63.655,97.489c-2.271,0-4.118,1.813-4.118,4.042v38.015 c0,2.229,1.847,4.042,4.118,4.042h386.462c2.271,0,4.118-1.813,4.118-4.042v-38.015c0-2.229-1.847-4.042-4.118-4.042H63.655z" fill="#2d4b71"/> </g> <g> <path d="M93.73,128.69c-2.63,0-5.21-1.06-7.07-2.92c-1.86-1.87-2.93-4.44-2.93-7.07c0-2.64,1.07-5.21,2.93-7.08 c1.86-1.86,4.44-2.92,7.07-2.92c2.63,0,5.21,1.06,7.07,2.92c1.86,1.87,2.93,4.44,2.93,7.08c0,2.63-1.07,5.21-2.93,7.07 C98.94,127.63,96.36,128.69,93.73,128.69z" fill="#2d4b71"/> </g> <g> <path d="M142.49,128.69c-2.64,0-5.21-1.06-7.07-2.92c-1.86-1.86-2.93-4.44-2.93-7.07c0-2.64,1.07-5.22,2.93-7.08 c1.86-1.86,4.43-2.92,7.07-2.92c2.63,0,5.21,1.06,7.07,2.92c1.86,1.86,2.93,4.44,2.93,7.08c0,2.63-1.07,5.21-2.93,7.07 C147.7,127.63,145.12,128.69,142.49,128.69z" fill="#2d4b71"/> </g> <g> <path d="M130.769,224.768c-2.508,0-5.002-0.94-6.921-2.78l-10.631-10.188c-3.987-3.821-4.123-10.151-0.301-14.139 c3.821-3.987,10.15-4.123,14.139-0.301l4.694,4.498l23.393-16.432c4.52-3.173,10.757-2.083,13.931,2.435 c3.174,4.52,2.084,10.757-2.435,13.931l-30.123,21.158C134.78,224.169,132.77,224.768,130.769,224.768z" fill="#2d4b71"/> </g> <g> <path d="M136.164,305.05c-2.508,0-5.002-0.94-6.921-2.78l-10.631-10.188c-3.987-3.821-4.123-10.151-0.301-14.139 c3.821-3.987,10.15-4.123,14.139-0.301l4.694,4.498l23.393-16.432c4.521-3.173,10.757-2.083,13.931,2.435 c3.174,4.52,2.084,10.757-2.435,13.931l-30.123,21.158C140.175,304.451,138.165,305.05,136.164,305.05z" fill="#2d4b71"/> </g> <g> <path d="M151.512,374.753h-31.377c-5.523,0-10-4.477-10-10s4.477-10,10-10h31.377c5.523,0,10,4.477,10,10 S157.035,374.753,151.512,374.753z" fill="#2d4b71"/> </g> <g> <path d="M379.69,214.189H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,214.189,379.69,214.189z" fill="#2d4b71"/> </g> <g> <path d="M379.69,294.989H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,294.989,379.69,294.989z" fill="#2d4b71"/> </g> <g> <path d="M379.69,374.753H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,374.753,379.69,374.753z" fill="#2d4b71"/> </g> <g> <path d="M464.298,410.468c0,7.755-6.287,14.042-14.042,14.042H61.745c-7.755,0-14.042-6.287-14.042-14.042V101.532 c0-7.755,6.287-14.042,14.042-14.042h388.511c7.755,0,14.042,6.287,14.042,14.042V410.468z" fill="#e0e0e0"/> <path d="M450.255,434.511H61.745c-13.257,0-24.042-10.786-24.042-24.042V101.532 c0-13.257,10.785-24.042,24.042-24.042h388.511c13.257,0,24.042,10.786,24.042,24.042v308.937 C474.298,423.725,463.513,434.511,450.255,434.511z M61.745,97.489c-2.229,0-4.042,1.813-4.042,4.042v308.937 c0,2.229,1.813,4.042,4.042,4.042h388.511c2.229,0,4.042-1.813,4.042-4.042V101.532c0-2.229-1.813-4.042-4.042-4.042H61.745z" fill="#2d4b71"/> </g> <g> <path d="M464.235,139.547c0,7.755-6.321,14.042-14.118,14.042H63.655c-7.797,0-14.118-6.287-14.118-14.042v-38.015 c0-7.755,6.321-14.042,14.118-14.042h386.462c7.797,0,14.118,6.287,14.118,14.042V139.547z" fill="#1277d1"/> <path d="M450.117,163.589H63.655c-13.298,0-24.118-10.785-24.118-24.042v-38.015 c0-13.257,10.819-24.042,24.118-24.042h386.462c13.298,0,24.118,10.786,24.118,24.042v38.015 C474.235,152.804,463.416,163.589,450.117,163.589z M63.655,97.489c-2.271,0-4.118,1.813-4.118,4.042v38.015 c0,2.229,1.847,4.042,4.118,4.042h386.462c2.271,0,4.118-1.813,4.118-4.042v-38.015c0-2.229-1.847-4.042-4.118-4.042H63.655z" fill="#2d4b71"/> </g> <g> <path d="M93.73,128.69c-2.63,0-5.21-1.06-7.07-2.92c-1.86-1.87-2.93-4.44-2.93-7.07c0-2.64,1.07-5.21,2.93-7.08 c1.86-1.86,4.44-2.92,7.07-2.92c2.63,0,5.21,1.06,7.07,2.92c1.86,1.87,2.93,4.44,2.93,7.08c0,2.63-1.07,5.21-2.93,7.07 C98.94,127.63,96.36,128.69,93.73,128.69z" fill="#2d4b71"/> </g> <g> <path d="M142.49,128.69c-2.64,0-5.21-1.06-7.07-2.92c-1.86-1.86-2.93-4.44-2.93-7.07c0-2.64,1.07-5.22,2.93-7.08 c1.86-1.86,4.43-2.92,7.07-2.92c2.63,0,5.21,1.06,7.07,2.92c1.86,1.86,2.93,4.44,2.93,7.08c0,2.63-1.07,5.21-2.93,7.07 C147.7,127.63,145.12,128.69,142.49,128.69z" fill="#2d4b71"/> </g> <g> <path d="M130.769,224.768c-2.508,0-5.002-0.94-6.921-2.78l-10.631-10.188c-3.987-3.821-4.123-10.151-0.301-14.139 c3.821-3.987,10.15-4.123,14.139-0.301l4.694,4.498l23.393-16.432c4.52-3.173,10.757-2.083,13.931,2.435 c3.174,4.52,2.084,10.757-2.435,13.931l-30.123,21.158C134.78,224.169,132.77,224.768,130.769,224.768z" fill="#2d4b71"/> </g> <g> <path d="M136.164,305.05c-2.508,0-5.002-0.94-6.921-2.78l-10.631-10.188c-3.987-3.821-4.123-10.151-0.301-14.139 c3.821-3.987,10.15-4.123,14.139-0.301l4.694,4.498l23.393-16.432c4.521-3.173,10.757-2.083,13.931,2.435 c3.174,4.52,2.084,10.757-2.435,13.931l-30.123,21.158C140.175,304.451,138.165,305.05,136.164,305.05z" fill="#2d4b71"/> </g> <g> <path d="M151.512,374.753h-31.377c-5.523,0-10-4.477-10-10s4.477-10,10-10h31.377c5.523,0,10,4.477,10,10 S157.035,374.753,151.512,374.753z" fill="#2d4b71"/> </g> <g> <path d="M379.69,214.189H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,214.189,379.69,214.189z" fill="#2d4b71"/> </g> <g> <path d="M379.69,294.989H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,294.989,379.69,294.989z" fill="#2d4b71"/> </g> <g> <path d="M379.69,374.753H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,374.753,379.69,374.753z" fill="#2d4b71"/> </g> </g> </g>
                                        </svg>
                                        @elseif ($form->form_type_id == 2)
                                        <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                        <svg class="w-8 h-8" viewBox="-102.4 -102.4 1228.80 1228.80" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                        <g id="SVGRepo_iconCarrier">
                                        <path d="M960 1002.666667H64a42.666667 42.666667 0 0 1-42.666667-42.666667V64a42.666667 42.666667 0 0 1 42.666667-42.666667h896a42.666667 42.666667 0 0 1 42.666667 42.666667v896a42.666667 42.666667 0 0 1-42.666667 42.666667z" fill="#2d4b71"/>
                                        <path d="M64 64h896v682.666667H64zM896 896H597.333333a21.333333 21.333333 0 1 1 0-42.666667h298.666667a21.333333 21.333333 0 1 1 0 42.666667z" fill="#e0e0e0"/>
                                        <path d="M661.333333 896H128a21.333333 21.333333 0 1 1 0-42.666667h533.333333a21.333333 21.333333 0 1 1 0 42.666667z" fill="#1277d1"/>
                                        <path d="M640 960c-47.04 0-85.333333-38.293333-85.333333-85.333333s38.293333-85.333333 85.333333-85.333334 85.333333 38.293333 85.333333 85.333334-38.293333 85.333333-85.333333 85.333333zM426.666667 554.666667a21.269333 21.269333 0 0 1-21.333334-21.333334V277.333333a21.333333 21.333333 0 0 1 33.173334-17.749333l192 128a21.333333 21.333333 0 0 1 0 35.498667l-192 128A21.333333 21.333333 0 0 1 426.666667 554.666667z" fill="#1277d1"/>
                                        </g>
                                        </svg>
                                        @endif
                                    </div>
                                    @if($form->form_type_id == 1)
                                    <div class=" flex justify-end  items-center">
                                        <div class="mr-1 pb-1 text-center text-xs m-1  col-span-6 h-4 " >
                                            <span class=" text-xs whitespace-nowrap text-bold {{ $form->active!=true?'text-red-500':'text-green-600' }}" >{{ $form->active!=true?__('main.inactive'):__('main.active') }}</span>
                                        </div>
                                    </div>
                                    @endif



                                </div>
                                <div class="  grid w-full justify-start items-center " >

                                        <div class="flex justify-start items-center text-center whitespace-nowrap overflow-hidden">
                                            <span data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $form->form_title }}" class="text-xs text-left font-bold text-secondary_blue">
                                                {{ $form->form_title }}
                                            </span>
                                        </div>


                                        {{-- <div class="flex justify-center items-center text-center whitespace-nowrap overflow-hidden ">
                                            <span data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $this->questions_count($form->id) }}" class="text-xs ">
                                                {{ $this->questions_count($form->id) }}{{ __(' Questions') }}
                                            </span>
                                        </div> --}}
                                        <div class="flex justify-start items-center text-center whitespace-nowrap overflow-hidden ">

                                            @switch($form->form_type_id)
                                                @case(1)
                                                <span data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $form->responses_count }}" class="text-xs text-left">
                                                    {{ __('main.responses_num',['num'=>$form->responses_count]) }}
                                                </span>
                                                    @break
                                                @case(2)
                                                    <span data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $form->media_count }}" class="text-xs text-left">
                                                     {{ __('main.mediacontent_num',['num'=>$form->media_count]) }}
                                                    </span>
                                                    @break
                                                @default

                                            @endswitch

                                        </div>




                                </div>
                                <div class="flex justify-end items-center">
                                    @if($form->devices_count>0)
                                        <svg class="w-4 h-4 m-1 text-valid" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                        </svg>
                                    @endif
                                 </div>

                        </div>

                      </div>

                  @endforeach




                  </div>
              </div>
              <div class=" flex xs:justify-center justify-end ">

                  <a class="inline-flex items-center p-1 bg-secondary_blue
                  border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                   active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3"
                   href="{{ route('forms')}}">
                     {{ __('main.viewall') }}
                </a>
            </div>
        </div>
        {{-- kiosk --}}
        <div wire:ignore class=" rounded-[0.5rem] col-span-5 p-4 row-span-2 xs:row-span-5 sm:row-span-5 lg:row-span-5 md:row-span-5 bg-white xs:col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-12">
            <div class="flex justify-between" >
                <h1 class="text-sm" >{{ __('main.kiosks') }}</h1>
                 <div class="" >
                     @php
                        $count_kiosks=count($kiosks);
                        $inservice=0;
                        $outofservice=0;
                        foreach ($kiosks as $kiosk) {
                        $kiosk->in_service?$inservice+=1:$outofservice+=1;
                        }

                     @endphp
                    <span class="text-btn text-xs mr-2 ml-2" >{{ __('main.inservice_num',['num'=>$inservice]) }} </span>
                    <span class="text-btn text-xs mr-2 ml-2 " >{{ __('main.outofservice_num',['num'=>$outofservice]) }} </span>
                 </div>
                </div>

                <div class="mt-2   w-full overflow-hidden h-auto" >
                    <div class= " mt-2 min-h-[150px] max-h-[150px] h-[150px]   owl_kiosks owl-carousel owl-theme flex justify-center align-center  px-2">

                        @foreach($kiosks as $i => $kiosk)
                            <div  class="item relative  w-full " >
                                <div class="hover:cursor-pointer max-h-28 min-h-28 h-28 px-2 pb-2 border-secondary_blue border-[1px] hover:border-2 hover:z-50 hover:shadow-inner hover:-translate-y-2 p-3 rounded-[0.5rem] xs:w-full w-full " >
                                    <div class=" mb-2  flex justify-between  " >


                                            {{-- kiosk icon --}}
                                            <div class="col-span-2 relative">
                                                <div>
                                                    <svg class=" w-8 h-8" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" width="800px" height="800px" fill="#2d4b71" stroke="#2d4b71" stroke-width="0.00512">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <g id="SVGRepo_iconCarrier"> <g> <ellipse style="fill:#1277d1;" cx="256" cy="414.302" rx="93.936" ry="38.661"/> <path style="fill:#1277d1;" d="M265.404,414.302h-18.808c-5.771,0-10.449-4.678-10.449-10.449v-52.245h39.706v52.245 C275.853,409.624,271.175,414.302,265.404,414.302z"/> <path style="fill:#1277d1;" d="M483.265,351.608H28.735c-11.542,0-20.898-9.356-20.898-20.898V79.935 c0-11.542,9.356-20.898,20.898-20.898h454.531c11.542,0,20.898,9.356,20.898,20.898V330.71 C504.163,342.252,494.807,351.608,483.265,351.608z"/> </g> <rect x="39.184" y="90.384" style="fill:#e0e0e0;" width="433.633" height="219.429"/> <path d="M483.265,51.2H28.735C12.89,51.2,0,64.091,0,79.935V330.71c0,15.844,12.89,28.735,28.735,28.735H228.31v10.015 c-37.954,4.688-74.083,19.875-74.083,44.842c0,26.508,43.753,46.498,101.773,46.498s101.773-19.99,101.773-46.498 c0-24.967-36.129-40.152-74.083-44.842v-10.015h199.576c15.845,0,28.735-12.891,28.735-28.735V79.935 C512,64.091,499.11,51.2,483.265,51.2z M325.251,396.856c10.707,5.392,16.849,11.751,16.849,17.446 c0,12.871-32.755,30.824-86.1,30.824s-86.1-17.953-86.1-30.824c0-5.695,6.141-12.054,16.848-17.446 c10.747-5.413,25.283-9.443,41.561-11.595v18.592c0,10.082,8.203,18.286,18.286,18.286h18.808c10.082,0,18.286-8.204,18.286-18.286 v-18.592C299.967,387.414,314.504,391.444,325.251,396.856z M268.016,403.853c0,1.441-1.172,2.612-2.612,2.612h-18.808 c-1.44,0-2.612-1.171-2.612-2.612v-44.408h24.033V403.853z M496.327,330.71c0,7.203-5.859,13.061-13.061,13.061H28.735 c-7.202,0-13.061-5.859-13.061-13.061V79.935c0-7.202,5.859-13.061,13.061-13.061h454.531c7.202,0,13.061,5.859,13.061,13.061 V330.71z"/> <path d="M31.347,317.649h449.306V82.547H31.347V317.649z M47.02,98.22H464.98v203.755H47.02V98.22z"/> </g>
                                                        </svg>
                                                </div>
                                            </div>
                                            {{-- Kiosk code --}}
                                            <div class="col-span-2  flex justify-center items-center ">
                                                <span class="text-xs font-bold text-black">{{ $kiosk->device_code }}</span>
                                            </div>
                                            {{-- menu --}}
                                            {{-- <div class="col-span-2  flex justify-end items-center text-xs">
                                                <x-jet-dropdown align="false" id="{{ $i }}"  width="40">
                                                    <x-slot name="trigger">
                                                        <span class="inline-flex  rounded-md">

                                                            <button type="button" class="no-underline hover:no-underline focus:no-underline
                                                            focus:outline-none inline-flex items-center
                                                            text-sm leading-4 font-medium  text-gray-500

                                                            transition">

                                                            <svg class="text-secondary_blue h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
                                                              </svg>
                                                            </button>
                                                        </span>
                                                    </x-slot>

                                                    <x-slot name="content">
                                                        <div class="w-40">


                                                            <div class="border-t border-gray-100"></div>



                                                            <div class="flex ml-2 my-1 mr-2">
                                                                <a href="{{ route('kiosks') }}"  class="hover:font-bold hover:text-blue-400 no-underline hover:no-underline focus:no-underline" href="">{{ __('Edit') }}</a>
                                                            </div>

                                                            <div class="flex ml-2 my-1 mr-2">
                                                                {{ __('In Service') }}
                                                                <label class="ml-1 relative inline-flex items-center cursor-pointer">

                                                                    <input type="checkbox" wire:click="changekioskservice({{ $kiosk->id }})"  value="" {{ $kiosk->in_service?"checked":"" }} class="sr-only peer">
                                                                    <div class="w-6 h-3 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                                                        peer-focus:ring-blue-300  rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-['']
                                                                        after:absolute  after:bg-white after:border-gray-300 after:border
                                                                        after:rounded-full after:h-3 after:w-3 after:transition-all  peer-checked:bg-blue-600"></div>

                                                                </label>
                                                            </div>

                                                            <div class="flex ml-2 my-1 mr-2">
                                                                <a href="{{ route('kiosks') }}" class="hover:font-bold hover:text-blue-400 no-underline hover:no-underline focus:no-underline"  href="">{{ __('Change Form') }}</a>
                                                            </div>

                                                            <div class="flex ml-2 my-1 mr-2">
                                                                <a  class="hover:font-bold hover:text-blue-400 no-underline hover:no-underline focus:no-underline"  href="">{{ __('Update Status') }}</a>
                                                            </div>



                                                        </div>
                                                    </x-slot>
                                                </x-jet-dropdown>
                                            </div> --}}

                                    </div>
                                    <div class="  grid w-full justify-start items-center " >

                                            <div class="flex justify-start items-center  whitespace-nowrap overflow-hidden"><span data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $kiosk->device_name }}" class="text-xs text-left">{{ $kiosk->device_name }}</span></div>


                                            <div class="flex justify-start items-center  whitespace-nowrap overflow-hidden">
                                                <span data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $kiosk->form_title?$kiosk->form_title:"No Form" }}" class="text-xs text-left font-bold {{ $kiosk->form_title?"text-secondary_blue":"text-primary_red" }}">
                                                    @if($kiosk->sign_kiosk==false&&$kiosk->form_id==null)
                                                    {{ __(' ⏱ ') }}{{ __('Stand-By') }}
                                                    @else
                                                    {{ $kiosk->form_type_id == 1 ? __(' ✎ ') : __(' ▶ ') }} {{ $kiosk->form_title }}
                                                    @endif
                                                </span>
                                            </div>

                                    </div>

                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>

                <div class=" flex xs:justify-center justify-end ">
                    <a class="inline-flex items-center p-1 bg-secondary_blue
                                 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                                  active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3"
                                  href="{{ route('kiosks') }}">
                                    {{ __('main.viewall') }}
                    </a>
                </div>
        </div>
        {{-- chart1 --}}
        <div class="relative rounded-[0.5rem] col-span-2 row-span-2 xs:row-span-5 sm:row-span-5 md:row-span-5 lg:row-span-5 p-4 bg-white xs:col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-12">
            <div class="flex justify-start items-center">
                <h1 class="text-sm">{{ __('main.support_help') }}</h1>
            </div>
            {{-- @php
                $level=70;
            @endphp
            <div  class=" grid justify-center items-center mt-10 bottom-0 pointer-events-none ">
                <div style="background: conic-gradient(#1277D1 {{ $level }}%, #F1F3E7 0 100%)" id="rating"   class="rating select-none">
                <span class="text-black">{{ __('70%') }}</span>
                </div>
            </div> --}}
            <div class=" mt-5  xs:justify-center xs:items-center grid grid-rows-4 gap-2 rounded-[0.5rem] p-2 mx-1 xs:my-1 w-full">

                    <h1 class="text-md row-span-1 text-secondary_blue text-center ">{{ __('main.opentickets_num',['num'=>$tickets['Open']]) }}</h1>
                    <div class="row-span-2">
                        <div class="flex flex-col  h-full text-sm text-center justify-end">
                            <h1 class="my-1" >{{ __('main.pending_num',['num'=>$tickets['Pending']]) }}</h1>
                            <h1 class="my-1">{{ __('main.inprogress_num',['num'=>$tickets['In Progress']]) }}</h1>
                            <h1 class="my-1">{{ __('main.closed_num',['num'=>$tickets['Closed']]) }}</h1>
                          </div>
                    </div>
                    <div class="row-span-1 flex xs:justify-center justify-end items-center  absolute bottom-4 right-4">
                        <a href="{{ route('support') }}" class="inline-flex items-center p-1 bg-secondary_blue
                        border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                         active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3">
                          {{ __('main.viewall') }}
                        </a>
                  </div>
            </div>

        </div>
         {{-- chart responses --}}
        <div wire:ignore class="rounded-[0.5rem] col-span-5 p-4 row-span-2 xs:row-span-5 sm:row-span-5 lg:row-span-5 md:row-span-5 bg-white xs:col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-12">
            <div class="flex justify-between items-center " >
                <span class="text-sm" >{{__('main.formsinteractiverate')  }}</span>
                <a id="button-responses_forms" onclick="showLegend('responses_forms')" class="text-secondary_blue text-sm hover:cursor-pointer hover:no-underline">{{ __('main.hidelabels') }}</a>

            </div>
            <div  class="flex w-full justify-center  px-5 p-2 bg-btn text-white items-center">
                {{-- <canvas id="allresponses_dates" class="w-full max-h-72"></canvas> --}}
                <canvas id="responses_forms" class="w-full max-h-72"></canvas>
            </div>
        </div>
        {{-- chart kiosks --}}
        <div wire:ignore class="rounded-[0.5rem] col-span-5 p-4 row-span-2 xs:row-span-5 sm:row-span-5 lg:row-span-5 md:row-span-5 bg-white xs:col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-12">
            <div class="flex justify-between items-center " >
                <span class="text-sm" >{{__('main.kiosksusagerate')  }}</span>
                <a id="button-responses_kiosks" onclick="showLegend('responses_kiosks')" class="text-secondary_blue text-sm hover:cursor-pointer hover:no-underline">{{ __('main.hidelabels') }}</a>

            </div>
            <div  class="flex w-full justify-center  px-5 p-2 bg-btn text-white items-center">
                {{-- <canvas id="allresponses_dates" class="w-full max-h-72"></canvas> --}}
                <canvas id="responses_kiosks" class="w-full max-h-72"></canvas>
            </div>
        </div>

    </div>
</div>
@push('scripts')
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js')}}"></script>

 <script>
     var translations = @json(__('main'));

    var chartInstances=[];
    var responsesDataChart;
    var responsesPerForm;
    var responsesPerKiosk;
    var colorArray=[     "#1E88E5","#E53935","#FDD835","#43A047","#546E7A","#FB8C00","#6D4C41","#8E24AA","#C0CA33","#00ACC1",
                            "#42A5F5","#EF5350","#FFEE58","#66BB6A","#78909C","#FFA726","#8D6E63","#AB47BC","#D4E157","#26C6DA",
                            "#90CAF9","#EF9A9A","#FFF59D","#A5D6A7","#B0BEC5","#FFCC80","#BCAAA4","#CE93D8","#E6EE9C","#80DEEA",
                            "#1565C0","#B71C1C","#F57F17","#1B5E20","#263238","#E65100","#3E2723","#4A148C","#827717","#006064",
                            "#E3F2FD","#FFEBEE","#FFFDE7","#E8F5E9","#ECEFF1","#FFF3E0","#D7CCC8","#F3E5F5","#F0F4C3","#B2EBF2",

            ];
document.addEventListener("DOMContentLoaded", () => {
        //  charts
        responsesDataChart=@this.responsesDataChart;
        responsesPerForm=@this.responsesPerForm;
        responsesPerKiosk=@this.responsesPerKiosk;
        console.log(responsesPerForm);
        // buildChartResponsesDates();
        drawResponsesFormChart();
        drawResponsesKioskChart();
        setCarouselOptions();
    });
    // responses/Form chart
function drawResponsesFormChart(){
    const data =
        {
            labels:responsesPerForm['labels'],
            datasets:
            [{
                label:'Responses/Form',
                data:responsesPerForm['data'],
                backgroundColor:colorArray,
                borderColor: ['transparent'],
                borderWidth: 1
            }]
        };

        // config
        const config =
        {
            type: 'doughnut',
            data,
            options: {
                cutoutPercentage: 75,
                responsive: true,
                legend: {
                    position: 'right',
                },
                plugins: {

            },

            }}


        // render init block
        pie_chart = new Chart(
        document.getElementById('responses_forms'),
        config
        );
        console.log(pie_chart);
        chartInstances['responses_forms']=pie_chart;
}
// responses/kiosk chart
function drawResponsesKioskChart(){
    const data =
        {
            labels:responsesPerKiosk['labels'],
            datasets:
            [{
                label:'responses/kiosk',
                data:responsesPerKiosk['data'],
                backgroundColor:colorArray,
                borderColor: ['transparent'],
                borderWidth: 1
            }]
        };

        // config
        const config =
        {
            type: 'doughnut',
            data,
            options: {
                cutoutPercentage: 75,
                responsive: true,
                legend: {
                    position: 'right',
                },
                plugins: {

            }}

        };
        // render init block
        pie_chart = new Chart(
        document.getElementById('responses_kiosks'),
        config
        );
        chartInstances['responses_kiosks']=pie_chart;

}
function showLegend(id) {

    var chart = chartInstances[id]; // Replace with your chart instance
    var currentDisplay = chart.options.legend.display;
    chart.options.legend.display = !currentDisplay; // Toggle the display status
    chart.update(); // Update the chart to apply changes

    var button = document.getElementById(`button-${id}`); // Replace with your button's ID
    if (currentDisplay) {
        button.innerText = translations.showlabels;
    } else {
        button.innerText = translations.hidelabels;
    }
}
 function setCarouselOptions(){
    var $owl_forms = $('.owl_forms');
    var $owl_kiosks = $('.owl_kiosks');
        //     $owl.trigger('destroy.owl.carousel');

        //    $owl.find('.owl-stage-outer').removeClass('owl-loaded');
            //    $(owl).owlCarousel($(owl).data()); // Initialize Owl carousel once again with same config options

            $owl_forms.owlCarousel({
                loop:false,
            margin:10,
            nav:false,
            responsiveClass:true,
            // navText: ["<div class=''><</div>", "<div class=''>></div>"],

            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                },
                1800:{items:3}
            }
    });
    $owl_kiosks.owlCarousel({
                loop:false,
            margin:10,
            nav:false,
            responsiveClass:true,
            // navText: ["<div class=''><</div>", "<div class=''>></div>"],

            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                },
                1800:{items:3}
            }
    });
 }
//  ShowStatisticsForm
function ShowStatisticsForm(id){
    window.location.href=`/statistics/overview/${id}`;
}

 function buildChartResponsesDates(){
    const data = {
        labels:responsesDataChart['labels'],
        datasets: [{
            label: 'Responses',
            data: responsesDataChart['data'],
            backgroundColor: [
            'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
            'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        }]
        };

        // config
        const config = {
        type: 'line',
        data,
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }


        }
        };

        // render init block
        responses_date = new Chart(
        document.getElementById('allresponses_dates'),
        config
        );
 }
     window.addEventListener('contentdashChanged', event => {
        window.location.reload();

        });

 </script>
@endpush
