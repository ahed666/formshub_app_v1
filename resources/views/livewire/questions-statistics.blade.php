@push('styles')

@endpush
<div  class=" py-4 xs:py-1">
    @if($responses!=null&&count($responses)>0)
    <div class="flex justify-between items-center px-4 xs:px-1   my-1">
        {{-- switch between questions --}}
        <div class="flex space-x-4 items-center w-[60%] xs:w-full xs:justify-start justify-end">

            <button {{ $questionIndex>0?"":"disabled" }} wire:click="backQuestion" class="focus:outline-none">
                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                <svg id="prev" class="opacity-50 w-10 h-10 xs:w-6 xs:h-6 text-secondary_blue hover:cursor-pointer" fill="currentColor" viewBox="0 0 24 24" id="previous" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color" transform="rotate(0)">
                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                    <g id="SVGRepo_iconCarrier">
                        <path id="primary" d="M17.45,2.11a1,1,0,0,0-1.05.09l-12,9a1,1,0,0,0,0,1.6l12,9a1,1,0,0,0,1.05.09A1,1,0,0,0,18,21V3A1,1,0,0,0,17.45,2.11Z" style="fill: currentColor;" />
                    </g>
                </svg>
            </button>
            <div class="flex items-center justify-center space-x-0 w-72 xs:w-40 overflow-x-auto">
                @if(count($formquestions)<8)
                    @for($i=0; $i < count($formquestions); $i++) <button wire:click="currentQuestion({{ $i }})" class="{{$questionIndex==$i?"bg-secondary_blue":""  }} focus:outline-none border-[1px]  border-gray-200 p-1">{{ $i+1 }}</button>
                    @endfor
                @elseif(count($formquestions)>=8)

                    @for($i = 0;$i < count($formquestions); $i++) <button wire:click="currentQuestion({{ $i }})" class="{{$questionIndex==$i?"bg-secondary_blue":""  }} focus:outline-none border-[1px] border-gray-200 p-1 xs:text-xs">{{ $i+1 }}</button>
                    @endfor

                @endif
            </div>
            <button {{ $questionIndex<count($formquestions)-1?"":"disabled" }} wire:click="nextQuestion" class="focus:outline-none">
                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                <svg fill="currentColor" id="next" class="opacity-50 w-10 h-10 xs:w-6 xs:h-6 text-secondary_blue hover:cursor-pointer" viewBox="0 0 24 24" id="previous" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color" transform="rotate(180)">
                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                    <g id="SVGRepo_iconCarrier">
                        <path id="primary" d="M17.45,2.11a1,1,0,0,0-1.05.09l-12,9a1,1,0,0,0,0,1.6l12,9a1,1,0,0,0,1.05.09A1,1,0,0,0,18,21V3A1,1,0,0,0,17.45,2.11Z" style="fill: currentColor;" />
                    </g>
                </svg>
            </button>
        </div>
        {{-- menu  --}}
        <div>
            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg id="dropdownQuestionsStatisticsOptions" data-dropdown-toggle="dropdown" fill="currentColor" class="w-6 h-6 hover:cursor-pointer text-svg_primary hover:text-secondary_blue" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 460.054 460.054" xml:space="preserve">
                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                <g id="SVGRepo_iconCarrier">
                    <g>
                        <g>
                            <path d="M40.003,69.679C17.914,69.679,0,87.592,0,109.697c0,22.089,17.914,39.987,40.003,39.987 c22.089,0,40.003-17.898,40.003-39.987C80.006,87.592,62.092,69.679,40.003,69.679z" />
                        </g>
                        <g>
                            <path d="M40.003,190.032C17.914,190.032,0,207.93,0,230.035c0,22.089,17.914,40.002,40.003,40.002 c22.089,0,40.003-17.913,40.003-40.002C80.006,207.93,62.092,190.032,40.003,190.032z" />
                        </g>
                        <g>
                            <path d="M40.003,310.37C17.914,310.37,0,328.283,0,350.372c0,22.089,17.914,40.003,40.003,40.003 c22.089,0,40.003-17.914,40.003-40.003C80.006,328.283,62.092,310.37,40.003,310.37z" />
                        </g>
                        <g>
                            <path d="M429.973,79.601H145.419c-16.611,0-30.081,13.47-30.081,30.096c0,16.612,13.469,30.081,30.081,30.081h284.554 c16.61,0,30.081-13.469,30.081-30.081C460.054,93.071,446.583,79.601,429.973,79.601z" />
                        </g>
                        <g>
                            <path d="M429.973,199.939H145.419c-16.611,0-30.081,13.469-30.081,30.096c0,16.612,13.469,30.081,30.081,30.081h284.554 c16.61,0,30.081-13.469,30.081-30.081C460.054,213.408,446.583,199.939,429.973,199.939z" />
                        </g>
                        <g>
                            <path d="M429.973,320.291H145.419c-16.611,0-30.081,13.469-30.081,30.081c0,16.611,13.469,30.08,30.081,30.08h284.554 c16.61,0,30.081-13.469,30.081-30.08C460.054,333.759,446.583,320.291,429.973,320.291z" />
                        </g>
                    </g>
                </g>
            </svg>

            <!-- Dropdown menu -->
            <div id="dropdown" class="z-50  hidden bg-white divide-y divide-gray-100 rounded-[0.5rem] shadow w-44 ">
                <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdownQuestionsStatisticsOptions">

                    @if($formlanguages)
                    <li class="flex justify-center items-center ">
                        <div class="grid  ">
                            <label for="languages" class="pointer-events-none   mb-0 max-w-[90%]  text-xs">{{ __('main.displaylangauge') }}</label>
                            <select wire:model="language" id="questions_menu" name="" class=" w-32  h-6 bg-gray-50 border border-gray-300 text-gray-900 text-xs
                        rounded-[0.5rem] focus:ring-blue-500 focus:border-blue-500 block

                                 p-0 px-1 " required>
                                @foreach ($formlanguages as $lang )
                                <option value="{{ $lang['code'] }}">{{ $lang['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>
                    @endif
                    <li class="flex justify-center items-center mt-4">
                        <x-jet-button data-toggle="modal" data-target="#Export_modal" class="" type="button">
                            {{ __('main.exportall') }}
                        </x-jet-button>
                    </li>

                </ul>
            </div>
        </div>




    </div>
    <div id="fullpage"  class="p-4 xs:p-1 max-h-[80vh]  xs:h-full xs:max-h-full  overflow-y-auto scrollbar scrollbar-thumb-secondary_blue scrollbar-track-gray-200 ">
        {{-- @foreach($formquestions as $key => $question) --}}
        <div id="question_template"  class="grid grid-cols-12  bg-white my-1 rounded-[0.5rem] border-[1px] border-gray-300  p-3 relative ">
            <div id="loading-animation" wire:loading   wire:loading.class.remove="opacity-0"    class="opacity-0 flex justify-center col-span-12 items-center absolute left-1/2 top-1/2  xs:top-1/4">
                <svg class="animate-spin h-10 w-10 mr-1 text-secondary_blue" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
                </svg>
            </div>


            {{--question detials  --}}
            <div wire:loading   wire:loading.class="opacity-0" class="col-span-12 w-full flex xs:grid  justify-between items-center ">
                <div class="col-span-11 xs:col-span-12  ">
                    <h1 id="question_text" class="text-black text-xl  xs:text-xs md:text-sm font-bold ">

                    </h1>
                </div>
                {{-- hidden or show question  --}}
                <div id="question_show" class="col-span-1 xs:col-span-12 mx-4 flex justify-end items-center">
                    @if($currentQuestion->show)
                    <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    @else
                    <svg class="w-6 h-6 text-red-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"></path>
                    </svg>
                    @endif
                </div>


            </div>
            {{-- info answers & dates filters & export option --}}
            <div wire:loading   wire:loading.class="opacity-0" class="flex justify-between items-center xs:block md:block col-span-12 md:row-span-1 xs:row-span-1 my-4 ">
                 {{-- question info --}}
                 <div class="grid xs:flex xs:my-2 bg-primary_blue px-8 xs:px-0 md:px-0">
                    {{-- age --}}
                    <div class="w-full flex  items-center my-[2px] ">
                        <div class="mx-1">
                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                            <svg fill="#000000" class="w-6 h-6" viewBox="-2.64 -2.64 29.28 29.28" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M20,3a1,1,0,0,0,0-2H4A1,1,0,0,0,4,3H5.049c.146,1.836.743,5.75,3.194,8-2.585,2.511-3.111,7.734-3.216,10H4a1,1,0,0,0,0,2H20a1,1,0,0,0,0-2H18.973c-.105-2.264-.631-7.487-3.216-10,2.451-2.252,3.048-6.166,3.194-8Zm-6.42,7.126a1,1,0,0,0,.035,1.767c2.437,1.228,3.2,6.311,3.355,9.107H7.03c.151-2.8.918-7.879,3.355-9.107a1,1,0,0,0,.035-1.767C7.881,8.717,7.227,4.844,7.058,3h9.884C16.773,4.844,16.119,8.717,13.58,10.126ZM12,13s3,2.4,3,3.6V20H9V16.6C9,15.4,12,13,12,13Z" />
                                </g>
                            </svg>
                        </div>
                        <div class="mx-1">
                            <h1 class="text-sm xs:text-xs md:text-sm"><span id="age-{{ $currentQuestion->id }}" class="font-bold"></span></h1>
                        </div>
                    </div>
                    {{-- answers --}}
                    <div class="w-full flex  items-center my-[2px]">
                        <div class="mx-1">
                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                            <svg class="w-6 h-6" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-83.3 -83.3 656.60 656.60" xml:space="preserve" width="800px" height="800px">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g>
                                            <g>
                                                <path d="M450,0h-410c-22.056,0-40,17.944-40,40v280c0,22.056,17.944,40,40,40h235v120c0,4.118,2.524,7.814,6.358,9.314 c1.184,0.463,2.417,0.687,3.639,0.687c2.738,0,5.42-1.126,7.35-3.218L409.38,360H450c22.056,0,40-17.944,40-40V40 C490,17.944,472.057,0,450,0z M470,320c0,11.028-8.972,20-20,20h-45c-2.791,0-5.455,1.167-7.348,3.217L295,454.423V350 c0-5.523-4.477-10-10-10h-245c-11.028,0-20-8.972-20-20V40c0-11.028,8.972-20,20-20h410c11.028,0,20,8.972,20,20V320z" />
                                                <path d="M144.881,80.001c-3.957,0.047-7.513,2.423-9.072,6.06l-75,175l18.383,7.878L106.594,205h79.982l29.329,64.158 l18.189-8.315l-80-175C152.45,82.244,148.863,79.974,144.881,80.001z M115.167,185l30.129-70.302L177.433,185H115.167z" />
                                                <rect x="255.001" y="115" width="80" height="20" />
                                                <rect x="350" y="115" width="60" height="20" />
                                                <rect x="255.001" y="165" width="180" height="20" />
                                                <rect x="255.001" y="215" width="75" height="20" />
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="mx-1">
                            <h1 class="text-sm xs:text-xs md:text-sm"><span id="total-answers-{{ $currentQuestion->id }}" class="font-bold"></span>{{ __('main.answers') }}</h1>
                        </div>
                    </div>
                    {{-- skip --}}
                    <div class="w-full flex  items-center my-[2px]">
                        <div class="mx-1">
                            <svg class="w-6 h-6 text-black" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="CurrentColor" class="bi bi-skip-forward">
                                <path d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.752l-6.267 3.636c-.52.302-1.233-.043-1.233-.696v-2.94l-6.267 3.636C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696L7.5 7.248v-2.94c0-.653.713-.998 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5zM1 4.633v6.734L6.804 8 1 4.633zm7.5 0v6.734L14.304 8 8.5 4.633z" />
                            </svg>
                        </div>
                        <div class="mx-1">
                            <h1 class="text-sm xs:text-xs md:text-sm"><span id="total-skipped-{{ $currentQuestion->id }}" class="font-bold"></span>{{ __('main.skips') }}</h1>
                        </div>
                    </div>
                </div>
                <div class=" flex items-center justify-between xs:block md:block md:row-span-1 xs:row-span-1 ml-1 mb-2 mt-2 w-[40%]  xs:w-full md:w-full">


                    {{-- dates  --}}
                    <div class="grid mr-1 xs:block xs:mt-2  items-center  md:block md:row-span-1 xs:row-span-1 xs:my-2">
                        <h1 class="text-sm text-center">{{ __('main.specifystatisticsdates') }}</h1>
                        <div id="date-{{ $currentQuestion->id }}" class="flex justify-center items-center mt-[2px] xs:max-w-xs p-1 ">
                        </div>
                    </div>
                    {{-- export options --}}
                    <div class="flex justify-center items-center xs:my-2 ">
                        <div wire:ignore class="group/main inline-block relative">

                            <x-jet-button id="dropdownRadioexportoptions-{{ $currentQuestion->id }}" data-dropdown-toggle="exportoptions-{{ $currentQuestion->id }}" class="" type="button">
                                {{ __('main.exportquestionas') }}<svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </x-jet-button>
                            {{-- if type of question is text then export as full or summary --}}
                            @if($currentQuestion->question_type=="short_text_question"||$currentQuestion->question_type=="long_text_question"||$currentQuestion->question_type=="date_question"
                            ||$currentQuestion->question_type=="email"||$currentQuestion->question_type=="number"||$currentQuestion->question_type=="drawing")
                            <div id="exportoptions-{{ $currentQuestion->id }}" class="z-20 hidden w-auto bg-white divide-y divide-gray-100 rounded-[0.5rem]  ">
                                <ul class="w-32 p-1 space-y-1 text-sm text-gray-700  border-[1px] rounded-[0.5rem] border-gray-200" aria-labelledby="dropdownRadioButton1">
                                    @if($allowexport)
                                    <li onclick="ExportSingle({{$currentQuestion->id}},'Excel','full')" class="w-full group/item hover:cursor-pointer whitespace-nowrap rounded-t text-secondary_blue p-1  whitespace-no-wrap inline-flex justify-center items-center">
                                        <span class="text-center">{{ __('Excel') }}</span>
                                    </li>
                                    @else
                                    <li onclick="ShowWarning()" class="w-full group/item m-1 hover:cursor-pointer whitespace-nowrap rounded-t text-secondary_blue py-2 px-4  whitespace-no-wrap inline-flex justify-center items-center">
                                        <span class="text-center">{{ __('Excel') }}</span>
                                    </li>
                                    @endif
                                </ul>
                            </div>

                            {{-- if type of question is not text then export as full only --}}
                            @else
                            <div id="exportoptions-{{ $currentQuestion->id }}" class="z-20 hidden w-auto bg-white divide-y divide-gray-100 rounded-[0.5rem]  ">
                                <ul class="w-32 p-1 space-y-1 text-sm text-gray-700  border-[1px] rounded-[0.5rem] border-gray-200" aria-labelledby="dropdownRadioButton1">
                                    @if($allowexport)
                                    <li onclick="ExportSingle({{ $currentQuestion->id }},'Excel','full')" class="w-full group/item hover:cursor-pointer whitespace-nowrap rounded-t text-secondary_blue p-1  whitespace-no-wrap inline-flex justify-center items-center">
                                        <span class="text-center">{{ __('Excel') }}</span>
                                    </li>
                                    @else
                                    <li onclick="ShowWarning()" class=" w-full group/item m-1 hover:cursor-pointer whitespace-nowrap rounded-t text-secondary_blue py-2 px-4  whitespace-no-wrap inline-flex justify-center items-center">
                                        <span class="text-center">{{ __('Excel') }}</span>
                                    </li>
                                    @endif
                                </ul>
                            </div>

                            @endif
                        </div>
                    </div>

                </div>



            </div>

            {{-- answers and charts --}}

            <div wire:loading wire:loading.class="opacity-0" id="question_answers" class="w-full col-span-12 ">

            </div>

        </div>

        {{-- @endforeach --}}
    </div>
    @else
    <x-nothaveresponses />
    @endif
    {{-- show in popup list modal --}}
    {{-- show in popup list modal --}}
    <div class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="show-response-question" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="show-response-question-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[1000px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
            <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">
                @livewire('show-response')
            </div>
        </div>
    </div>

    {{--Export modal --}}
    <div class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="Export_modal" tabindex="-1" role="dialog" aria-labelledby="Export-modal-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[1000px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
            <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">
                {{-- modal header --}}
                <div class="flex items-start justify-between p-4 xs:p-1 border-b rounded-t ">
                    <h3 class="text-xl font-semibold text-gray-900 ">
                        {{ __('  Export Options') }}
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-[0.5rem] text-sm p-1.5 ml-auto inline-flex
                    items-center  close" data-dismiss="modal" aria-label="Close">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                    011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                @if($allowexport)
                <form id="export_options ">
                    <div class=" overflow-y-auto scrollbar scrollbar-thumb-secondary_blue scrollbar-track-gray-200  2xl:max-h-[700px] xs:max-h-[400px]">
                        {{-- statistical --}}
                        <div class="flex items-center mt-4 px-4">
                            <input id="statistic_questions" checked type="checkbox" value="" class="w-4 h-4 text-secondary_blue bg-gray-100 border-gray-300 rounded   focus:ring-2  ">
                            <label for="statistic_questions" class="ml-2 mb-0 text-sm font-medium text-gray-900 ">{{ __('main.statisticquestions') }}</label>
                        </div>
                        {{-- unstatistical --}}
                        <div class="flex items-center mt-4 px-4">
                            <input onclick="CheckUnstatistics()" id="unstatistic_questions" type="checkbox" value="" class="w-4 h-4 text-secondary_blue bg-gray-100 border-gray-300 rounded   focus:ring-2  ">
                            <label for="unstatistic_questions" class="ml-2 mb-0 text-sm font-medium text-gray-900 ">{{ __('main.unstatisticquestions') }}</label>
                        </div>
                        <div id="unstatistic_questions_type" class="flex items-center px-8 pointer-events-none opacity-50">
                            <div class="mx-4">
                                <input disabled id="summary" type="radio" value="summary" name="typeunstatistics" class="w-4 h-4 text-secondary_blue bg-gray-100 border-gray-300 focus:ring-blue-500   focus:ring-2  ">
                                <label for="summary" class="ml-2 text-xs font-medium text-gray-900 ">{{__('main.summary')}}</label>
                            </div>
                            <div class="mx-4">
                                <input id="full" type="radio" value="full" name="typeunstatistics" class="w-4 h-4 text-secondary_blue bg-gray-100 border-gray-300 focus:ring-blue-500  focus:ring-2 ">
                                <label for="full" class="ml-2 text-xs font-medium text-gray-900 ">{{__('main.full')}}</label>
                            </div>
                        </div>
                        {{-- export type --}}
                        <div class="flex items-center mt-4 px-4">
                            <svg class=" w-4 h-4 text-secondary_blue bg-gray-100 border-gray-300 rounded   focus:ring-2 " fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                            </svg>
                            <span class="text-sm ml-2">{{__('main.exportedas')}}</span>
                        </div>
                        <div class="flex items-center px-8 ">

                            <div class="mx-4">
                                <input id="excel" type="radio" checked value="" name="reporttype" class="w-4 h-4 text-secondary_blue bg-gray-100 border-gray-300 focus:ring-blue-500  focus:ring-2 ">
                                <label for="excel" class="ml-2 text-sm font-medium text-gray-900 ">Excel</label>
                            </div>
                            <div class="mx-4">
                                <input id="pdf" disabled type="radio" value="" name="reporttype" class="w-4 h-4 text-secondary_blue bg-gray-100 border-gray-300 focus:ring-blue-500  focus:ring-2 ">
                                <label for="pdf" class="ml-2 text-sm font-medium text-gray-900 ">Pdf</label>
                            </div>
                        </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="flex justify-between items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">
                        <div>

                            <x-jet-secondary-button type="button" data-dismiss="modal" wire:loading.attr="disabled">
                                {{ __('main.cancel') }}
                            </x-jet-secondary-button>
                            <x-jet-button class="" type="button" onclick="ExportProcessing()">
                                {{ __('main.export') }}
                            </x-jet-button>
                        </div>
                        <div id="ErrorSection">

                        </div>
                    </div>
                </form>
                @else
                <form id="export_options">
                    <div class="flex justify-center items-center text-red-400">
                        {{ __('You cannot export files in free plan ,upgrade your plan ') }}
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.3/purify.min.js"></script>
{{-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script> --}}
<script src="{{ asset('https://unpkg.com/xlsx-populate/browser/xlsx-populate.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
<script src="{{ asset('https://unpkg.com/xlsx/dist/xlsx.full.min.js') }}"></script>
{{-- <script src="https://unpkg.com/pdf-lib@1.4.0"></script> --}}
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js')}}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script> --}}
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js')}}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js') }}"></script>

<script>

    var translations = @json(__('main'));
    var allDates;
    var questions;
    var allquestions;
    var start;
    var end;
    var dates;
    var typeofdate;
    var chartInstances = {};
    var form;
    var QestionData;
    var QuestionText = document.getElementById('question_text');
    var blobs = new Map();
    var idx = 0;
    var Statistics_checked, Unstatistics_checked, UnstatisticsType;
    var numofquestions = 0;
    var language;
    var languages;
    var Chars = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"
        , "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ"
    ];

    var satisfactionRates = {
        "Very Satisfied": 4
        , "راضي تماماٌ": 4
        , "Ganap na Nasiyahan": 4
        , "مکمل طور پر مطمئن": 4
        , "Satisfied": 3
        , "راضي": 3
        , "Nasiyahan": 3
        , "مطمئن": 3
        , "Natural": 2
        , "محايد": 2
        , "Natural": 2
        , "غیر جانبدار": 2
        , "Unsatisfied": 1
        , "غير راضي": 1
        , "غیر مطمئن": 1
        , "Hindi Nasisiyahan": 1
        , "Very Unsatisfied": 0
        , "غير راضي تماماٌ": 0
        , "مکمل طور پر غیر مطمئن": 0
        , "Ganap na Hindi Nasisiyahan": 0
    , };
    var paths = {
        "yes_no": "/resources/Yes or No Question.xlsx"
        , "rating": "/resources/Rating Question.xlsx"
        , "satisfaction": "/resources/Saisfaction Question.xlsx"
        , "rating_image": "/resources/Rating Question.xlsx"
        , "satisfaction_image": "/resources/Saisfaction Question.xlsx"
        , "mcq": "/resources/Multi Options Question.xlsx"
        , "mcq_pic": "/resources/Multi Options Question.xlsx"
        , "checkbox": "/resources/Multi Options Question.xlsx"
        , "checkbox_pic": "/resources/Multi Options Question.xlsx"
        , "custom_rating": "/resources/Saisfaction Question.xlsx"
        , "custom_satisfaction": "/resources/Saisfaction Question.xlsx"
        , "list": "/resources/Multi Options Question.xlsx"
        , "like_dislike": "/resources/Like or Dislike Question.xlsx"
        , "Agree_Disagree": "/resources/Agree or Disagree Question.xlsx",
        // "short_text_question":"/resources/.xlsx",
        // "email":"/resources/.xlsx",
        // "long_text_question":"/resources/.xlsx",
        // "date_question":"/resources/.xlsx",
        // "number":"/resources/.xlsx",
        "summary": ""
        , "full": "/resources/Non-Statistical Question Full.xlsx",

    };
    var mostchoosen=`<svg  class="w-6 h-6 md:w-4 md:h-4 xs:w-4 xs:h-4 text-valid" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
</svg>
`;
    var FilesPaths = JSON.parse(JSON.stringify(paths));
    var responseColumnsTranslations = {
        "ar": {
            "responseid": "الرقم"
            , "responsedate": "التاريخ"
            , "answer": "الأجابة"
        }
        , "en": {
            "responseid": "Id"
            , "responsedate": "Date"
            , "answer": "Answer"
        }
        , "ur": {
            "responseid": "آئی ڈی"
            , "responsedate": "تاریخ"
            , "answer": "جواب دیں۔"
        }
        , "tl": {
            "responseid": "Id"
            , "responsedate": "petsa"
            , "answer": "Sagot"
        }
    }

    var colorArray = ["#1E88E5", "#E53935", "#FDD835", "#43A047", "#546E7A", "#FB8C00", "#6D4C41", "#8E24AA", "#C0CA33", "#00ACC1"
        , "#42A5F5", "#EF5350", "#FFEE58", "#66BB6A", "#78909C", "#FFA726", "#8D6E63", "#AB47BC", "#D4E157", "#26C6DA"
        , "#90CAF9", "#EF9A9A", "#FFF59D", "#A5D6A7", "#B0BEC5", "#FFCC80", "#BCAAA4", "#CE93D8", "#E6EE9C", "#80DEEA"
        , "#1565C0", "#B71C1C", "#F57F17", "#1B5E20", "#263238", "#E65100", "#3E2723", "#4A148C", "#827717", "#006064"
        , "#E3F2FD", "#FFEBEE", "#FFFDE7", "#E8F5E9", "#ECEFF1", "#FFF3E0", "#D7CCC8", "#F3E5F5", "#F0F4C3", "#B2EBF2",

    ];
    //  show  warning of allow export or no
    function ShowWarning() {
        Swal.fire({
            icon: 'error'
            , title: 'Oops...'
            , text: 'Something went wrong!'
            , footer: '<a href="">Why do I have this issue?</a>'
        })
    }

    //    export form action

    function ExportProcessing() {


        validate = ValidateSelectForExport();
        if (validate) {

            Statistics = document.getElementById('statistic_questions');
            Unstatistics = document.getElementById('unstatistic_questions');
            if (Unstatistics.checked)
                UnstatisticsType = document.querySelector('input[name="typeunstatistics"]:checked').value;
            else
                UnstatisticsType = null;
            var ExportType = document.getElementsByName("reporttype");
            Statistics_checked = Statistics.checked;
            Unstatistics_checked = Unstatistics.checked;
            Livewire.emit('getAllQuestions');



        }

    }
    //to disbale or not disable
    function CheckUnstatistics() {
        Unstatistics = document.getElementById('unstatistic_questions');
        UnstatisticsTypeDiv = document.getElementById('unstatistic_questions_type');
        if (Unstatistics.checked)
            UnstatisticsTypeDiv.classList.remove("pointer-events-none", "opacity-50");
        else
            UnstatisticsTypeDiv.classList.add("pointer-events-none", "opacity-50");
    }
    //validate buttons
    function ValidateSelectForExport() {
        Statistics = document.getElementById('statistic_questions');
        Unstatistics = document.getElementById('unstatistic_questions');

        ErrorSection = document.getElementById('ErrorSection');
        ErrorSection.innerHTML = ``;
        if (!Statistics.checked && !Unstatistics.checked) {
            ErrorSection.innerHTML = `<span class="text-xs text-red-300">Please select al least one option (Statistics or Unstatistics)</span>`;
            return false;
        } else if (Unstatistics.checked) {

            if (!isRadioGroupValid("typeunstatistics")) {
                ErrorSection.innerHTML = `<span class="text-xs text-red-300">Please select al least one option of Unstatistcs type (Summary or Full)</span>`;
                return false;
            }
        } else if (!isRadioGroupValid("reporttype")) {

            ErrorSection.innerHTML = `<span class="text-xs text-red-300">Please select al least one option of Export file type (Excel or PDF)</span>`;
            return false;
        }
        return true;
    }
    //  validate radio buttons
    function isRadioGroupValid(groupName) {
        var radioButtons = document.getElementsByName(groupName);
        for (var i = 0; i < radioButtons.length; i++) {
            if (radioButtons[i].checked) {
                return true;
            }
        }
        return false;
    }
    //event export
    window.addEventListener('export', (e) => {

        Export(e.detail.questions, e.detail.start, e.detail.end, Statistics_checked, Unstatistics_checked, UnstatisticsType);

    });
    // export all questions=>form report
    async function Export(questions, start, end, statisitcs, unstatistics, type = null) {
        // initialQuestionTextType(question.data,question.id,question.created_at,allDates,question.type,question.type_text);


        questions.forEach(question => {
            if ((question.type == "short_text_question" || question.type == "long_text_question" || question.type == "date_question" ||
                    question.type == "email" || question.type == "number" || question.type == "drawing"))
                unstatistics == true ? numofquestions += 1 : "";
            else
                statisitcs == true ? numofquestions += 1 : "";

        });


        questions.forEach(function(question, i) {

            if ((question.type == "short_text_question" || question.type == "long_text_question" || question.type == "date_question" ||
                    question.type == "email" || question.type == "number" || question.type == "drawing")) {

                unstatistics == true ? Createexcelfile(question.data, question, start, end, "unstatistics", type, FilesPaths['full'], false, i) : "";


            } else {

                data = initialQuestionData(question);
                Createexcelfile(data, question, start, end, "statistics", null, FilesPaths[question.type], false, i);
                // setQuestionAnswer(question,data);
                // drawQuestionCharts(question,data,dates,typeofdate);
            }

        });



    }
    // export single question
    function ExportSingle(question_id, filetype, type = null) {

        var question;
        var questionIndex;
        // get question data by it id
        for (const [i, q] of questions.entries()) {
    if (question_id == q.id) {
        questionIndex = i + 1;
        break;
    }
}

        if (QestionData.question_type == "short_text_question" || QestionData.question_type == "long_text_question" || QestionData.question_type == "date_question" ||
            QestionData.question_type == "email" || QestionData.question_type == "number" || QestionData.question_type == "drawing") {
            path = FilesPaths['full'];
            startdate = document.getElementById(`startdate-${QestionData.id}`).value;
            enddate = document.getElementById(`enddate-${QestionData.id}`).value;
            Createexcelfile(QestionData.data, QestionData, startdate, enddate, "unstatistics", type, path, true, questionIndex);


        } else {
            path = FilesPaths[QestionData.type];
            data = initialQuestionData(QestionData);
            startdate = document.getElementById(`startdate-${QestionData.id}`).value;
            enddate = document.getElementById(`enddate-${QestionData.id}`).value;
            Createexcelfile(data, QestionData, startdate, enddate, "statistics", null, path, true, questionIndex);
        }


    }
    // create excel file for question and store blob for export all or download file for single export
    function Createexcelfile(data, question, start, end, type, Typeunstatisitcs, filePath, single = false, questionIndex) {

        var totalAnswers = 0;
        var totalSkipped = 0;
        var totalRating = 0;
        var max = 0;
        startdate = start;
        enddate = end;
        var dates = getDaysArray(startdate, enddate);


        fetch(filePath)
            .then(response => response.arrayBuffer())
            .then(buffer => {
                const workbook = XlsxPopulate.fromDataAsync(buffer);

                return workbook.then(workbook => {
                    // statistics
                    if (type == "statistics") {
                        data.question_data.forEach(function(answer, i) {
                            answer.answer_sum = answer.counts.reduce((partialSum, a) => partialSum + a, 0);
                            totalAnswers += answer.answer_sum;
                            totalSkipped = answer.answer_skipped;
                            answer.answer_sum > max ? max = answer.answer_sum : "";
                        });
                        const sheet = workbook.sheet(0);
                        const sheet2 = workbook.sheet(1);
                        // Add data to specific cells

                        sheet.cell('B8').value(question.question_details);
                        sheet.cell('D6').value(calcDate(new Date(), new Date(formatDate(question.created_at))));
                        sheet.cell('E6').value(totalAnswers);
                        sheet.cell('F6').value(totalSkipped);
                        sheet.cell('B6').value(question.type_text);
                        data.question_data.forEach(function(answer, i) {
                            answer.ratio = ((100 * answer.answer_sum) / totalAnswers).toFixed(1);
                            question.type != "satisfaction" && question.type != "satisfaction_image" ? sheet.cell(`B${i+15}`).value(Chars[i]) : "";
                            sheet.cell(`C${i+15}`).value(answer.answer_details);
                            sheet.cell(`D${i+15}`).value(answer.answer_sum);
                            // sheet.cell(`E${i+15}`).value(answer.ratio+' %');

                            if (answer.answer_sum == max && max > 0) {
                                sheet.cell(`F${i+15}`).value(translations.mostchoosen);
                                sheet.cell(`F${i+15}`).style({
                                    fill: {
                                        type: 'solid'
                                        , color: '90EE90'
                                    }
                                });
                            }

                        });
                        // dates in sheet 2
                        for (let index = 0; index < dates.length; index++) {

                            sheet2.cell(`A${index+1}`).value(dates[index]);
                        }
                        // answers in cells  in sheet 2
                        data.question_data.forEach(function(answer, i) {
                            for (let j = 0; j < answer.counts.length; j++) {
                                sheet2.cell(`${Chars[i+1]}${j+1}`).value(answer.counts[j]);

                            }
                        });
                        // if question is satisfaction or rating then add level values in cells
                        if (question.type == "satisfaction" || question.type == "satisfaction_image" || question.type == "rating_image" || question.type == "rating") {
                            var satisfactionRating = JSON.parse(JSON.stringify(satisfactionRates));
                            level = [];
                            // intial data for dates set
                            for (let i = 0; i < dates.length; i++) {
                                TotalAnswersPerDate = 0;
                                level[i] = 0;
                                Levelperdate = 0;
                                data.question_data.forEach(function(answer, j) {
                                    TotalAnswersPerDate += answer.counts[i];
                                    question.type == "rating" || question.type == "rating_image" ? Levelperdate += (answer.answer_details - 1) * answer.counts[i] : Levelperdate += satisfactionRating[answer.answer_details] * answer.counts[i];
                                });

                                if (TotalAnswersPerDate == 0 && i > 0)
                                    level[i] = level[i - 1];
                                else if (TotalAnswersPerDate == 0 && i == 0)
                                    level[i] = 0;
                                else
                                    level[i] = (Levelperdate * 100) / (TotalAnswersPerDate * 4);

                            }

                            for (let j = 0; j < level.length; j++) {
                                sheet2.cell(`G${j+1}`).value(level[j]);
                            }
                        }

                    }
                    //unstatistics
                    else {

                        const sheet = workbook.sheet(0);
                        if (Typeunstatisitcs == "full") {
                            // sheet.cell('E6').value(document.getElementById(`age-${question.id}`).innerText);
                            totalAnswers = 0;
                            totalSkipped = 0;
                            question.data.forEach(function(response, i) {
                                if (response.answer_details != null) totalAnswers += 1;
                                else if (response.type_skip != null) totalSkipped += 1;
                            });
                            sheet.cell('B6').value(totalAnswers);
                            sheet.cell('C6').value(totalSkipped);
                            sheet.cell('B8').value(question.question_details);
                            sheet.cell('D6').value(question.type_text);
                            data.forEach(function(response, i) {
                                sheet.cell(`B${i+11}`).value(response.id_view);

                                sheet.cell(`C${i+11}`).value(formatDate(response.date));
                                response.answer_details == null ?
                                    (response.type_skip != null ?
                                        (response.type_skip == "user" ? sheet.cell(`D${i+11}`).value(translations.skipbyuser) : sheet.cell(`D${i+11}`).value(translations.autoskip)) :
                                        sheet.cell(`D${i+11}`).value(translations.noanswer)) :
                                    sheet.cell(`D${i+11}`).value(response.answer_details);
                            });
                        } else {

                        }

                    }






                    // Add more cells as needed

                    // Save the modified workbook

                    return workbook.outputAsync();

                });
            })
            // add some of setting to download
            .then(fileData => {

                const blob = new Blob([fileData], {
                    details: question.question_details
                }, {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });

                idx += 1;

                blobs.set(questionIndex, blob);

                if (idx == numofquestions && single == false)
                    CreateZip(blobs);
                else if (single) {
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    const currentDate = new Date();
                    $currentDate = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getDate();
                    a.download = form.form_title + '_Question' + questionIndex + '_' + $currentDate + '_' + languages[language]['name'] + '.xlsx'; // Set the desired name for the downloaded file
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }
            });

    }

    // create zip file for all questions blobs and download it
    function CreateZip(excelFiles) {

        var zip = new JSZip();
        // Add each Excel file to the zip
        for (const [key, value] of excelFiles.entries()) {
            var excelFile = value;
            var fileName = "Question" + (key + 1) + ".xlsx"; // Change the file name as per your requirement
            zip.file(fileName, excelFile, {
                binary: true
            });
        }

        // Generate the zip content asynchronously
        zip.generateAsync({
            type: "blob"
        }).then(function(content) {
            // Create a download link for the zip file
            var link = document.createElement("a");
            link.href = URL.createObjectURL(content);
            const currentDate = new Date();
            $currentDate = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getDate();
            link.download = form.form_title + "_Questions Statistics_" + $currentDate + '_' + languages[language]['name'] + ".zip"; // Change the zip file name as per your requirement

            // Append the link to the document and click it to start the download
            document.body.appendChild(link);
            link.click();

            // Clean up the link element
            document.body.removeChild(link);
            blobs = new Map();

        });

        window.location.reload();
    }

    // set question data after get the data of this question from server
    window.addEventListener('SetQuestionsData', (e) => {

        language = e.detail.language;
        languages = e.detail.languages;

        form = e.detail.form;
        QestionData = e.detail.questionsData;


        start = e.detail.start;
        end = e.detail.end;

        QuestionText.innerHTML = QestionData.question_details;

        // get all dates
        allDates = getDaysArray(e.detail.start, e.detail.end);
        allDates = convertalldates(allDates);

        allDates.length < 31 ? typeofdate = "day" : (allDates.length > 31 && allDates.length < 366 ? typeofdate = "month" : typeofdate = "year");
        dates = allDates;
        // set dates  ranges
        document.getElementById(`date-${QestionData.id}`).innerHTML = `
                        <div class=" flex items-center ">
                                    <h1 class="w-[20%] text-center ml-1 mr-1 text-sm xs:text-xs">{{ __('Start:') }} </h1>
                                        <input type="date" data-date-format="DD MM YYYY" onchange="changeDate(${QestionData.id})" class="w-[80%] rounded-[0.5rem] h-8 text-sm p-[1px]" name="" value="${start}" id="startdate-${QestionData.id}">
                        </div>
                        <div class=" mt-1 flex items-center"><h1 class="w-[20%] text-center ml-1 mr-1 text-sm xs:text-xs">{{ __('End:') }}
                        </h1> <input type="date" onchange="changeDate(${QestionData.id})" class="w-[80%] rounded-[0.5rem] h-8 text-sm p-[1px]"  name="" value="${end}" id="enddate-${QestionData.id}"></div>
                `;

        if (QestionData.question_type == "short_text_question" || QestionData.question_type == "long_text_question" || QestionData.question_type == "date_question" ||
            QestionData.question_type == "email" || QestionData.question_type == "number" || QestionData.question_type == "drawing") {
            document.getElementById('question_answers').innerHTML = `
                <div class=" col-span-12 md:row-span-4 xs:row-span-4">
                       <div  class="w-full h-full max-h-[475px] min-h-[475px]  md:w-full xs:w-full md:h-full xs:h-full   ">
                           <div class="flex  xs:text-xs md:text-sm text-secondary_blue"><h1>${translations.answers}</h1></div>
                           <div id="answers-${ QestionData.id }" class="  mb-1  ">
                           <div id="search-${ QestionData.id }">
                           </div>
                           <div id="table-${ QestionData.id }" class="border border-gray-300 rounded-[0.5rem] p-2">

                           </div>
                           </div>

                       </div>
                </div>`;
            // set dates
            search_section = document.getElementById(`search-${QestionData.id}`);
            search_section.innerHTML = ``;
            search_section.innerHTML += `
                    <div class="relative w-[300px] mb-2">

                                    <input  id="search_textquestion-${QestionData.id}" class="block w-[300px] p-1 h-8  text-sm text-gray-900 border
                                    border-gray-300 rounded-[0.5rem] bg-gray-50
                                      holder-gray-400 " placeholder="Search" required>
                                    <button onclick="resetSearch(${QestionData.id})" type="button" class="text-white absolute right-[2px] bottom-[8px]   focus:ring-0
                                    focus:outline-none  font-medium rounded-[0.5rem] text-sm px-4
                                    "><svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg></button>
                    </div>`;

            initialQuestionTextType(QestionData.data, QestionData.id, QestionData.created_at, allDates, QestionData.question_type, QestionData.type_text);
        } else {
            document.getElementById('question_answers').innerHTML = `
                <div class="flex xs:block md:block col-span-12 md:row-span-4 xs:row-span-4">
                        <div  class="w-[60%] mr-4 h-full md:w-full xs:w-full md:h-1/4 xs:h-1/4 max-h-[475px] min-h-[475px]  ">
                            <div class="flex   xs:text-xs md:text-sm text-secondary_blue ">
                                <div><h1>${translations.answers}</h1></div>
                                <div  id="Satisfaction-${ QestionData.id }" class="flex justify-between items-center ml-4">

                                </div>

                            </div>

                            <div  class=" max-h-[425px] overflow-y-auto scrollbar scrollbar-thumb-secondary_blue scrollbar-track-gray-200  ">
                                <ul id="answers-${ QestionData.id }"  class="">

                                </ul>

                            </div>

                        </div>
                        <div class="w-[40%] lg:w-[60%] md:w-[60%] xs:w-full xs:min-h-full xs:max-h-full max-h-[475px] min-h-[475px]  xs:max-w-full">
                            <div class="grid grid-cols-12 w-1/4 xs:w-1/2 h-8">
                                <button class="text-xs text-white bg-secondary_blue col-span-6 h-full border border-gray-200 rounded-[0.5rem]" onclick="SwitchChart(${QestionData.id})" id="buttonSwitchChartline-${QestionData.id}">Line Chart</button>
                                <button disabled class="text-xs col-span-6 text-white bg-secondary_blue h-full opacity-50 border border-gray-200 rounded-[0.5rem]" onclick="SwitchChart(${QestionData.id})" id="buttonSwitchChartpie-${QestionData.id}">Pie Chart</button>

                            </div>

                            {{-- charts overflow-y-auto scrollbar scrollbar-thumb-secondary_blue scrollbar-track-gray-200 --}}
                            <div id="charts-${ QestionData.id }" class="overflow-y-auto scrollbar scrollbar-thumb-secondary_blue scrollbar-track-gray-200  grid grid-cols-12 gap-2 p-1 items-center justify-center w-full h-full max-h-[375px] xs:max-h-full  md:w-full xs:w-full md:h-3/4 xs:h-3/4   ">

                                <div id="chartPie" class="h-full p-4 xs:p-1 col-span-12 border border-gray-200 rounded-[0.5rem] ">
                                    <div class="flex justify-end items-center" ><a id="button-pie-${ QestionData.id }" onclick="showLegend('pie-${ QestionData.id }')" class="text-secondary_blue text-sm xs:text-xs hover:cursor-pointer hover:no-underline">${translations.hidelabels}</a></div>
                                    <div class="flex justify-center items-center  w-full h-full"><canvas id="pie-${ QestionData.id }" class="w-full h-auto" ></canvas></div>
                                </div>

                                <div id="chartLine" class="hidden h-full p-4  xs:p-1 col-span-12 border border-gray-200 rounded-[0.5rem]">
                                    <div class="flex justify-end items-center" ><a id="button-line-${ QestionData.id }" onclick="showLegend('line-${ QestionData.id }')" class="text-secondary_blue text-sm xs:text-xs hover:cursor-pointer hover:no-underline">${translations.hidelabels}</a></div>
                                    <div class="flex justify-center items-center  w-full h-full"><canvas id="line-${ QestionData.id }" class="w-full h-auto"></canvas></div>
                                </div>

                            </div>
                        </div>
                    </div>
                `;

            // set dates


            data = initialQuestionData(QestionData);

            setQuestionAnswer(QestionData, data);
            drawQuestionCharts(QestionData, data, dates, typeofdate);

        }


    });
    // window.addEventListener('refresh_allquestions', (e) => {
    //         language=e.detail.language;
    //         languages=e.detail.languages;
    //         // allDates=convertalldates(allDates);
    //         form=e.detail.form;
    //         questions=e.detail.questions;

    //         allquestions=e.detail.questions;
    //         start=e.detail.start;
    //         end=e.detail.end;
    //         AllowExport=e.detail.allowexport;

    //         allDates=getDaysArray(e.detail.start,e.detail.end);
    //         allDates=convertalldates(allDates);
    //         //  detect type of date
    //         allDates.length<31?typeofdate="day":( allDates.length>31&& allDates.length<366?typeofdate="month":typeofdate="year");
    //         dates=allDates;
    //         if(e.detail.responses!=null){
    //         questions.forEach(question => {

    //             document.getElementById(`date-${question.id}`).innerHTML=`
    //                 <div class=" flex items-center ">
    //                             <h1 class="w-[20%] text-center ml-1 mr-1 text-sm xs:text-xs">{{ __('Start:') }} </h1>
    //                                 <input type="date" data-date-format="DD MM YYYY" onchange="changeDate(${question.id})" class="w-[80%] rounded-[0.5rem] h-8 text-sm p-[1px]" name="" value="${start}" id="startdate-${question.id}">
    //                 </div>
    //                 <div class=" mt-1 flex items-center"><h1 class="w-[20%] text-center ml-1 mr-1 text-sm xs:text-xs">{{ __('End:') }}
    //                 </h1> <input type="date" onchange="changeDate(${question.id})" class="w-[80%] rounded-[0.5rem] h-8 text-sm p-[1px]"  name="" value="${end}" id="enddate-${question.id}"></div>
    //             `;
    //             if(question.type=="short_text_question"||question.type=="long_text_question"||question.type=="date_question"
    //             ||question.type=="email"||question.type=="number"||question.type=="drawing")
    //             {
    //                 // add serach section
    //                 search_section=document.getElementById(`search-${question.id}`);
    //                 search_section.innerHTML=``;
    //                 search_section.innerHTML+=`
    //                         <div class="relative w-[300px] mb-2">

    //                             <input  id="search_textquestion-${question.id}" class="block w-[300px] p-1 h-8  text-sm text-gray-900 border
    //                             border-gray-300 rounded-[0.5rem] bg-gray-50
    //                               holder-gray-400 " placeholder="Search" required>
    //                             <button onclick="resetSearch(${question.id})" type="button" class="text-white absolute right-[2px] bottom-[8px]   focus:ring-0
    //                             focus:outline-none  font-medium rounded-[0.5rem] text-sm px-4
    //                             "><svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    //                                 <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
    //                             </svg></button>
    //                         </div>`;

    //                 initialQuestionTextType(question.data,question.id,question.created_at,allDates,question.type,question.type_text);

    //             }
    //             else{
    //                 data=initialQuestionData(question);

    //                 setQuestionAnswer(question,data);
    //                 drawQuestionCharts(question,data,dates,typeofdate);

    //             }
    //         });
    //     }

    // });
    // take two dates(s,e) and return days between it
    var getDaysArray = function(s, e) {
        for (var a = [], d = new Date(s); d <= new Date(e); d.setDate(d.getDate() + 1)) {
            a.push(new Date(d));
        }
        return a;
    };
    window.addEventListener('livewire:load', function() {
        Livewire.emit('getQuestionData', @this.form_id);


    })

    function resetSearch(id) {
        document.getElementById(`search_textquestion-${QestionData.id}`).value = "";
        initialQuestionTextType(QestionData.data, QestionData.id, QestionData.created_at, allDates, QestionData.type, QestionData.type_text);
    }


    // seraching of text question
    const searching_TextQuestion = function(e) {
        var text = new RegExp(e.target.value, 'gi');
        id_spliter = e.srcElement.id.split("-");
        id = id_spliter[1];

        if (e.target.value.match(/^\s*$/)) {
            initialQuestionTextType(QestionData.data, QestionData.id, QestionData.created_at, allDates, QestionData.type, QestionData.type_text);
        } else {
            questionsearch = QestionData;
            searcheddata = [];
            QestionData.data.forEach(response => {
                if (response.answer_details != null) {
                    if (response.answer_details.match(text) || response.date.match(text))
                        searcheddata.push(response);
                }
            });

            initialQuestionTextType(searcheddata, QestionData.id, QestionData.created_at, allDates, QestionData.type, QestionData.type_text);

        }


    }
    // drawing pie charts
    function drawPie(question, answersData) {
        var labels = [];
        var dataset = [];
        answersData.question_data.forEach(function(answer, i) {

            dataset[i] = answer.answer_sum;
            labels[i] = answer.answer_details;
        });
        const bgColor = {
            id: 'bgColor'
            , beforeDraw: (chart, options) => {
                const {
                    ctx
                    , width
                    , height
                } = chart;
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, width, height)
                ctx.restore();
            }
        }

        const data = {
            labels: labels
            , datasets: [{
                label: 'answer/num of answers'
                , data: dataset
                , backgroundColor: colorArray
                , borderColor: [

                    'transparent'

                ]
                , borderWidth: 1
            }]
        };

        // config
        const config = {
            type: 'pie'
            , data
            , options: {
                responsive: true
                , legend: {
                    position: 'right'
                , }
                , plugins: {

                }
            }

        };
        // render init block
        pie_chart = new Chart(
            document.getElementById(`pie-${question.id}`)
            , config
        );
        chartInstances[`pie-${question.id}`] = pie_chart;

    }
    // drawing  line chart
    function drawLine(question, answersData, dates, typedate) {
        var Dataset = [];

        answersData.question_data.forEach(function(answer, i) {
            var newDataset = {
                label: answer.answer_details
                , data: answer.counts
                , borderColor: colorArray[i]
                , backgroundColor: colorArray[i]
                , fill: false
                , borderWidth: 1
            }

            Dataset.push(newDataset);
        });

        const data = {
            labels: dates
            , datasets: Dataset
        };

        // config
        const bgColor = {
            id: 'bgColor'
            , beforeDraw: (chart, options) => {
                const {
                    ctx
                    , width
                    , height
                } = chart;
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, width, height)
                ctx.restore();
            }
        }
        const config = {
            type: 'line'
            , data
            , options: {
                responsive: true
                , scales: {
                    x: {
                        type: 'time'
                        , time: {
                            unit: typedate

                        }
                    }
                }
                , legend: {
                    display: true
                    , position: 'top',

                },

                plugins: {

                    title: {
                        display: true
                        , text: 'Number Of each answer'
                    }

                }

            }
            , plugins: [bgColor]
        };

        // render init block
        line_chart = new Chart(
            document.getElementById(`line-${question.id}`)
            , config
        );

        chartInstances[`line-${question.id}`] = line_chart;




    }
    // drawing  line chart for rating and satisfaction questions
    function drawLine_rating(question, answersData, dates, typedate) {

        var satisfactionRating = JSON.parse(JSON.stringify(satisfactionRates));
        var Dataset = [];
        level = [];
        TotalAnswers = [];
        var TotalAnswersPerDate = 0;
        // intial data for dates set
        for (let i = 0; i < dates.length; i++) {
            TotalAnswersPerDate = 0;
            level[i] = 0;
            Levelperdate = 0;
            answersData.question_data.forEach(function(answer, j) {
                TotalAnswersPerDate += answer.counts[i];
                question.type == "rating" || question.type == "rating_image" ? Levelperdate += (answer.answer_details - 1) * answer.counts[i] : Levelperdate += satisfactionRating[answer.answer_details] * answer.counts[i];
            });

            if (TotalAnswersPerDate == 0 && i > 0)
                level[i] = level[i - 1];
            else if (TotalAnswersPerDate == 0 && i == 0)
                level[i] = 0;
            else
                level[i] = (Levelperdate * 100) / (TotalAnswersPerDate * 4);


            TotalAnswers[i] = TotalAnswersPerDate;
        }
        question.level = level;
        //  dataset 1
        var newDataset = {
            label: "Satisfaction Level"
            , data: level
            , borderColor: colorArray[0]
            , backgroundColor: colorArray[0]
            , borderWidth: 1
            , fill: false
        }

        Dataset.push(newDataset);
        //  dataset 2
        var newDataset1 = {
            label: "Answers Count"
            , data: TotalAnswers
            , borderColor: colorArray[1]
            , backgroundColor: colorArray[1]
            , borderWidth: 1
            , fill: false

        }

        Dataset.push(newDataset1);

        const data = {
            labels: dates
            , datasets: Dataset
        };

        // config
        const bgColor = {
            id: 'bgColor'
            , beforeDraw: (chart, options) => {
                const {
                    ctx
                    , width
                    , height
                } = chart;
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, width, height)
                ctx.restore();
            }
        }
        const config = {
            type: 'line'
            , data
            , options: {
                responsive: true
                , scales: {
                    x: {
                        type: 'time'
                        , time: {
                            unit: typedate

                        }
                    }
                }
                , plugins: {
                    legend: {

                        position: 'right'
                    , },

                    title: {
                        display: true
                        , text: 'Number Of each answer'
                    }

                }
            }
            , plugins: [bgColor]
        };

        // render init block
        line_chart = new Chart(
            document.getElementById(`line-${question.id}`)
            , config
        );

        chartInstances[`line-${question.id}`] = line_chart;


    }
    // SwitchChart
    function SwitchChart(id) {

        var chartPie = document.getElementById('chartPie');
        var chartLine = document.getElementById('chartLine');
        var buttonLine = document.getElementById(`buttonSwitchChartline-${id}`);
        var buttonPie = document.getElementById(`buttonSwitchChartpie-${id}`);


        if (chartPie.classList.contains("hidden")) {
            chartPie.classList.remove("hidden");
            chartPie.classList.add("block");
            buttonLine.classList.remove("opacity-50");
            // buttonLine.classList.add("text-white","bg-secondary_blue");
            buttonLine.removeAttribute("disabled");
            buttonPie.classList.add("opacity-50");
            buttonPie.setAttribute("disabled");
            chartLine.classList.remove("block");
            chartLine.classList.add("hidden");
        } else {
            chartPie.classList.remove("block");
            chartPie.classList.add("hidden");
            buttonPie.classList.remove("opacity-50");
            // buttonPie.classList.add("text-white","bg-secondary_blue");
            buttonPie.removeAttribute("disabled");
            buttonLine.classList.add("opacity-50");
            buttonLine.setAttribute("disabled");
            chartLine.classList.remove("hidden");
            chartLine.classList.add("block");
        }

    }
    //   drawing charts for each question
    async function drawQuestionCharts(question, answersData, dates, typedate) {


        pie = await drawPie(question, answersData);
        // question.type=="custom_satisfaction"||question.type=="custom_rating"
        if (question.type == "rating" || question.type == "satisfaction" || question.type == "rating_image" || question.type == "satisfaction_image")
            chart = await drawLine_rating(question, answersData, dates, typedate);
        else
            chart = await drawLine(question, answersData, dates, typedate);


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
    //   initial question of type text
    function initialQuestionTextType(data, id, created_at, dates, question_type, type_text) {
        var totalAnswers = 0;
        var totalSkipped = 0;
        var responsecolumntrans = JSON.parse(JSON.stringify(responseColumnsTranslations));
        table_section = document.getElementById(`table-${id}`);
        table_section.innerHTML = ``;
        table_section.innerHTML += `<div class="w-full overflow-y-auto    max-h-[400px] scrollbar scrollbar-thumb-secondary_blue scrollbar-track-gray-200 ">
                <table class="answer_table-${id} table-fixed  w-full" >
                                <thead class="h-10">
                                    <tr id="tablehead-${id}" class=" border-b-[1px] border-t-[1px] p-1  bg-secondary_blue text-white ">

                                    </tr>
                                </thead>
                                    <tbody id="tablebody-${id}" class="bg-white " >
                                    </tbody>
                                </table></div>
                                `;
        // get table head and body
        tablehead = document.getElementById(`tablehead-${id}`);
        tablebody = document.getElementById(`tablebody-${id}`);
        language == 'ar' || language == 'ur' ? textalign = "text-right" : textalign = "text-left";


        //response date
        tablehead.innerHTML += `<th data-sortas="datetime"  data-bs-toggle="tooltip"  data-bs-html="true" title=""   class="${textalign}    sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center">${translations.responsedate}</th>`;
        // response date
        tablehead.innerHTML += `<th    data-bs-toggle="tooltip"  data-bs-html="true" title=""  class="${textalign}  sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center " >${translations.answer}</th>`;
        // chooses / buttons
        tablehead.innerHTML += `<th  data-bs-toggle="tooltip"  data-bs-html="true" title=""   class="${textalign}  sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center">${translations.viewfullresponses}</th>`;

        data.forEach(function(response, i) {

            if (dates.includes(formatDate(response.date))) {
                var defultTbody = document.createElement('tr');
                defultTbody.classList.add('hover:border-2', 'hover:border-secondary_blue', 'hover:z-20', 'hover:shadow', 'w-full', 'p-1', 'border-b-[1px]', 'border-gray-200');
                defultTbody.id = `response-${id}-${response.response_id}`;
                tablebody.appendChild(defultTbody);


                // 2 response date

                defultTbody.innerHTML += ` <td  class="max-h-8 pl-2  " id='response_date-${id}-${response.response_id}'>

                        <div data-bs-toggle="tooltip"  data-bs-html="true" title="${response.date}"  class="hover:cursor-pointer min-h-[35px] max-h-[35px] overflow-hidden truncate flex justify-center items-center">
                            <span class="text-sm xs:text-xs truncate text-center ">${response.date}</span>
                        </div>
                        </td>`;
                // 3 response answer
                if (response.answer_details != null) {
                    answer = question_type == "drawing" ? "Signed" : response.answer_details;
                    defultTbody.innerHTML += ` <td  class="max-h-8 pl-2" id='response_answer-${id}-${response.response_id}'>

                        <div data-bs-toggle="tooltip"  data-bs-html="true" title="${answer}"  class="hover:cursor-pointer min-h-[35px] max-h-[35px] overflow-hidden truncate flex justify-center items-center">
                                <span class="text-sm xs:text-xs truncate text-center">${answer}</span>
                            </div>
                        </td>`;
                    totalAnswers += 1;

                } else if (response.type_skip != null) {
                    response.type_skip == "user" ?
                        defultTbody.innerHTML += `
                        <td  class="max-h-8 pl-2" id='response_answer-${id}-${response.response_id}'>
                        <div data-bs-toggle="tooltip"  data-bs-html="true" title="Skipped by ${response.type_skip}"  class="hover:cursor-pointer min-h-[35px] max-h-[35px] overflow-hidden truncate flex justify-center items-center">
                        <div class="flex justify-center items-center"><span class="text-sm xs:text-xs truncate text-center ">${translations.skipbyuser}</span>

                        <svg class="mx-1 w-6 h-6 text-yellow-500" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="CurrentColor" class="bi bi-skip-forward">
                        <path d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.752l-6.267 3.636c-.52.302-1.233-.043-1.233-.696v-2.94l-6.267 3.636C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696L7.5 7.248v-2.94c0-.653.713-.998 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5zM1 4.633v6.734L6.804 8 1 4.633zm7.5 0v6.734L14.304 8 8.5 4.633z"/>
                        </svg></div>
                         </div>
                        </td>` :
                        defultTbody.innerHTML += `<td  class="max-h-8 pl-2" id='response_answer-${id}-${response.response_id}'>
                        <div data-bs-toggle="tooltip"  data-bs-html="true" title="Skipped by ${response.type_skip}"  class="hover:cursor-pointer min-h-[35px] max-h-[35px] overflow-hidden truncate flex justify-center items-center">
                        <div class="flex justify-center items-center"><span class="text-sm xs:text-xs truncate text-center ">${translations.autoskip}</span>

                        <svg class="mx-1 w-6 h-6 text-yellow-500" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="CurrentColor" class="bi bi-skip-forward">
                        <path d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.752l-6.267 3.636c-.52.302-1.233-.043-1.233-.696v-2.94l-6.267 3.636C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696L7.5 7.248v-2.94c0-.653.713-.998 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5zM1 4.633v6.734L6.804 8 1 4.633zm7.5 0v6.734L14.304 8 8.5 4.633z"/>
                        </svg></div>
                    </div>
                        </td>
                        `



                    totalSkipped += 1;

                } else if (response.answer_details == null && response.type_skip == null) {
                    defultTbody.innerHTML += `<td  class="max-h-8 pl-2" id='response_answer-${id}-${response.response_id}'>
                        <div data-bs-toggle="tooltip"  data-bs-html="true" title="No answer"  class="hover:cursor-pointer min-h-[35px] max-h-[35px] overflow-hidden truncate flex justify-center items-center">
                            <div class="flex justify-center items-center"><span class="text-sm xs:text-xs truncate text-center ">${translations.noanswer}</span>
                                <svg class="mx-1 w-6 h-6 text-primary_red" fill="currentColor"  viewBox="0 0 24 24" id="exclamation"
                                xmlns="http://www.w3.org/2000/svg" class="icon line"><path id="primary"
                                d="M13,13H11a1,1,0,0,1-1-1V4a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1v8A1,1,0,0,1,13,13Zm1,6a2,2,0,1,0-2,2A2,2,0,0,0,14,19Z"
                                style="fill: none; stroke:currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 1.5;"></path></svg>
                            </div>
                        </div>
                        </td>`;
                }

                // 2 response view
                defultTbody.innerHTML += `<td  class=" max-h-8 pl-2  " id='buttons-${id}-${response.response_id}'>
                        <div class="grid justify-center items-center ml-2 mr-2">
                            <a onclick="showResponse(${response.response_id})"   data-toggle="modal" data-target="#show-response-question" class=" ">
                                <svg class="text-svg_primary hover:text-secondary_blue hover:cursor-pointer h-6 w-6  xs:w-3 xs:h-3 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                                <g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="1" stroke="currentColor" stroke-width="2"/> <path d="M18.2265 11.3805C18.3552 11.634 18.4195 11.7607 18.4195 12C18.4195 12.2393 18.3552 12.366 18.2265 12.6195C17.6001 13.8533 15.812 16.5 12 16.5C8.18799 16.5 6.39992 13.8533 5.77348 12.6195C5.64481 12.366 5.58048 12.2393 5.58048 12C5.58048 11.7607 5.64481 11.634 5.77348 11.3805C6.39992 10.1467 8.18799 7.5 12 7.5C15.812 7.5 17.6001 10.1467 18.2265 11.3805Z" stroke="currentColor" stroke-width="2"/> <path d="M17 4H17.2C18.9913 4 19.887 4 20.4435 4.5565C21 5.11299 21 6.00866 21 7.8V8M17 20H17.2C18.9913 20 19.887 20 20.4435 19.4435C21 18.887 21 17.9913 21 16.2V16M7 4H6.8C5.00866 4 4.11299 4 3.5565 4.5565C3 5.11299 3 6.00866 3 7.8V8M7 20H6.8C5.00866 20 4.11299 20 3.5565 19.4435C3 18.887 3 17.9913 3 16.2V16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/> </g>

                                </svg>
                            </a>
                            <h1 data-bs-toggle="tooltip"  data-bs-html="true" title="View" class="text-xs w-8 whitespace-nowrap overflow-hidden">View</h1>
                        </div>
                        </td>`;
            }
        });

        document.getElementById(`total-answers-${id}`).innerText = totalAnswers;
        document.getElementById(`total-skipped-${id}`).innerText = totalSkipped;

        age_section = document.getElementById(`age-${id}`);
        age_section.innerHTML = `${calcDate(new Date(),new Date(formatDate(created_at)))}`;
        // secondInfoTable=document.getElementById(`section-info-${id}`);
        // secondInfoTable.innerHTML=``;
        // secondInfoTable.innerHTML+=`<h1 class="text-sm xs:text-xs md:text-sm">Type:
        //     <span id="age-${ id }" class="text-secondary_blue">${type_text}</span></h1>`;
        // secondInfoTable.innerHTML+=`<h1 class="text-sm xs:text-xs md:text-sm">Age:
        //     <span id="age-${ id }" class="text-secondary_blue">${calcDate(new Date(),new Date(formatDate(created_at)))}</span></h1>`;

        // add event listener of input search for each question
        document.getElementById(`search_textquestion-${id}`).addEventListener('input', searching_TextQuestion);
        $(`.answer_table-${id}`).fancyTable({
            sortColumn: 0
            , sortable: true
            , searchable: false
            , sortOrder: 'descending'
            , globalSearch: false
        });
    }

    //  to set answers of question in answers section with it ratio of 100
    function setQuestionAnswer(question, data) {


        var satisfactionRating = JSON.parse(JSON.stringify(satisfactionRates));

        var type_Rating = null;
        // secondInfoTable=document.getElementById(`section-info-${question.id}`);
        answers_section = document.getElementById(`answers-${question.id}`);
        // secondInfoTable.innerHTML=``;
        answers_section.innerHTML = ``;
        // detect if question is satisfaction or rating to detect type of satisfaction level..question.type=="custom_satisfaction"||question.type=="custom_rating"
        if (question.type == "satisfaction" || question.type == "rating" || question.type == "satisfaction_image" || question.type == "rating_image") {

            type_Rating = question.type == "rating" || question.type == "rating_image" ? "Rating" : "Satisfaction";
            document.getElementById(`Satisfaction-${question.id}`).innerHTML = `
                <div><h1 class="text-sm xs:text-xs md:text-sm text-black mr-1">${type_Rating}{{ __(' Level: ') }}</h1></div>
                <div id="rating-${ question.id }" ></div>`;
        }



        var totalAnswers = 0;
        var totalSkipped = 0;
        var totalRating = 0;
        var max = 0;

        data.question_data.forEach(function(answer, i) {

            answer.answer_sum = answer.counts.reduce((partialSum, a) => partialSum + a, 0);
            totalAnswers += answer.answer_sum;
            totalSkipped = answer.answer_skipped;
            answer.answer_sum > max ? max = answer.answer_sum : "";



            type_Rating == "Rating" ? totalRating += (answer.answer_details - 1) * answer.answer_sum : totalRating += 0;
            type_Rating == "Satisfaction" ? totalRating += satisfactionRating[answer.answer_details] * answer.answer_sum : totalRating += 0;


        });

        age_section = document.getElementById(`age-${question.id}`);
        age_section.innerHTML = `${calcDate(new Date(),new Date(formatDate(question.created_at)))}`;
        // secondInfoTable.innerHTML+=`<h1 class="text-sm xs:text-xs md:text-sm">Type:            //  secondInfoTable.innerHTML+=`<h1 class="text-sm xs:text-xs md:text-sm">Age:
        //     <span id="age-${ question.id }" class="text-secondary_blue">${calcDate(new Date(),new Date(formatDate(question.created_at)))}</span></h1>`;
        //    if sastisfaction question => show satisfaction level of % ||question.type=="custom_satisfaction"

        question.type == "satisfaction" || question.type == "satisfaction_image" ?
            document.getElementById(`rating-${question.id}`).innerHTML = `<x-progress-bar  id="satisfaction-${question.id}"  value="${(((totalRating/totalAnswers)*100)/(4)).toFixed(1)}" class="bg-valid" />` : ``;
        //    if sastisfaction question => show satisfaction level of 5..||question.type=="custom_rating"
        question.type == "rating" || question.type == "rating_image" ?
            document.getElementById(`rating-${question.id}`).innerHTML = `<x-progress-bar id="satisfaction-${question.id}" value="${(((totalRating/totalAnswers)*100)/(4)).toFixed(1)}" class="bg-valid" />` : ``;
        document.getElementById(`total-answers-${question.id}`).innerText = question.answeredcount;
        document.getElementById(`total-skipped-${question.id}`).innerText = totalSkipped;
        // color section
        //    <div class="font-bold  col-span-1 h-full w-1/3  text-center  p-1 rounded-[0.5rem] border-[1px] " style="background-color:${colorArray[i]}"></div>

        data.question_data.forEach(function(answer, i) {

            answer.ratio = answer.answer_sum == 0 ? 0 : ((100 * answer.answer_sum) / totalAnswers).toFixed(1);
            MostChoosen = answer.answer_sum == max && max > 0 ?
                `<div class="text-xs flex justify-center items-center font-bold  col-span-1  text-center  p-1 text-valid">
                                <span data-bs-toggle="tooltip"  data-bs-html="true" title="${translations.mostchoosen }">${mostchoosen}</span>
                    </div>` : ``;

            answers_section.innerHTML += `
                        <li class="transition  delay-100 text-sm xs:text-xs  hover:-translate-y-1 hover:scale-80 hover:bg-blue-100 duration-100
                         p-[2px] mt-1 grid grid-cols-10 gap-1" id="answer-${question.id}-${answer.answer_id}">

                             <div data-bs-toggle="tooltip"  data-bs-html="true" title="${answer.answer_details}"
                             class="hover:cusror-pointer whitespace-nowrap overflow-hidden col-span-6  p-1 rounded-[0.5rem] border-[1px] border-gray-300"  >
                                <span><span style="color:${colorArray[i]}">${Chars[i]}</span>.&nbsp;${answer.answer_details}</span>
                            </div>

                            <div  class="font-bold  col-span-2  p-[1px] rounded-[0.5rem] text-center  rounded-[0.5rem] border-[1px] border-gray-300" >
                                <div style="width:${answer.ratio}%" class="${answer.ratio==0?'bg-transparent':'bg-customprogressbar'} rounded-[0.5rem] h-full p-1">
                                    <span>${answer.ratio}%</span>
                                </div>
                            </div>

                            <div data-bs-toggle="tooltip"  data-bs-html="true" title="${answer.answer_sum}" class="font-bold  col-span-1 text-center  p-1 rounded-[0.5rem] border-[1px] border-gray-300  overflow-hidden" >
                                <span>${answer.answer_sum}</span>
                            </div>



                            ${MostChoosen}



                        </li>
                        `;

        });

    }
    // initial data for each question
    function initialQuestionData(question) {

        var data = {
            question_data: []
        };
        question.answeredcount = 0;

        question.answers.forEach(answer => {
            answer_data = {
                "answer_id": answer.id
                , "question_id": question.id
                , "answer_details": answer.answer_details
                , "counts": new Array(allDates.length).fill(0)
                , "answer_sum": 0
                , "answer_skipped": 0,

                "dates": allDates
            };
            data.question_data.push(answer_data);

        });
        var Answered = false;

        const TotalAnswerPerResponse = new Map();
        // if(question.type=="satisfaction"||question.type=="rating"||question.type=="satisfaction_image"||question.type=="rating_image")

        allDates.forEach(function(date, i) {

            question.data.forEach(response => {

                if (!TotalAnswerPerResponse.has(response.response_id))
                    TotalAnswerPerResponse.set(response.response_id, 0);


                if (date == formatDate(response.reviewed_at)) {
                    data.question_data.forEach(function(answer, j) {

                        if (response.answer_id != null && response.answer_id == answer.answer_id) {
                            data.question_data[j].counts[i] += 1;


                            TotalAnswerPerResponse.set(response.response_id, TotalAnswerPerResponse.get(response.response_id) + 1)



                        } else if (response.answer_id == null && response.type_skip == "user") {
                            data.question_data[j].answer_skipped += 1;

                        }
                    });
                    //    if answer on this question al least one time then add 1 to total answers on this question


                }

            });

        });
        // calculate how many times answer on this question
        TotalAnswerPerResponse.forEach((value, key) => {
            value > 0 ? question.answeredcount += 1 : "";
        });

        return data;
    }
    // on change date of question
    function changeDate(id) {

        startdate = document.getElementById(`startdate-${id}`).value;
        enddate = document.getElementById(`enddate-${id}`).value;




        allDates = getDaysArray(startdate, enddate);
        allDates = convertalldates(allDates);

        allDates.length < 31 ? typeofdate = "day" : (allDates.length > 31 && allDates.length < 366 ? typeofdate = "month" : typeofdate = "year");
        dates = allDates;
        if (QestionData.question_type == "short_text_question" || QestionData.question_type == "long_text_question" || QestionData.question_type == "date_question" ||
            QestionData.question_type == "email" || QestionData.question_type == "number" || QestionData.question_type == "drawing") {
            initialQuestionTextType(QestionData.data, QestionData.id, QestionData.created_at, allDates, QestionData.question_type, QestionData.type_text);
        } else {

            data = initialQuestionData(QestionData);
            setQuestionAnswer(QestionData, data);
            // document.getElementById(`pie-${question.id}`).remove();
            // document.getElementById(`line-${question.id}`).remove();
            drawQuestionCharts(QestionData, data, dates, typeofdate);

        }
    }

    // show responses
    // function to show each response individal
    function showResponse(id) {
        Livewire.emit('showResponse', id);
    }
    // convert timestamp to date
    function formatDate(date) {
        var d = new Date(date)
            , month = '' + (d.getMonth() + 1)
            , day = '' + d.getDate()
            , year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }
    // to convert all dates between start and end from timestamp to dd-mm-yyyy
    function convertalldates(dates) {

        dates.forEach(function(date, i) {
            dates[i] = formatDate(date);
        });
        return dates;
    }
    // calculate age of question and set it
    function calcDate(currentDate, birthDate) {
        birthDate = new Date(birthDate);
        currentDate = new Date(currentDate);

        let ageYears = currentDate.getFullYear() - birthDate.getFullYear();
        let ageMonths = currentDate.getMonth() - birthDate.getMonth();
        let ageDays = currentDate.getDate() - birthDate.getDate();

        if (ageMonths < 0 || (ageMonths === 0 && ageDays < 0)) {
            ageYears--;
            ageMonths += 12;
        }

        if (ageDays < 0) {
            const lastMonthDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 0);
            ageDays += lastMonthDate.getDate();
            ageMonths--;
        }
        if (ageYears == 0) {
            if (ageMonths == 0) {
                if (ageDays == 0) {
                    let formattedText = @json(__('main.today'));
                    return formattedText;
                } else {
                    let translatedText = @json(__('main.days', ['days' => ':days']));
                    let formattedText = translatedText.replace(':days', ageDays);
                    return formattedText;
                }



            } else {
                let translatedText = @json(__('main.days_months', ['months' => ':months', 'days' => ':days']));
                let formattedText = translatedText.replace(':months', ageMonths).replace(':days', ageDays);

                return formattedText;
            }


        }

        return ageYears + translations.days + "," + ageMonths + translations.months + "," + ageDays + translations.days;
    }

</script>
@endpush
