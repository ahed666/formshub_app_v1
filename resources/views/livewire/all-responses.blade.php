@push('styles')
    <style>


#loading-animation {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 9999;

  justify-content: center;
  align-items: center;
}

.spinner {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 4px solid #333;
  border-top-color: #fff;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.loading-text {
  margin-top: 10px;
  font-size: 16px;
  color: #333;
}
    </style>
@endpush
<div wire:loading.class="disabled opacity-50  " class="p-4 xs:p-1" >

    @if(count($allresponses)>0)
    <div id="loading-animation" class="hidden">
        <svg class="animate-spin h-10 w-10 mr-1 text-secondary_blue" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
        </svg>
        <span class="text-sm">{{ __('Please Wait...') }}</span>
    </div>
    <div id="FullAllResponsesPage" class="grid ">
        {{-- filtering section --}}
        <div class="flex justify-end items-center mb-1 ">


            {{-- search sections --}}
            {{-- <div class="">

                    <label for="search" class="pointer-events-none  text-blue-500  left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                    leading-[1.6]  transition-all duration-200 ease-out text-sm">Search</label>
                    <div class="relative">

                        <input  id="search" class="block w-[400px] p-1 h-10 pl-10 text-sm text-gray-900 border
                         border-gray-300 rounded-lg bg-gray-50
                         " placeholder="Search ..." required>
                        <button onclick="resetsearch()" type="button" class="text-white absolute right-[2px] bottom-[2px]   focus:ring-0
                        focus:outline-none  font-medium rounded-lg text-sm px-4 py-2
                        ><svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                          </svg></button>
                    </div>

            </div> --}}


          {{-- filtering div --}}
            {{-- <div class="flex ml-4 mr-4 my-2 ">
                <div class="">
                    <button onclick="ResetFiltersAllResponses()" class="p-1 bg-green-200 rounded-lg mt-10 w-20 ml-2 mr-2">Reset</button>
                </div>
                <div >
                    <label for="questions" class="pointer-events-none  text-blue-500  left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                    leading-[1.6]  transition-all duration-200 ease-out text-sm">{{ __('Filtering Questions') }}</label>
                    <select  onchange="setquestion(this.value)"   id="questions_menu_filtering" name="" class="w-44 mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm
                    rounded-lg focus:ring-blue-500 focus:border-blue-500 block     px-2"   required>
                    </select>
                </div>
                <div id="filters_menu">
                </div>
            </div> --}}
            {{-- language dropdown and cout of responses --}}
            <div class="flex top-0 ">
                {{-- <div class="mr-2">
                    <label for="languages" class="pointer-events-none  text-blue-500  left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                    leading-[1.6]  transition-all duration-200 ease-out text-sm">{{ __('Languages') }}</label>
                    <select wire:model="language"     id="languages" name="" class="w-44 mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm
                    rounded-lg focus:ring-blue-500 focus:border-blue-500 block

                             px-2"   required>
                        <option {{ $language=="submited"?"selected":"" }} value="submited" >{{ __('As Submited') }}</option>
                        @foreach ($formlanguages as $langauge )
                    <option  value="{{ $langauge['code'] }}">{{ $langauge['name'] }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="grid gap-1 ml-2">
                    {{-- export Option --}}
                    <div class=" flex justify-center items-center">

                        {{-- <x-jet-button class="" type="button"  onclick="" >
                            {{ __('Export') }}
                        </x-jet-button> --}}

                          <x-jet-button id="dropdownExportOptions" data-dropdown-toggle="dropdown" class="" type="button"   >
                            {{ __('main.exportallresponses') }}<svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                              </svg>
                        </x-jet-button>
                        <!-- Dropdown menu -->
                        <div id="dropdown" class="z-50 left-5 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                            <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdownExportOptions">

                              @foreach ($formlanguages as $lang )
                                <li onclick="checkExport('{{ $lang['code'] }}')" class="hover:cursor-pointer" >
                                    <span class="block px-4 py-2 hover:bg-gray-100 ">{{ __('main.exportin') }}{{ __('main.'.$lang['name']) }}</span>
                                </li>
                              @endforeach

                            </ul>
                        </div>
                    </div>

                    {{-- <div class="flex justify-center items-center">
                        <h1 class="text-xs">{{ __('Total : ') }}</h1>
                        <h1 id="total_table_responses" class=" text-sm text-center mx-[1px]"></h1>
                    </div> --}}
               </div>



            </div>
        </div>

        {{-- table responses section --}}

          <div id="responsestable" class="max-h-[700px] overflow-y-auto scrollbar scrollbar-thumb-secondary_blue scrollbar-track-gray-200  rounded-[0.5rem]  ">
            <table  class="responses_table table-fixed  w-full  rounded-[0.75rem] " >

                <thead class="h-10">
                    <tr class="  border-b-[1px] border-t-[1px] p-1  bg-secondary_blue text-white ">
                        <th data-sortas="datetime" class=" sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center "  >{{ __('main.dateandtime') }}</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >{{ __('main.language') }}</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >{{ __('main.score_table') }}</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >{{ __('main.completionpercent') }}</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >{{ __('main.options') }}</th>
                    </tr>
                </thead>
                <tbody id="todo_table_body" class="bg-white " >
                    @foreach ($allresponses as $response )

                    <tr data-response-id="{{ $response->id }}" ondblclick="dbclickshow({{ $response->id }})"  wire:loading.class=" animate-pulse " class="hover:border-2 hover:border-secondary_blue hover:z-20 hover:shadow h-10 min-h-10 max-h-10 w-full bg-white  p-1 border-b-[1px] border-gray-200">
                                    {{-- \Carbon\Carbon::parse($response->reviewed_at)->format('Y-m-d')  --}}
                        <td data-sortvalue="{{ \Carbon\Carbon::parse($response->reviewed_at)->setTimezone(Auth::user()->timezone)->format('Y-m-d H:i') }}"   class="  max-h-10  pl-2">
                            <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ \Carbon\Carbon::parse($response->reviewed_at)->setTimezone(Auth::user()->timezone)->format('Y-m-d H:i') }}"  class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                                <span class="text-sm xs:text-xs truncate text-center ">{{ \Carbon\Carbon::parse($response->reviewed_at)->setTimezone(Auth::user()->timezone)->format('Y-m-d H:i') }}</span>
                            </div>
                        </td>
                        <td class="  max-h-10  pl-2">
                            <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{$response->lang}}"  class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                                <span class="text-sm xs:text-xs truncate text-left ">{{$main_languages[$response->response_language]['name']}}</span>
                            </div>
                        </td>
                        <td class=" max-h-10  pl-2">
                            <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{$response->score}}%"  class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">

                                <x-progress-bar :value="$response->score" class="bg-yellow-300" />

                            </div>
                        </td>

                        <td class="  max-h-10  pl-2">
                            <div   class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center ">
                                <x-progress-bar :value="$response->complet_percent" class="bg-valid" />
                            </div>
                        </td>
                        <td class="  max-h-10  pl-2">
                            <div  id='options-{{$response->id}}'    class="hover:cursor-pointer min-h-[40px] max-h-[40px]   flex space-x-2 xs:space-x-1 justify-center items-center">
                              @if($response->todo)
                                <div  class="grid w-10 xs:w-6">
                                    <a onclick="removetodoConfirmation({{ $response->id }})"   class="  flex justify-center items-center">

                                        <svg class="w-6 h-6 xs:w-3 xs:h-3 text-secondary_red hover:text-primary_red hover:cursor-pointer"  viewBox="-4 -4 28.00 28.00" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                        <g id="SVGRepo_iconCarrier"> <title>time / 31 - time, calendar, remove, date, event, planner, task icon</title> <g id="Free-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"> <g transform="translate(-599.000000, -748.000000)" id="Group" stroke="currentColor" stroke-width="2"> <g transform="translate(597.000000, 746.000000)" id="Shape"> <line x1="17" y1="3" x2="17" y2="5"> </line> <line x1="7" y1="3" x2="7" y2="5"> </line> <path d="M21,15 L15,21 M21,21 L15,15"> </path> <path d="M9.03064542,21 C8.42550126,21 6.51778501,21 5.30749668,21 C4.50512981,21 4.2141722,20.9218311 3.92083887,20.7750461 C3.62750553,20.6282612 3.39729582,20.4128603 3.24041943,20.1383964 C3.08354305,19.8639324 3,19.5916914 3,18.8409388 L3,7.15906122 C3,6.4083086 3.08354305,6.13606756 3.24041943,5.86160362 C3.39729582,5.58713968 3.62750553,5.37173878 3.92083887,5.22495386 C4.2141722,5.07816894 4.50512981,5 5.30749668,5 L18.6925033,5 C19.4948702,5 19.7858278,5.07816894 20.0791611,5.22495386 C20.3724945,5.37173878 20.6027042,5.58713968 20.7595806,5.86160362 C20.9164569,6.13606756 21,8.24671889 21,8.99747152"> </path> </g> </g> </g> </g>
                                        </svg>
                                    </a>
                                    <h1 data-bs-toggle="tooltip"  data-bs-html="true" title="Remove from Do list" class=" text-xs xs:text-[0.4rem] w-10 xs:w-6  text-center whitespace-nowrap overflow-hidden">Remove</h1>
                                </div>
                              @else
                                <div  class="grid  w-10 xs:w-6">
                                    <a onclick="addtodo({{$response->id}})"    data-toggle="modal" data-target="#todo-response" class="  flex justify-center items-center">

                                        <svg class="text-svg_primary hover:text-secondary_blue hover:cursor-pointer h-6 w-6   xs:w-3 xs:h-3" viewBox="-4 -4 28.00 28.00" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                        <g id="SVGRepo_iconCarrier"> <title>time / 30 - time, calendar, add, date, event, planner, shedule, task icon</title> <g id="Free-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"> <g transform="translate(-525.000000, -748.000000)" id="Group" stroke="currentColor" stroke-width="2"> <g transform="translate(523.000000, 746.000000)" id="Shape"> <line x1="17" y1="3" x2="17" y2="5"> </line> <line x1="7" y1="3" x2="7" y2="5"> </line> <path d="M17,13 L17,21 M21,17 L13,17"> </path> <path d="M8.03064542,21 C7.42550126,21 6.51778501,21 5.30749668,21 C4.50512981,21 4.2141722,20.9218311 3.92083887,20.7750461 C3.62750553,20.6282612 3.39729582,20.4128603 3.24041943,20.1383964 C3.08354305,19.8639324 3,19.5916914 3,18.8409388 L3,7.15906122 C3,6.4083086 3.08354305,6.13606756 3.24041943,5.86160362 C3.39729582,5.58713968 3.62750553,5.37173878 3.92083887,5.22495386 C4.2141722,5.07816894 4.50512981,5 5.30749668,5 L18.6925033,5 C19.4948702,5 19.7858278,5.07816894 20.0791611,5.22495386 C20.3724945,5.37173878 20.6027042,5.58713968 20.7595806,5.86160362 C20.9164569,6.13606756 21,7.24671889 21,7.99747152"> </path> </g> </g> </g> </g>
                                        </svg>
                                    </a>
                                    <h1 data-bs-toggle="tooltip"  data-bs-html="true" title="Add to Do list" class="text-xs xs:text-[0.4rem] w-10 xs:w-6  text-center whitespace-nowrap overflow-hidden">To Do</h1>
                                </div>
                              @endif
                              <div id="button-show-{{$response->id}}" class="grid  ml-1 mr-1 w-10 xs:w-6">
                                <a onclick="showResponse({{ $response->id }})"   data-toggle="modal" data-target="#show-response" class=" flex justify-center items-center ">
                                    <svg class="text-svg_primary hover:text-secondary_blue hover:cursor-pointer h-6 w-6  xs:w-3 xs:h-3 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

                                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                                        <g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="1" stroke="currentColor" stroke-width="2"/> <path d="M18.2265 11.3805C18.3552 11.634 18.4195 11.7607 18.4195 12C18.4195 12.2393 18.3552 12.366 18.2265 12.6195C17.6001 13.8533 15.812 16.5 12 16.5C8.18799 16.5 6.39992 13.8533 5.77348 12.6195C5.64481 12.366 5.58048 12.2393 5.58048 12C5.58048 11.7607 5.64481 11.634 5.77348 11.3805C6.39992 10.1467 8.18799 7.5 12 7.5C15.812 7.5 17.6001 10.1467 18.2265 11.3805Z" stroke="currentColor" stroke-width="2"/> <path d="M17 4H17.2C18.9913 4 19.887 4 20.4435 4.5565C21 5.11299 21 6.00866 21 7.8V8M17 20H17.2C18.9913 20 19.887 20 20.4435 19.4435C21 18.887 21 17.9913 21 16.2V16M7 4H6.8C5.00866 4 4.11299 4 3.5565 4.5565C3 5.11299 3 6.00866 3 7.8V8M7 20H6.8C5.00866 20 4.11299 20 3.5565 19.4435C3 18.887 3 17.9913 3 16.2V16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/> </g>
                                    </svg>
                                </a>
                                <h1 data-bs-toggle="tooltip"  data-bs-html="true" title="View" class="text-xs xs:text-[0.4rem] w-10 xs:w-6  text-center whitespace-nowrap overflow-hidden">View</h1>
                            </div>
                            </div>
                        </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
    </div>
    {{-- show in popup list modal --}}
    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="show-response" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="show-response-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[1000px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">
        @livewire('show-response')
        </div>
        </div>
    </div>
    @else
      <x-nothaveresponses />

    @endif
    {{-- add to pop up--}}
    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="todo-response" tabindex="-1" role="dialog" aria-labelledby="todo-response-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[1000px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">

           @livewire('add-todo')
        </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<script src="https://unpkg.com/xlsx-populate/browser/xlsx-populate.min.js"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js') }}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>

{{-- all responses --}}
<script>
function showLoadingAnimation() {

  document.getElementById("loading-animation").classList.remove("hidden");
  document.getElementById("loading-animation").classList.add("flex");

}

function hideLoadingAnimation() {

    document.getElementById("loading-animation").classList.remove("flex");
  document.getElementById("loading-animation").classList.add("hidden");

}

var filtersTextTranslations={
    "ar":{"very satisfied":"راضي تماماٌ",
            "satisfied":"راضي",
            "natural":"محايد",
            "unsatisfied":"غير راضي",
            "very unsatisfied":"غير راضي تماماٌ",
            "like":"اعحبني",
            "dislike":"لم يعجبني",
            "like_dislike":"اعحبني/لم يعجبني",
            "yes":"نعم",
            "no":"لا",
            "yes_no":"تعم/لا",
            "agree":"أوافق",
            "disagree":"لا أوافق",
            "agree_disagree":"أوافق/لا أوافق"


        },
            "en":{"very satisfied":"Very Satisfied","satisfied":"Satisfied",
            "natural":"Natural","unsatisfied":"Unsatisfied","very unsatisfied":"Very Unsatisfied",
            "like":"Like",
            "dislike":"Dislike",
            "like_dislike":"Like/Dislike",
            "yes":"Yes",
            "no":"No",
            "yes_no":"Yes/No",
            "agree":"Agree",
            "disagree":"Disagree",
            "agree_disagree":"Agree/Disagree"
         },
            "ur":{"very satisfied":"مکمل طور پر مطمئن",
                "satisfied":"مطمئن",
                "natural":"غیر جانبدار",
                "unsatisfied":"غیر مطمئن",
                "very unsatisfied":"مکمل طور پر غیر مطمئن",
                "like":"پسند",
                "dislike":"ناپسندیدگی",
                "like_dislike":"پسند/ناپسندیدگی",
                "yes":"جی ہاں",
                "no":"نہیں",
                "yes_no":"نہیں/جی ہاں",
                "agree":"متفق",
                "disagree":"متفق نہیں",
                "agree_disagree":"متفق/نہیںمتفق"
            },
            "tl":{"very satisfied":"Ganap na Nasiyahan","satisfied":"Nasiyahan","natural":"Natural",
            "unsatisfied":"Hindi Nasisiyahan","very unsatisfied":"Ganap na Hindi Nasisiyahan",
            "like":"Gaya",
            "dislike":"Ayaw",
            "like_dislike":"Ayaw/Gaya",
            "yes":"Oo",
            "no":"Hindi",
            "yes_no":"Oo/Hindi",
            "agree":"Sumang-ayon",
            "disagree":"Hindi Sumasang-ayon",
            "agree_disagree":"Hindi Sumasang-ayon/Sumang-ayon"
            }
};

var filtersTranslations={

            "no":["No","لا","Hindi","نہیں"],
            "yes":["Yes","نعم","Oo","جی ہاں"],
            "like":["Like","اعحبني","Gaya ng","پسند"],
            "dislike":["Dislike","لم يعجبني","Ayaw","ناپسندیدگی"],
            "agree":["Agree","أوافق","Sumang-ayon","متفق"],
            "disagree":["Disagree","لا أوافق","Hindi Sumasang-ayon","متفق نہیں"],
            "very satisfied":["Very Satisfied","راضي تماماٌ","Ganap na Nasiyahan","مکمل طور پر مطمئن"],
            "satisfied":["Satisfied","راضي","Nasiyahan","مطمئن"],
            "natural":["Natural","محايد","Natural","غیر جانبدار"],
            "unsatisfied":["Unsatisfied","غير راضي","غیر مطمئن","Hindi Nasisiyahan"],
            "very unsatisfied":["Very Unsatisfied","غير راضي تماماٌ","مکمل طور پر غیر مطمئن","Ganap na Hindi Nasisiyahan"],
            "rating_1":["1","1","1","1"],
            "rating_2":["2","2","2","2"],
            "rating_3":["3","3","3","3"],
            "rating_4":["4","4","4","4"],
            "rating_5":["5","5","5","5"]


        };
    var responseColumnsTranslations={
       "en":{"responseid":"Id","responsescore":"Score","responselanguage":"Language","responsedate":"Date","answer":"Answer"},
       "ar":{"responseid":"الرقم","responsescore":"النتيجة","responselanguage":"اللغة","responsedate":"تاريخ التقديم","answer":"الأجابة"},
       "tl":{"responseid":"Id","responsescore":"Puntos","responselanguage":"wika","responsedate":"Petsa","answer":"Sagot"},
       "ur":{"responseid":"آئی ڈی","responsescore":"سکور","responselanguage":"زبان","responsedate":"تاریخ","answer":"جواب"}

    };
    var responses;
    var responsesFiltered;
    var formquestions;
    var formlanguages;
    var language;
    var questions;
    var defultTbody;
    var responseIndex;
    var totalCanceled=0;
    var questionFilterId;
    var  forminfo;
    var search;
    var Total;
    var BasicTable;
    var BasicTotal;
    var fileURL;
    var AllowExport;


    window.addEventListener('close_modal_add_todo', event => {

        // $('#todo-response').modal('hide').data('bs.modal', null);
        //     // $('.modal').remove();
        // $('.modal-backdrop').remove();
        // window.location.reload();

        window.location.reload();


    });

    // after edit data //add todo -- remove todo
    window.addEventListener('refreshdata', event => {

        responses=@this.allresponses;
        fileURL=@this.path;
        formquestions=@this.formquestions;
        AllowExport=@this.allowexport;

        @this.language=="submited"?language="en":language=@this.language;
        responsesFiltered=responses;
        if(responses.length>0){
            buildResponsesTable(responses);

            // initialfiltering(responses,formquestions);

            $(".responses_table").fancyTable({
			sortColumn:0,
            sortable:true,
            searchable:false,
            sortOrder: 'descending',
			globalSearch:false
		});
            initialEventSearch();
        }


    });
   // refresh all after click on refresh button
    window.addEventListener('refreshall', event => {
        console.log('ref');
        $(".responses_table").fancyTable({
			sortColumn:0,
            sortable:true,
            searchable:false,
            sortOrder: 'descending',
			globalSearch:false
		});



    });
    window.addEventListener('DOMContentLoaded', event => {

             $(".responses_table").fancyTable({
			sortColumn:0,
            sortable:true,
            searchable:false,
            sortOrder: 'descending',
			globalSearch:false
		});

    });
    function checkExport(lang){
        showLoadingAnimation();
        if(@this.allowexport){
            Livewire.emit('getexportdata',lang);
        }
        else{
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href="">Why do I have this issue?</a>'
                })
            }
    }
    window.addEventListener('fetchingdata', event => {
        $(".responses_table").fancyTable({
			sortColumn:0,
            sortable:true,
            searchable:false,
            sortOrder: 'descending',
			globalSearch:false
		});

        ExportToExcel(event.detail.responses,event.detail.questions,event.detail.form,event.detail.score,event.detail.language,event.detail.languageName);



    });
    async function ExportToExcel(responses,formquestions,forminfo,score,language,languageName){
            console.log(responses);


        var responsecolumntrans= JSON.parse(JSON.stringify(responseColumnsTranslations));
        //1)get the file by path 2)convert the response to buffer 3)convert buffer to workbook 4)fill data in workbook
        fetch('/resources/All Responses Form.xlsx')
        .then(response => response.arrayBuffer())
        .then(buffer => {
        const workbook = XlsxPopulate.fromDataAsync(buffer);

        return workbook.then(workbook => {
            const sheet = workbook.sheet(0);

            // Add data to specific cells
            // fill first 4 column (id of response,date ,score and language)
            // sheet.cell('A6').value(responsecolumntrans[language]['responseid']);
            sheet.cell('B6').value(responsecolumntrans[language]['responsedate']);
            sheet.cell('C6').value(responsecolumntrans[language]['responsescore']);
            sheet.cell('D6').value(responsecolumntrans[language]['responselanguage']);
            sheet.cell('D4').value(forminfo.form_name);

            formquestions.forEach(function(question,i) {
                sheet.row(6).cell(i + 5).value(question.question_details);
            });
            var row=0;

            responses.forEach( function(response,i){
            if(response.questions.length>0){
                formquestions.forEach(function(question,j) {
                const cell= sheet.row(row+7).cell(j + 5);
                var cellId=response.id+'-'+question.id;
                cell._cellId = cellId;

            });
            row+=1;
            }

            });
            sheet.cell('I4').value(responses.length);
            sheet.cell('K4').value(score);

            const usedRange = sheet.usedRange();

            var RowNumber=0;
            responses.forEach( function(response,i){
                if(response.questions.length>0)
                {
                    sheet.row(RowNumber+7).cell(2).value(response.reviewed_at);
                    sheet.row(RowNumber+7).cell(3).value(response.score);
                    sheet.row(RowNumber+7).cell(4).value(response.lang);
                    for (let index = 0; index < response.questions.length; index++) {


                        cellId=response.id+'-'+response.questions[index].question_id;
                        usedRange.forEach(cell => {
                        // Check if the cell has the desired ID
                        if (cell._cellId === cellId) {

                            if(response.questions[index].answer!=null)
                                {

                                const oldValue=cell.value();
                                const newValue= response.questions[index].question_type=="drawing"?"Signed":response.questions[index].answer;
                                oldValue==null?value=newValue:value=oldValue+','+newValue;

                                cell.value(value);}
                            else{
                                if(response.questions[index].type_skip==null)
                                cell.value('No answer');
                                else
                                response.questions[index].type_skip=="user"?cell.value('Skipped By:'+response.questions[index].type_skip):cell.value('Auto Skipped');
                            }

                        }
                        });

                        // Find the cell with the matching ID within the range
                        // sheet.row(i+7).cell(index+5).value(response.questions[index].answer);


                    }
                RowNumber+=1;
                }

            });
            // Add more cells as needed

            // Save the modified workbook

            return workbook.outputAsync();

        });
        })
        // add some of setting to download
        .then(fileData => {
        const blob = new Blob([fileData], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        const currentDate = new Date();
        $currentDate=currentDate.getFullYear()+'-'+(currentDate.getMonth()+1)+'-'+currentDate.getDate();
        a.download = forminfo.form_title+'_All Responses_'+$currentDate+'_'+languageName+'.xlsx'; // Set the desired name for the downloaded file
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        });
        hideLoadingAnimation();

    }


    // export as excel


    // to create responses table dependent on responses


    function addtodo(id,todo){

        if(todo)
        {removetodoConfirmation(id);console.log('remove');}
        else
        {Livewire.emit('add_todo',id);console.log('add');}
    }
    // function to show each response individal
    function showResponse(id){
        Livewire.emit('showResponse',id);
    }
    // to confirm remove todo
    function removetodoConfirmation(id)  {

        (async () => {

        const { value: accept } = await Swal.fire({
            text: "remove todo will wipe all data that belong to it, this action cannot be undone!!",
        input: 'checkbox',
        inputValue: 0,
        icon:'question',
        confirmButtonColor: '#dc2626',
        showCancelButton: true,
        cancelButtonColor:'#f3f4f6',
        cancelButtonText:"<h5 style='color:000000;border:0;box-shadow: none;'>Cancel</h5>",
        inputPlaceholder:
        'Are you sure you want to delete it',
         confirmButtonText:
            'Delete ',
        inputValidator: (result) => {
            return !result && 'Checkbox is required'
        }
        })

        if (accept) {
            Livewire.emit('removeTodoConfirmed',id);
        }

        })()
    }

    function dbclickshow(id){
        $('#show-response').modal('show');
        showResponse(id);
    }
// Wait for the document to be fully loaded before adding event listeners
// document.addEventListener("DOMContentLoaded", function () {
//         // Get all table rows
//         var rows = document.querySelectorAll("#todo_table_body tr");

//         // Add double-click event listeners to each row
//         rows.forEach(function (row) {
//             row.addEventListener("dblclick", function () {
//                 $('#show-response').modal('show');
//                 // Extract the response ID from the row (you may need to adjust this based on your HTML structure)
//                 var responseId = row.getAttribute("data-response-id");

//                 // Call the showResponse function with the response ID
//                 showResponse(responseId);
//             });
//         });
//     });

</script>
@endpush
