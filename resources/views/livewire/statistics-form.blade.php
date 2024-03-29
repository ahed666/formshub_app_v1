@push('styles')
<link
  rel="stylesheet"
  href="{{ asset('/styles/index.min.css') }}" />
  <link  rel="stylesheet" href="{{ asset('styles/bootstrap.min.css')}}">
   {{-- <link rel="stylesheet" href="{{ asset('styles/sortable.min.css') }}"> --}}


@endpush
<div wire:loading.class="disabled opacity-50" class="">

    <div wire:loading.class="opacity-50" wire:Target="refreshdata"  class="grid grid-rows-12   mt-2 ">

        <div class=" w-full  mb-2 flex justify-between items-center p-2 pl-4 bg-white drop-shadow     rounded-[0.5rem] ">

            <div class="grid justify-start items-center  w-1/4 p-2  " >
                <span class="text-sm">{{ __('main.formtitle') }}</span>
                <span class="  text-md xs:text-xs font-bold" >{{ $current_form->form_title }}</span>
            </div>
            <div class="flex  items-center xs:grid gap-1">
                <div class="bg-primary_blue ml-2 mr-2 p-2  h-[75px] w-42 border-[1px] border-gray-300 rounded-[0.5rem] xs:p-1 xs-ml-1 xs:mr-1">
                    @php

                    @endphp
                    <div class=" text-sm xs:text-xs flex justify-start  items-center text-left "><span class=" mr-[2px]  ">{{ __('main.scoreaverage') }}</span><x-progress-bar :value="round($averagescore, 1)" class="bg-yellow-300" /></div>
                    <div class=" text-sm xs:text-xs flex justify-start  items-center text-left "><span class=" mr-[2px]  ">{{ __('main.completionaverage') }}</span><x-progress-bar :value="round($completPercent, 1)" class="bg-valid" /></div>
               </div>
                {{-- Responses info --}}
                <div class="bg-primary_blue ml-2 mr-2 p-2  h-[75px] w-42 border-[1px] border-gray-300 rounded-[0.5rem] xs:p-1 xs-ml-1 xs:mr-1">
                    <div class=" text-sm xs:text-xs flex justify-start  items-center text-left "><span class=" mr-[2px]  ">{{ __('main.totalresponses_num',['num'=>$totalresponses]) }}</span></div>
                    {{-- <div class=" text-sm xs:text-xs flex justify-start  items-center text-left"><span class=" mr-[2px]  ">{{ __('Terms Disagreed : ') }}</span><span class="text-secondary_blue" >{{ $canceledResponsesNum }}</span></div> --}}
                    <div class=" text-sm xs:text-xs flex justify-start  items-center text-left"><span class=" mr-[2px]  ">{{ __('main.todo_num',['num'=>$totaltodos]) }}</span></div>


                </div>
               {{-- refresh --}}
               <div class=" rounded-lg ml-8 w-1/8   mr-2 p-2 xs:p-1 xs-ml-1 xs:mr-1">
                    <div class="flex justify-center items-center"><svg wire:click="refreshdata"
                        class="hover:cursor-pointer w-6 h-6 hover:text-blue-600 hover:z-[9999] hover:shadow-inner"
                        xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 40 40" >
                        <path fill="#8bb7f0" d="M4.207,35.5l2.573-2.574l-0.328-0.353C3.259,29.143,1.5,24.677,1.5,20C1.5,9.799,9.799,1.5,20,1.5 c0.776,0,1.598,0.062,2.5,0.19v4.032C21.661,5.575,20.823,5.5,20,5.5C12.005,5.5,5.5,12.005,5.5,20 c0,3.578,1.337,7.023,3.765,9.701l0.353,0.389l2.883-2.883V35.5H4.207z"/><path fill="#4e7ab5" d="M20,2c0.627,0,1.287,0.042,2,0.129v3.009C21.33,5.046,20.661,5,20,5C11.729,5,5,11.729,5,20 c0,3.702,1.383,7.267,3.894,10.037l0.705,0.778l0.743-0.743L12,28.414V35H5.414l1.379-1.379l0.682-0.682l-0.657-0.706 C3.711,28.895,2,24.551,2,20C2,10.075,10.075,2,20,2 M20,1C9.507,1,1,9.507,1,20c0,4.994,1.934,9.527,5.086,12.914L3,36h10V26 l-3.365,3.365C7.387,26.885,6,23.612,6,20c0-7.732,6.268-14,14-14c1.031,0,2.033,0.119,3,0.33V1.259C22.02,1.104,21.023,1,20,1 L20,1z"/><g><path fill="#8bb7f0" d="M20,38.5c-0.776,0-1.598-0.062-2.5-0.19v-4.032c0.839,0.147,1.677,0.222,2.5,0.222 c7.995,0,14.5-6.505,14.5-14.5c0-3.583-1.336-7.03-3.761-9.706l-0.353-0.389L27.5,12.793V4.5h8.293l-2.581,2.582l0.328,0.354 C36.738,10.872,38.5,15.334,38.5,20C38.5,30.201,30.201,38.5,20,38.5z"/><path fill="#4e7ab5" d="M34.586,5l-1.387,1.387l-0.682,0.682l0.657,0.706C36.286,11.119,38,15.461,38,20 c0,9.925-8.075,18-18,18c-0.627,0-1.287-0.042-2-0.129v-3.009C18.67,34.954,19.339,35,20,35c8.271,0,15-6.729,15-15 c0-3.708-1.381-7.274-3.89-10.041l-0.705-0.778l-0.743,0.743L28,11.586V5H34.586 M37,4H27v10l3.369-3.369 C32.618,13.111,34,16.388,34,20c0,7.732-6.268,14-14,14c-1.031,0-2.033-0.119-3-0.33v5.071C17.98,38.896,18.977,39,20,39 c10.493,0,19-8.507,19-19c0-4.993-1.942-9.519-5.094-12.906L37,4L37,4z"/></g>
                        </svg></div>
                        <h1 class="text-center   text-md xs:text-xs">{{ __('main.refresh') }}</h1>
                </div>
            </div>

        </div>

        {{-- form info --}}
        <div class="w-full grow       ">

            {{-- tabs of show statistics methods --}}
               <x-tabs-statistics :id="$current_form_id" :type="$type" />
            <!--Tabs content-->
            <div class="">
                {{-- overview statistics --}}
                @if($type=="overview")
                 @livewire('overview')
                {{-- questions statistics --}}
                @elseif($type=="questions-statistics")
                    @livewire('questions-statistics')
                {{-- responses statistics --}}
                @elseif($type=="all-responses")
                    @livewire('all-responses')
                @endif
            </div>


        </div>

    </div>

</div>






