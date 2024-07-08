
@if($form->form_type_id==1)
    <div class="max-h-max h-max  col-span-4  xl:col-span-6  lg:col-span-6 md:col-span-6 sm:col-span-12 xs:col-span-12 border-secondary_blue border-[1px] p-3 rounded-[0.5rem] bg-white ">

        {{-- logo,name and menu --}}
        <div class="flex space-x-10 justify-between items-center">
            {{-- logo --}}
            <div class=" relative">
                <svg class="w-16 h-16 xs:w-10 xs:h-10" viewBox="0 0 512 512" enable-background="new 0 0 512 512" id="Layer_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <g> <g> <path d="M450.255,434.511H61.745c-13.257,0-24.042-10.786-24.042-24.042V101.532 c0-13.257,10.785-24.042,24.042-24.042h388.511c13.257,0,24.042,10.786,24.042,24.042v308.937 C474.298,423.725,463.513,434.511,450.255,434.511z M61.745,97.489c-2.229,0-4.042,1.813-4.042,4.042v308.937 c0,2.229,1.813,4.042,4.042,4.042h388.511c2.229,0,4.042-1.813,4.042-4.042V101.532c0-2.229-1.813-4.042-4.042-4.042H61.745z" fill="#2d4b71"/> </g> <g> <path d="M450.117,163.589H63.655c-13.298,0-24.118-10.785-24.118-24.042v-38.015 c0-13.257,10.819-24.042,24.118-24.042h386.462c13.298,0,24.118,10.786,24.118,24.042v38.015 C474.235,152.804,463.416,163.589,450.117,163.589z M63.655,97.489c-2.271,0-4.118,1.813-4.118,4.042v38.015 c0,2.229,1.847,4.042,4.118,4.042h386.462c2.271,0,4.118-1.813,4.118-4.042v-38.015c0-2.229-1.847-4.042-4.118-4.042H63.655z" fill="#2d4b71"/> </g> <g> <path d="M93.73,128.69c-2.63,0-5.21-1.06-7.07-2.92c-1.86-1.87-2.93-4.44-2.93-7.07c0-2.64,1.07-5.21,2.93-7.08 c1.86-1.86,4.44-2.92,7.07-2.92c2.63,0,5.21,1.06,7.07,2.92c1.86,1.87,2.93,4.44,2.93,7.08c0,2.63-1.07,5.21-2.93,7.07 C98.94,127.63,96.36,128.69,93.73,128.69z" fill="#2d4b71"/> </g> <g> <path d="M142.49,128.69c-2.64,0-5.21-1.06-7.07-2.92c-1.86-1.86-2.93-4.44-2.93-7.07c0-2.64,1.07-5.22,2.93-7.08 c1.86-1.86,4.43-2.92,7.07-2.92c2.63,0,5.21,1.06,7.07,2.92c1.86,1.86,2.93,4.44,2.93,7.08c0,2.63-1.07,5.21-2.93,7.07 C147.7,127.63,145.12,128.69,142.49,128.69z" fill="#2d4b71"/> </g> <g> <path d="M130.769,224.768c-2.508,0-5.002-0.94-6.921-2.78l-10.631-10.188c-3.987-3.821-4.123-10.151-0.301-14.139 c3.821-3.987,10.15-4.123,14.139-0.301l4.694,4.498l23.393-16.432c4.52-3.173,10.757-2.083,13.931,2.435 c3.174,4.52,2.084,10.757-2.435,13.931l-30.123,21.158C134.78,224.169,132.77,224.768,130.769,224.768z" fill="#2d4b71"/> </g> <g> <path d="M136.164,305.05c-2.508,0-5.002-0.94-6.921-2.78l-10.631-10.188c-3.987-3.821-4.123-10.151-0.301-14.139 c3.821-3.987,10.15-4.123,14.139-0.301l4.694,4.498l23.393-16.432c4.521-3.173,10.757-2.083,13.931,2.435 c3.174,4.52,2.084,10.757-2.435,13.931l-30.123,21.158C140.175,304.451,138.165,305.05,136.164,305.05z" fill="#2d4b71"/> </g> <g> <path d="M151.512,374.753h-31.377c-5.523,0-10-4.477-10-10s4.477-10,10-10h31.377c5.523,0,10,4.477,10,10 S157.035,374.753,151.512,374.753z" fill="#2d4b71"/> </g> <g> <path d="M379.69,214.189H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,214.189,379.69,214.189z" fill="#2d4b71"/> </g> <g> <path d="M379.69,294.989H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,294.989,379.69,294.989z" fill="#2d4b71"/> </g> <g> <path d="M379.69,374.753H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,374.753,379.69,374.753z" fill="#2d4b71"/> </g> <g> <path d="M464.298,410.468c0,7.755-6.287,14.042-14.042,14.042H61.745c-7.755,0-14.042-6.287-14.042-14.042V101.532 c0-7.755,6.287-14.042,14.042-14.042h388.511c7.755,0,14.042,6.287,14.042,14.042V410.468z" fill="#e0e0e0"/> <path d="M450.255,434.511H61.745c-13.257,0-24.042-10.786-24.042-24.042V101.532 c0-13.257,10.785-24.042,24.042-24.042h388.511c13.257,0,24.042,10.786,24.042,24.042v308.937 C474.298,423.725,463.513,434.511,450.255,434.511z M61.745,97.489c-2.229,0-4.042,1.813-4.042,4.042v308.937 c0,2.229,1.813,4.042,4.042,4.042h388.511c2.229,0,4.042-1.813,4.042-4.042V101.532c0-2.229-1.813-4.042-4.042-4.042H61.745z" fill="#2d4b71"/> </g> <g> <path d="M464.235,139.547c0,7.755-6.321,14.042-14.118,14.042H63.655c-7.797,0-14.118-6.287-14.118-14.042v-38.015 c0-7.755,6.321-14.042,14.118-14.042h386.462c7.797,0,14.118,6.287,14.118,14.042V139.547z" fill="#1277d1"/> <path d="M450.117,163.589H63.655c-13.298,0-24.118-10.785-24.118-24.042v-38.015 c0-13.257,10.819-24.042,24.118-24.042h386.462c13.298,0,24.118,10.786,24.118,24.042v38.015 C474.235,152.804,463.416,163.589,450.117,163.589z M63.655,97.489c-2.271,0-4.118,1.813-4.118,4.042v38.015 c0,2.229,1.847,4.042,4.118,4.042h386.462c2.271,0,4.118-1.813,4.118-4.042v-38.015c0-2.229-1.847-4.042-4.118-4.042H63.655z" fill="#2d4b71"/> </g> <g> <path d="M93.73,128.69c-2.63,0-5.21-1.06-7.07-2.92c-1.86-1.87-2.93-4.44-2.93-7.07c0-2.64,1.07-5.21,2.93-7.08 c1.86-1.86,4.44-2.92,7.07-2.92c2.63,0,5.21,1.06,7.07,2.92c1.86,1.87,2.93,4.44,2.93,7.08c0,2.63-1.07,5.21-2.93,7.07 C98.94,127.63,96.36,128.69,93.73,128.69z" fill="#2d4b71"/> </g> <g> <path d="M142.49,128.69c-2.64,0-5.21-1.06-7.07-2.92c-1.86-1.86-2.93-4.44-2.93-7.07c0-2.64,1.07-5.22,2.93-7.08 c1.86-1.86,4.43-2.92,7.07-2.92c2.63,0,5.21,1.06,7.07,2.92c1.86,1.86,2.93,4.44,2.93,7.08c0,2.63-1.07,5.21-2.93,7.07 C147.7,127.63,145.12,128.69,142.49,128.69z" fill="#2d4b71"/> </g> <g> <path d="M130.769,224.768c-2.508,0-5.002-0.94-6.921-2.78l-10.631-10.188c-3.987-3.821-4.123-10.151-0.301-14.139 c3.821-3.987,10.15-4.123,14.139-0.301l4.694,4.498l23.393-16.432c4.52-3.173,10.757-2.083,13.931,2.435 c3.174,4.52,2.084,10.757-2.435,13.931l-30.123,21.158C134.78,224.169,132.77,224.768,130.769,224.768z" fill="#2d4b71"/> </g> <g> <path d="M136.164,305.05c-2.508,0-5.002-0.94-6.921-2.78l-10.631-10.188c-3.987-3.821-4.123-10.151-0.301-14.139 c3.821-3.987,10.15-4.123,14.139-0.301l4.694,4.498l23.393-16.432c4.521-3.173,10.757-2.083,13.931,2.435 c3.174,4.52,2.084,10.757-2.435,13.931l-30.123,21.158C140.175,304.451,138.165,305.05,136.164,305.05z" fill="#2d4b71"/> </g> <g> <path d="M151.512,374.753h-31.377c-5.523,0-10-4.477-10-10s4.477-10,10-10h31.377c5.523,0,10,4.477,10,10 S157.035,374.753,151.512,374.753z" fill="#2d4b71"/> </g> <g> <path d="M379.69,214.189H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,214.189,379.69,214.189z" fill="#2d4b71"/> </g> <g> <path d="M379.69,294.989H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,294.989,379.69,294.989z" fill="#2d4b71"/> </g> <g> <path d="M379.69,374.753H203.667c-5.523,0-10-4.477-10-10s4.477-10,10-10H379.69c5.523,0,10,4.477,10,10 S385.213,374.753,379.69,374.753z" fill="#2d4b71"/> </g> </g> </g>
                </svg>


            </div>
            {{-- name --}}
                <div class="  text-center">
                <h1 class="text-md font-bold text-black">{{ $form->form_title }}</h1>

                </div>
                {{-- menu --}}
                <div class="grid ">

                    <div class="flex justify-end items-center">
                        <svg id="dropdownRadioButton-{{ $form->id }}" data-dropdown-toggle="listadd-{{ $form->id }}"  class="w-6 h-6 hover:cursor-pointer text-svg_primary hover:text-secondary_blue"  fill="currentColor"  version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 460.054 460.054" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier"> <g> <g> <path d="M40.003,69.679C17.914,69.679,0,87.592,0,109.697c0,22.089,17.914,39.987,40.003,39.987 c22.089,0,40.003-17.898,40.003-39.987C80.006,87.592,62.092,69.679,40.003,69.679z"/> </g> <g> <path d="M40.003,190.032C17.914,190.032,0,207.93,0,230.035c0,22.089,17.914,40.002,40.003,40.002 c22.089,0,40.003-17.913,40.003-40.002C80.006,207.93,62.092,190.032,40.003,190.032z"/> </g> <g> <path d="M40.003,310.37C17.914,310.37,0,328.283,0,350.372c0,22.089,17.914,40.003,40.003,40.003 c22.089,0,40.003-17.914,40.003-40.003C80.006,328.283,62.092,310.37,40.003,310.37z"/> </g> <g> <path d="M429.973,79.601H145.419c-16.611,0-30.081,13.47-30.081,30.096c0,16.612,13.469,30.081,30.081,30.081h284.554 c16.61,0,30.081-13.469,30.081-30.081C460.054,93.071,446.583,79.601,429.973,79.601z"/> </g> <g> <path d="M429.973,199.939H145.419c-16.611,0-30.081,13.469-30.081,30.096c0,16.612,13.469,30.081,30.081,30.081h284.554 c16.61,0,30.081-13.469,30.081-30.081C460.054,213.408,446.583,199.939,429.973,199.939z"/> </g> <g> <path d="M429.973,320.291H145.419c-16.611,0-30.081,13.469-30.081,30.081c0,16.611,13.469,30.08,30.081,30.08h284.554 c16.61,0,30.081-13.469,30.081-30.08C460.054,333.759,446.583,320.291,429.973,320.291z"/> </g> </g> </g>
                        </svg>
                        <div id="listadd-{{ $form->id }}" class="z-20 hidden w-24 xs:w-12 bg-white divide-y divide-gray-100 rounded-lg  ">
                            <ul class="p-1 space-y-1 text-sm text-gray-700 d border-[1px] rounded-lg border-gray-200" aria-labelledby="dropdownRadioButton-{{ $form->id }}">

                                    {{-- add question --}}
                                <li  class=" rounded-lg">
                                    <a wire:click="delete({{ $form->id }})"
                                        class=" block  text-center w-full xs:text-xs  rounded-lg   text-black hover:text-secondary_blue hover:font-bold  p-[2px] hover:cursor-pointer hover:no-underline">
                                        {{ __('main.delete') }}
                                    </a>
                                </li>
                                {{-- add terms --}}




                            </ul>
                        </div>
                    </div>
                </div>
        </div>
        {{-- info  --}}
            <div class="mx-1 xs:grid md:grid lg:grid  sm:grid xl:grid flex space-x-1  justify-start items-center    gap-1">
                {{-- question count --}}
                {{-- <div class="col-span-3 md:col-span-3 xs:col-span-3">
                    <h1 class="text-sm xs:text-xs">{{ __(' Questions: ') }}<span class="text-center text-secondary_blue font-bold xs:text-xs">{{ $this->numofquestions($form->id) }}</span> </h1>
                </div> --}}
                {{-- total response of form --}}
                {{-- <div class="col-span-3 md:col-span-3 xs:col-span-3">
                    <h1 class="text-sm xs:text-xs">{{ __('Total Responses: ') }} <span class="text-center text-secondary_blue font-bold xs:text-xs">{{$responses[$form->id] }}</span></h1>
                </div> --}}
                @php
                    $text="text";$bar="bar";
                @endphp
                <x-form-info-tag :svg="$formagesvg" :type="$text" :tag="__('main.formage') " :info=" $form->age " :class="'text-secondary_blue'" />
                <x-form-info-tag :svg="$responsessvg" :type="$text" :tag="__('main.responses_form')" :info="$form->responsesCount" :class="'text-secondary_blue'" />
            </div>


        {{-- buttons --}}
        <div class="mt-2 xs:mt-1 flex justify-between  xs:space-x-2 items-center ">

                <div>


                    {{-- edit button --}}
                    <x-jet-button class="ml-1 xs:ml-0 " wire:click="Route('editform',{{ $form->id }})"
                        type="button"   wire:loading.attr="disabled">
                        {{ __('main.edit') }}
                        <svg class="w-4 h-4 mx-1" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier">
                            <path d="M823.3 938.8H229.4c-71.6 0-129.8-58.2-129.8-129.8V215.1c0-71.6 58.2-129.8 129.8-129.8h297c23.6 0 42.7 19.1 42.7 42.7s-19.1 42.7-42.7 42.7h-297c-24.5 0-44.4 19.9-44.4 44.4V809c0 24.5 19.9 44.4 44.4 44.4h593.9c24.5 0 44.4-19.9 44.4-44.4V512c0-23.6 19.1-42.7 42.7-42.7s42.7 19.1 42.7 42.7v297c0 71.6-58.2 129.8-129.8 129.8z" fill="#ffffff"/>
                            <path d="M483 756.5c-1.8 0-3.5-0.1-5.3-0.3l-134.5-16.8c-19.4-2.4-34.6-17.7-37-37l-16.8-134.5c-1.6-13.1 2.9-26.2 12.2-35.5l374.6-374.6c51.1-51.1 134.2-51.1 185.3 0l26.3 26.3c24.8 24.7 38.4 57.6 38.4 92.7 0 35-13.6 67.9-38.4 92.7L513.2 744c-8.1 8.1-19 12.5-30.2 12.5z m-96.3-97.7l80.8 10.1 359.8-359.8c8.6-8.6 13.4-20.1 13.4-32.3 0-12.2-4.8-23.7-13.4-32.3L801 218.2c-17.9-17.8-46.8-17.8-64.6 0L376.6 578l10.1 80.8z" fill="#ffffff"/>
                            </g>
                        </svg>
                    </x-jet-button>
                    {{-- statistics button --}}
                    <x-jet-button class="ml-1 xs:ml-0 " wire:click="Route('statisticform',{{ $form->id }})"  type="button"   wire:loading.attr="disabled">
                        {{ __('main.statistic') }}
                        <svg class="w-4 h-4 mx-1"  viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier"> <defs> <style>.cls-1{fill:none;stroke:#ffffff;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.5px;}</style> </defs> <g id="ic-statistics-2"> <line class="cls-1" x1="2" y1="20" x2="22" y2="20"/> <path class="cls-1" d="M5,20V8.2A.2.2,0,0,1,5.2,8H7.8a.2.2,0,0,1,.2.2V20"/> <path class="cls-1" d="M11,20V4.27c0-.15.09-.27.2-.27h2.6c.11,0,.2.12.2.27V20"/> <path class="cls-1" d="M17,20V11.15c0-.08.09-.15.2-.15h2.6c.11,0,.2.07.2.15V20"/> </g> </g>
                        </svg>
                    </x-jet-button>
                    {{-- preview button --}}
                    <a target="_blank" href="{{ route('preview',$form->id) }}" class="bg-gray-400 hover:no-underline inline-flex items-center px-4 py-2 xs:m-0 xs:p-1
                        border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest
                        active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-1 xs:hidden ">
                        {{ __('main.preview') }}
                        <svg class=" w-4 h-4 mx-1 text-white  cursor-pointer " fill="currentColor"  viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg">
                            <defs><style>.cls-1{fill:none;}</style></defs><title>task--view</title>
                            <circle cx="22" cy="24" r="2"/>
                            <path id="_inner_path_" data-name="&lt;inner path&gt;" class="cls-1" d="M22,28a4,4,0,1,1,4-4A4.0039,4.0039,0,0,1,22,28Zm0-6a2,2,0,1,0,2,2A2.0027,2.0027,0,0,0,22,22Z"/>
                            <path d="M29.7769,23.4785A8.64,8.64,0,0,0,22,18a8.64,8.64,0,0,0-7.7769,5.4785L14,24l.2231.5215A8.64,8.64,0,0,0,22,30a8.64,8.64,0,0,0,7.7769-5.4785L30,24ZM22,28a4,4,0,1,1,4-4A4.0045,4.0045,0,0,1,22,28Z"/>
                            <path d="M12,28H7V7h3v3H22V7h3v9h2V7a2,2,0,0,0-2-2H22V4a2,2,0,0,0-2-2H12a2,2,0,0,0-2,2V5H7A2,2,0,0,0,5,7V28a2,2,0,0,0,2,2h5ZM12,4h8V8H12Z"/>
                        </svg>
                    </a>
                </div>
                <div class="flex justify-end items-center xs:items-baseline">
                    @if($form->devices_count>0)
                        <svg class="w-4 h-4 m-1 text-valid" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                        </svg>
                    @endif
                    <span class="rounded-[0.5rem] w-auto h-6 ml-1  p-1 text-xs {{ $form->active?"text-valid bg-green-100":"text-primary_red bg-red-100" }}">{{ $form->active?__('main.active'):__('main.inactive') }}</span>

                </div>









        </div>



    </div>
@elseif($form->form_type_id==2)
    <div class="max-h-max h-max col-span-4  lg:col-span-6 md:col-span-6 sm:col-span-12 xs:col-span-12 border-secondary_blue border-[1px] p-3 rounded-[0.5rem] bg-white ">

        {{-- logo,name and menu --}}
        <div class="flex space-x-10 justify-between items-center">
            {{-- logo  --}}
            <div class=" relative">


                <svg class="w-16 h-16" viewBox="-102.4 -102.4 1228.80 1228.80" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                <g id="SVGRepo_iconCarrier">
                <path d="M960 1002.666667H64a42.666667 42.666667 0 0 1-42.666667-42.666667V64a42.666667 42.666667 0 0 1 42.666667-42.666667h896a42.666667 42.666667 0 0 1 42.666667 42.666667v896a42.666667 42.666667 0 0 1-42.666667 42.666667z" fill="#2d4b71"/>
                <path d="M64 64h896v682.666667H64zM896 896H597.333333a21.333333 21.333333 0 1 1 0-42.666667h298.666667a21.333333 21.333333 0 1 1 0 42.666667z" fill="#e0e0e0"/>
                <path d="M661.333333 896H128a21.333333 21.333333 0 1 1 0-42.666667h533.333333a21.333333 21.333333 0 1 1 0 42.666667z" fill="#1277d1"/>
                <path d="M640 960c-47.04 0-85.333333-38.293333-85.333333-85.333333s38.293333-85.333333 85.333333-85.333334 85.333333 38.293333 85.333333 85.333334-38.293333 85.333333-85.333333 85.333333zM426.666667 554.666667a21.269333 21.269333 0 0 1-21.333334-21.333334V277.333333a21.333333 21.333333 0 0 1 33.173334-17.749333l192 128a21.333333 21.333333 0 0 1 0 35.498667l-192 128A21.333333 21.333333 0 0 1 426.666667 554.666667z" fill="#1277d1"/>
                </g>
                </svg>


            </div>
            {{-- name --}}
                <div class="  text-center">
                <h1 class="text-md font-bold text-black">{{ $form->form_title }}</h1>

                </div>
                {{-- menu --}}
                <div class="grid ">

                    <div class="flex justify-end items-center">
                        <svg id="dropdownRadioButton-{{ $form->id }}" data-dropdown-toggle="listadd-{{ $form->id }}"  class="w-6 h-6 hover:cursor-pointer text-svg_primary hover:text-secondary_blue"  fill="currentColor"  version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 460.054 460.054" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier"> <g> <g> <path d="M40.003,69.679C17.914,69.679,0,87.592,0,109.697c0,22.089,17.914,39.987,40.003,39.987 c22.089,0,40.003-17.898,40.003-39.987C80.006,87.592,62.092,69.679,40.003,69.679z"/> </g> <g> <path d="M40.003,190.032C17.914,190.032,0,207.93,0,230.035c0,22.089,17.914,40.002,40.003,40.002 c22.089,0,40.003-17.913,40.003-40.002C80.006,207.93,62.092,190.032,40.003,190.032z"/> </g> <g> <path d="M40.003,310.37C17.914,310.37,0,328.283,0,350.372c0,22.089,17.914,40.003,40.003,40.003 c22.089,0,40.003-17.914,40.003-40.003C80.006,328.283,62.092,310.37,40.003,310.37z"/> </g> <g> <path d="M429.973,79.601H145.419c-16.611,0-30.081,13.47-30.081,30.096c0,16.612,13.469,30.081,30.081,30.081h284.554 c16.61,0,30.081-13.469,30.081-30.081C460.054,93.071,446.583,79.601,429.973,79.601z"/> </g> <g> <path d="M429.973,199.939H145.419c-16.611,0-30.081,13.469-30.081,30.096c0,16.612,13.469,30.081,30.081,30.081h284.554 c16.61,0,30.081-13.469,30.081-30.081C460.054,213.408,446.583,199.939,429.973,199.939z"/> </g> <g> <path d="M429.973,320.291H145.419c-16.611,0-30.081,13.469-30.081,30.081c0,16.611,13.469,30.08,30.081,30.08h284.554 c16.61,0,30.081-13.469,30.081-30.08C460.054,333.759,446.583,320.291,429.973,320.291z"/> </g> </g> </g>
                        </svg>
                        <div id="listadd-{{ $form->id }}" class="z-20 hidden w-24 xs:w-12 bg-white divide-y divide-gray-100 rounded-lg  ">
                            <ul class="p-1 space-y-1 text-sm text-gray-700 d border-[1px] rounded-lg border-gray-200" aria-labelledby="dropdownRadioButton-{{ $form->id }}">

                                    {{-- add question --}}
                                <li  class=" rounded-lg">
                                    <a wire:click="delete({{ $form->id }})"
                                        class=" block  text-center w-full xs:text-xs  rounded-lg   text-black hover:text-secondary_blue hover:font-bold  p-[2px] hover:cursor-pointer hover:no-underline">
                                        {{ __('main.delete') }}
                                    </a>
                                </li>
                                {{-- add terms --}}




                            </ul>
                        </div>
                    </div>
                </div>
        </div>
        {{-- info  --}}
            <div class="mx-1  flex space-x-1  justify-start items-baseline    gap-1 min-h-max">
                {{-- question count --}}
                {{-- <div class="col-span-3 md:col-span-3 xs:col-span-3">
                    <h1 class="text-sm xs:text-xs">{{ __(' Questions: ') }}<span class="text-center text-secondary_blue font-bold xs:text-xs">{{ $this->numofquestions($form->id) }}</span> </h1>
                </div> --}}
                {{-- total response of form --}}
                {{-- <div class="col-span-3 md:col-span-3 xs:col-span-3">
                    <h1 class="text-sm xs:text-xs">{{ __('Total Responses: ') }} <span class="text-center text-secondary_blue font-bold xs:text-xs">{{$responses[$form->id] }}</span></h1>
                </div> --}}
                @php
                    $text="text";$bar="bar";
                @endphp
                {{-- <x-form-info-tag :svg="$formagesvg" :type="$text" :tag="'Form Age:'" :info=" $form->age " :class="'text-secondary_blue'" /> --}}
                <x-form-info-tag :svg="$mediasvg" :type="$text" :tag="__('main.mediacontent_form')" :info="$form->mediaCount" :class="'text-secondary_blue'" />
            </div>


        {{-- buttons --}}
        <div class=" mt-2 xs:mt-1 flex justify-between items-center ">
                <div>
                    {{-- edit button --}}
                    <x-jet-button class=" " wire:click="Route('editform',{{ $form->id }})"
                        type="button"   wire:loading.attr="disabled">
                        {{ __('main.edit') }}
                        <svg class="w-4 h-4 mx-1" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier">
                            <path d="M823.3 938.8H229.4c-71.6 0-129.8-58.2-129.8-129.8V215.1c0-71.6 58.2-129.8 129.8-129.8h297c23.6 0 42.7 19.1 42.7 42.7s-19.1 42.7-42.7 42.7h-297c-24.5 0-44.4 19.9-44.4 44.4V809c0 24.5 19.9 44.4 44.4 44.4h593.9c24.5 0 44.4-19.9 44.4-44.4V512c0-23.6 19.1-42.7 42.7-42.7s42.7 19.1 42.7 42.7v297c0 71.6-58.2 129.8-129.8 129.8z" fill="#ffffff"/>
                            <path d="M483 756.5c-1.8 0-3.5-0.1-5.3-0.3l-134.5-16.8c-19.4-2.4-34.6-17.7-37-37l-16.8-134.5c-1.6-13.1 2.9-26.2 12.2-35.5l374.6-374.6c51.1-51.1 134.2-51.1 185.3 0l26.3 26.3c24.8 24.7 38.4 57.6 38.4 92.7 0 35-13.6 67.9-38.4 92.7L513.2 744c-8.1 8.1-19 12.5-30.2 12.5z m-96.3-97.7l80.8 10.1 359.8-359.8c8.6-8.6 13.4-20.1 13.4-32.3 0-12.2-4.8-23.7-13.4-32.3L801 218.2c-17.9-17.8-46.8-17.8-64.6 0L376.6 578l10.1 80.8z" fill="#ffffff"/>
                            </g>
                        </svg>
                    </x-jet-button>
                    {{-- preview button --}}
                    <a target="_blank" href="{{ route('preview',$form->id) }}" class="bg-gray-400 hover:no-underline inline-flex items-center px-4 py-2 xs:p-1
                        border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest
                        active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3 ">
                        {{ __('main.preview') }}

                        <svg class=" w-4 h-4 mx-1 text-white  cursor-pointer " fill="currentColor"  viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg">
                            <defs><style>.cls-1{fill:none;}</style></defs><title>task--view</title>
                            <circle cx="22" cy="24" r="2"/>
                            <path id="_inner_path_" data-name="&lt;inner path&gt;" class="cls-1" d="M22,28a4,4,0,1,1,4-4A4.0039,4.0039,0,0,1,22,28Zm0-6a2,2,0,1,0,2,2A2.0027,2.0027,0,0,0,22,22Z"/>
                            <path d="M29.7769,23.4785A8.64,8.64,0,0,0,22,18a8.64,8.64,0,0,0-7.7769,5.4785L14,24l.2231.5215A8.64,8.64,0,0,0,22,30a8.64,8.64,0,0,0,7.7769-5.4785L30,24ZM22,28a4,4,0,1,1,4-4A4.0045,4.0045,0,0,1,22,28Z"/>
                            <path d="M12,28H7V7h3v3H22V7h3v9h2V7a2,2,0,0,0-2-2H22V4a2,2,0,0,0-2-2H12a2,2,0,0,0-2,2V5H7A2,2,0,0,0,5,7V28a2,2,0,0,0,2,2h5ZM12,4h8V8H12Z"/>
                        </svg>
                    </a>
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
@endif
