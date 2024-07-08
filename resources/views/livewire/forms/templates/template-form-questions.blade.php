
@push('styles')


@endpush

<div class="bg-white  overflow-hidden h-[100vh]  touch-manipulation  " >
    {{-- sounds --}}
    <audio class="hidden" id="SuccessAudio" >
        <source src="{{ asset('/sounds/Success.mp3') }}" type="audio/mpeg">

    </audio>
    <audio class="hidden" id="StartAudio" >
        <source src="{{ asset('/sounds/Start.wav') }}" type="audio/mpeg">

    </audio>
    {{-- endofsounds --}}
    @if($problem)
        <div class="grid grid-rows-4 h-full justify-center items-center bg-white  ">

            <div class="row-span-2 grid ">



                <div class="flex justify-center items-center">
                    <img class="w-28 h-28 object-contain" src="{{ asset('images/exclamation_mark.gif') }}" alt="">
                </div>
                 {{-- error --}}
                 <div class="flex justify-center items-center"><span class="text-xl text-black text-center ">{{ $errorText }}</span></div>

            </div>


            {{-- error message --}}
            <div class="grid row-span-2 justify-center items-center">
                <span class="text-md text-black">{{ $errorMessage }}</span>
                <div class="row-span-1 flex justify-center items-center hover:cursor-pointer">
                    <a onclick="RecheckPage()" class="text-secondary_blue font-bold ">
                      <span id="recheckText">{{ __('RECHECK') }}</span>

                    </a>
                </div>
            </div>

        </div>
    @else
        <div id="header" class="w-full   h-2 ">
            <div class="flex w-full h-2 pointer-events-none select-none">
                    <div id="progressbar" class="relative  h-2   hidden w-full  bg-white   ">
                        <div id="progressbar_value"
                            class="hidden select-none bg-secondary_blue     justify-center items-center  h-2 text-center text-xs
                            font-medium leading-none text-primary-100">
                        </div>
                    </div>
            </div>
        </div>

        <div id="form_section" class="    h-full mb-2 xs:h-auto" >
            @if($step==1)
                <div id="homepage"  wire:loading.class="disabled opacity-50" target="startform">
                    <div class="flex justify-center items-center col-span-1 min-h-48 h-48">
                        @if($logo)
                        <div class=" rounded-lg   max-w-[180px] max-h-[135px] min-h-[135px] min-w-[180px] w-[180px] h-[135px] p-1  flex justify-center pointer-events-none">
                        <img class="object-contain w-full h-full  pointer-events-none " src="{{ asset($logo->logo_url) }}" alt="">
                        </div>
                        @endif
                    </div>
                    {{-- start messages with all languages  --}}
                    <div class="owl-carousel owl-theme mt-2 xs:mt-2  ">

                        @foreach ($messages as $message )
                        <div class="text-center min-h-[300px] max-h-[300px] h-[300px] pointer-events-none px-4 grid justify-center items-center " >
                           <div> <h1 class="font-bold text-5xl select-none mb-5">{{ $message->form_start_header }}</h1>
                            <span class="font-weight-bolder text-3xl select-none " >{{ $message->form_start_text }}</span></div>
                        </div>
                        @endforeach

                    </div>
                    {{-- flex justify-between items-center space-x-32 --}}
                    {{-- end of start messages with all languages  --}}
                    @php
                        $count=count($formlanguages);
                    @endphp

                    <div class=" flex items-center justify-center">
                        <div class=" flex justify-center items-center xs:grid-cols-4 gap-6  p-4 mt-10 ">
                            @foreach ($formlanguages as $lang )
                                @foreach ($buttons as $button )
                                    @if($lang['code']==$button['code'])

                                        <div class=" xs:row-span-1 min-w-[192px] max-w-[192px]">
                                            {{-- <button onclick="trystartform({{ $lang['code'] }})"   class="focus:z-[1000px] focus:border-blue-700  focus:bg-white focus:drop-shadow-2xl hover:z-50 hover:border-blue-600 hover:bg-white hover:drop-shadow-xl border-[1px] border-blue-500 rounded-xl bg-transparent text-blue-500 p-4 h-20 w-full ">
                                                <span class="whitespace-nowrap text-2xl font-bold pointer-event-none select-none ">{{ $button['text'] }}</span>
                                            </button> --}}
                                            <input  class="hidden peer language_button" onclick="trystartform('{{ $lang['code'] }}')"  value="0" name="language_button" id="language_button-{{ $lang['code'] }}" type="radio" required >
                                                <label for="language_button-{{ $lang['code'] }}" id="language_button_label-{{ $lang['code'] }}" class=" border-gray-300 select-none peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold  peer-checked:text-2xl w-48 max-w-[48] min-w-[48] h-24
                                                flex justify-center items-center p-2    text-2xl font-bold bg-formbutton border-[2px] rounded-lg cursor-pointer
                                                 peer-checked:border-blue-400
                                                hover:text-gray-600 hover:bg-gray-100 ">
                                                {{ $button['text'] }}
                                                </label>
                                            <img class="my-2 w-12 h-9 object-contain block ml-auto mr-auto " src="{{ asset($button['flag']) }}" alt="">
                                        </div>
                                    @endif
                                @endforeach

                            @endforeach

                        </div>
                    </div>
                </div>


            @else
                <div id="agreement_section" class="hidden" >
                    <div class="border-[1px] p-4 mx-20 mt-16 mb-2 rounded-lg border-gray-700 h-[550px] max-h-[550px] min-h-[550px] overflow-auto select-none {{ $current_lang=='en'||$current_lang=='tl'?"text-left justify-start":"text-right justify-end" }}">
                        {!! $terms !!}
                    </div>
                    {{-- <div class="flex justify-center items-center   mt-2 mx-16  relative ">
                        <div    class=" ml-4 mr-4  "  >
                            <input  class="hidden peer" onclick="setagrement('0')"  value="0" name="agremant" id="disagree" type="radio" required>
                                <label for="disagree" id="disagree_label" class=" border-gray-300 select-none peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold peer-checked:text-xl w-48 max-w-[48] min-w-[48] h-24
                                flex justify-center items-center p-2   text-gray-500 bg-formbutton border-[2px] rounded-lg cursor-pointer
                             peer-checked:border-blue-400
                            hover:text-gray-600 hover:bg-gray-100 ">

                            </label>

                        </div  >
                        <div   class=" ml-4 mr-4 "  >
                            <input  class="hidden peer" onclick="setagrement('1')"  value="1" name="agremant" id="agree" type="radio" required>
                                <label for="agree" id="agree_label" class=" border-gray-300 select-none peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold peer-checked:text-xl w-48 max-w-[48] min-w-[48] h-24
                                flex justify-center items-center p-2   text-gray-500 bg-formbutton border-[2px] rounded-lg cursor-pointer
                             peer-checked:border-blue-400
                            hover:text-gray-600 hover:bg-gray-100 ">

                            </label>

                        </div  >

                    </div> --}}
                    <div class="grid grid-cols-3 justify-end items-center  fixed  gap-2 w-full mb-1 bottom-0">
                        {{-- <button class="bg-red-400 p-2 w-28 text-white select-none">
                        {{ __('Back') }} Accept & Continue
                        </button> --}}

                        <button id="cancel" onclick="DisagreeArguments()" class=" text-3xl font-bold uppercase   col-span-1  h-20 bg-gray-400 hover:bg-gray-400 focus:bg-gray-400 w-full text-white select-none">
                            <span class="text-4xl ">{{ __('↶ ') }}</span> {{ __($ControlButtons[$current_lang]['cancel']) }}
                        </button>

                        <button id="next" onclick="AgreeArguments()"  class="flex justify-center items-center w-full text-3xl uppercase  justify-self-end font-bold disabled:bg-blue-200 bg-secondary_blue col-span-2 h-20  text-white select-none">
                        {{ __($ControlButtons[$current_lang]['accept']) }}<span class="ml-8 animate-ping text-4xl">{{ __(' ➝') }}</span>
                        </button>
                    </div>
                </div>

                <div id="question_section" class="hidden min-h-[80%] h-[80%] ">
                    {{-- question --}}
                    <div id="question" class="text-center my-4 p-3 w-full h-[30%] max-h-[30%] min-h-[30%] flex justify-center items-center " >
                        <span id="question_text" class="text-3xl font-bold pointer-events-none select-none "></span>
                    </div>
                    {{-- answers --}}
                    <div id="answers_section" class="h-[70%] max-h-[70%] min-h-[70%] scrollbar scrollbar-thumb-gray-400 scrollbar-track-white
                    scrollbar-thumb-rounded-full scrollbar-track-rounded-full text-center  overflow-y-auto" >

                    </div>


                    {{-- keyboard section --}}

                    {{-- next and back buttons --}}
                    <div id="buttons" class=" grid grid-cols-3 fixed w-full mb-1 gap-2 left-0   bottom-0">
                        <button id="back" onclick="back()" class=" text-3xl font-bold uppercase  opacity-0  col-span-1  h-20 bg-gray-400 hover:bg-gray-400 focus:bg-gray-400 w-full text-white select-none">

                            <span class="text-4xl mr-4">{{ __('↶') }}</span>{{ __($ControlButtons[$current_lang]['back']) }}
                        </button>
                        {{-- <span id="comment" class="text-sm text-center w-[80%]">
                        </span> --}}

                        <button onclick="next()" id="next_question" disabled class="flex justify-center items-center text-3xl font-bold uppercase   col-span-2 h-20  disabled:bg-blue-200 bg-secondary_blue w-full text-white select-none">

                        </button>
                    </div>
                </div>

                <div id="thanks_section" class="hidden justify_center items-center  text-center  h-full mt-28 " >

                </div>

                {{-- error section --}}
                {{-- <div id="error" class="hidden absolute top-1/2 left-[45%] justify-center items-center">

                <span class="text-xl text-blue-400"> Server connection faild!! </span>

                </div> --}}

            @endif
             {{-- saving loader --}}
            <div id="saving" class="hidden w-full h-full  justify-center items-center">


                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                <svg class="animate-ping  h-20 w-20 mr-3 " viewBox="0 0 24 24" id="upload-double-arrow-3" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier">
                    <polyline id="secondary" points="9 6 12 3 15 6" style="fill: none; stroke: #1277d1; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                    <polyline id="secondary-2" data-name="secondary" points="9 11 12 8 15 11" style="fill: none; stroke: #1277d1; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                    <line id="secondary-3" data-name="secondary" x1="12" y1="8" x2="12" y2="17" style="fill: none; stroke: #1277d1; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                    <path id="primary" d="M4,17v3a1,1,0,0,0,1,1H19a1,1,0,0,0,1-1V17" style="fill: none; stroke: #878787; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                    </g>
                </svg>
            </div>
        </div>
    @endif

    {{-- error reload  --}}
    <div id="errorReload" class="hidden grid-rows-4 h-full justify-center items-center bg-white  ">

        <div class="row-span-2 grid ">



            <div class="flex justify-center items-center">
                <img class="w-28 h-28 object-contain" src="{{ asset('images/exclamation_mark.gif') }}" alt="">
            </div>
             {{-- error --}}
             <div class="flex justify-center items-center"><span class="text-xl text-black text-center ">{{ __('Failed to connect to the server') }}</span></div>

        </div>



        <div class="grid row-span-2 justify-center items-center">
            <span class="text-md text-black">{{ __('Check network connectivity, and try again.') }}</span>
            <div class="row-span-1 flex justify-center items-center hover:cursor-pointer">
                <a onclick="reload()"  class="text-secondary_blue font-bold ">

                  <span id="recheckText" >
                    {{ __('Retry') }}
                </span>
                </a>
              </div>
        </div>

    </div>
    {{-- <div id="errorReload" class="hidden bg-black w-full h-full justify-center items-center  ">

           <span class="text-primary_red justify-center flex items-center text-xl ">{{ __('Failed to connect to the server, Check network connectivity, and try again.') }}</span>
            <div class="grid justify-center items-center  mt-2">
                <svg onclick="reload()" id="svg_reload" class="mx-1 w-14 h-14 text-white hover:text-secondary_blue hover:cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.9381 13C19.979 12.6724 20 12.3387 20 12C20 7.58172 16.4183 4 12 4C9.49942 4 7.26681 5.14727 5.7998 6.94416M4.06189 11C4.02104 11.3276 4 11.6613 4 12C4 16.4183 7.58172 20 12 20C14.3894 20 16.5341 18.9525 18 17.2916M15 17H18V17.2916M5.7998 4V6.94416M5.7998 6.94416V6.99993L8.7998 7M18 20V17.2916" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="text-center text-white">
                    {{ __('Retry') }}
                </span>
            </div>

    </div> --}}



</div>


    @push('scripts')
     <script src="{{ asset('js/config.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/datepicker.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script   src="{{ asset('js/templateFormQuestions.js') }}"></script>
    <script  src="{{ asset('js/keyboard.js') }}"></script>

    @endpush


