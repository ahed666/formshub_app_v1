<div class="">
   {{-- modal header --}}
    <div class="flex items-start justify-between p-4 border-b rounded-t ">
        <div>
            <h3 class="text-xl xs:text-xs font-semibold text-gray-900 ">
               {{ __('main.responsesdetails') }}
            </h3>
        </div>

        <div>
            {{-- wire:Click="closemodal" --}}
            <button  type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                items-center  close" data-dismiss="modal" aria-label="Close">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
    </div>
    <!-- Modal body -->
    <div wire:loading.class="disabled opacity-50  " id="show-response-body" class=" rounded-[0.5rem] ">
        <div class="grid grid-cols-12 justify-center items-center bg-white rounded-[0.5rem] py-2 px-4">
            <div class="col-span-8 xs:col-span-12 grid grid-cols-12">
                {{-- score --}}
                <div  class="flex justify-start items-center  col-span-6 xs:col-span-12">
                    <div class="flex justify-center items-center mr-1"><span class="text-sm">{{ __('main.score') }}</span></div>
                    <div id="progressBar_score" class="flex justify-center items-center" ></div>
                </div>
                {{-- reviewed at  --}}
                <div  class="flex justify-start items-center col-span-6 xs:col-span-12">
                    <div class="flex justify-center items-center mr-1"><span class="text-sm">{{ __('main.submitiondateandtime') }}</span></div>
                    <div id="response_date" class="flex justify-center items-center"></div>
                </div>
                {{-- completion --}}
                <div  class="flex justify-start items-center col-span-6 xs:col-span-12 ">
                    <div class="flex justify-center items-center mr-1"><span class="text-sm">{{ __('main.completionpercent_todo') }}</span></div>
                    <div id="progressBar_completion" class="flex justify-center items-center"></div>
                </div>

                {{-- Language --}}
                <div  class="flex justify-start items-center col-span-6  xs:col-span-12">
                    <div class="flex justify-center items-center mr-1"><span class="text-sm">{{ __('main.submitionlanguage') }}</span></div>
                    <div id="response_langauge" class="flex justify-center items-center"></div>
                </div>
            </div>
            <div class="col-span-4 xs:col-span-12 flex justify-between">
                <div class="mr-2 grid justify-center items-center ">
                    <label for="languages" class="pointer-events-none    left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                    leading-[1.6]  transition-all duration-200 ease-out text-xs text-black">{{ __('main.displaylanguage') }}</label>
                    <select  onchange="changeLanguage(this.value)"     id="languages" name="" class="w-32  h-6 bg-gray-50 border border-gray-300 text-gray-900 text-xs
                        rounded-lg focus:ring-blue-500 focus:border-blue-500 block    px-1 py-0"   required>



                    </select>
                </div>
                <div class="grid justify-center items-center">
                         <a href="javascript:void(0);" onclick="openNewTabWithRoute()">
                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                            <svg  class="w-8 text-gray-400 hover:text-secondary_blue" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier"> <path d="M7 17H5C3.89543 17 3 16.1046 3 15V11C3 9.34315 4.34315 8 6 8H7M7 17V14H17V17M7 17V18C7 19.1046 7.89543 20 9 20H15C16.1046 20 17 19.1046 17 18V17M17 17H19C20.1046 17 21 16.1046 21 15V11C21 9.34315 19.6569 8 18 8H17M7 8V6C7 4.89543 7.89543 4 9 4H15C16.1046 4 17 4.89543 17 6V8M7 8H17M15 11H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                            </svg>
                         </a>
                         <span class="text-xs text-center">{{ __('main.print') }}</span>
                </div>
            </div>
        </div>
        <div class="overflow-y-auto rounded-[0.5rem] 2xl:max-h-[700px]  min-h-[400px] xs:min-h-[300px] xs:max-h-[400px]">
            <table class="w-full">
                <thead class="" >
                    <tr id="showresponse-tablehead" class=" border-b-[1px] border-t-[1px] p-1  ">
                        <th  data-bs-toggle="tooltip"  data-bs-html="true" title=""   class="text-center left-0 top-0 sticky z-50
                        hover:cursor-pointer h-12 ml-1 mr-1 xs:text-xs border-[1px]   border-gray-200   p-2 bg-secondary_blue  print:bg-secondary_blue text-white" style="max-width:50%"
                        >{{ __('main.question') }}</th>
                        <th  data-bs-toggle="tooltip"  data-bs-html="true" title=""   class="text-center left-0 top-0 sticky z-50
                        hover:cursor-pointer h-12 ml-1 mr-1 xs:text-xs border-[1px]   border-gray-200   p-2 bg-secondary_blue text-white"
                        >{{ __('main.answer') }}</th>

                    </tr>
                </thead>
                    <tbody id="showresponse-tablebody" class="bg-white " >




                    </tbody>
            </table>
        </div>
    </div>
    <div   wire:loading.class.remove="hidden"
        wire:loading.class=" flex justify-center items-center absolute top-1/2 right-[44%] "
        class=" hidden justify-center items-center absolute top-1/2 right-[44%] ">
            <svg class="animate-spin h-10 w-10 mr-1 text-secondary_blue" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
              </svg>

              <span class="text-sm">{{ __('Please Wait...') }}</span>
    </div>
    <!-- Modal footer -->
    <div wire:loading.class="disabled opacity-50  "  id="show-response-buttons" class="flex justify-center items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">

    </div>
</div>
@push('scripts')
<script>
// print



     var translations = @json(__('main'));
    var responses;
    var questions;
    var current_response_id;
    var languages;
    var formlanguages;
    var langView;

    window.addEventListener('show', event => {

        responses=event.detail.all;
        questions=event.detail.questions;
        languages=event.detail.languages;
        formlanguages=event.detail.formlanguages;
        langView=event.detail.langView;
        addformlanguages(formlanguages);
       intialshowresponse(event.detail.response.id,event.detail.response.viewed);


    });
    function changeLanguage(lang){
        console.log(lang);
        Livewire.emit('changelanguage',lang);
    }

    function addformlanguages(formlanguages){
        languages_select=  document.getElementById('languages');
        formlanguages.forEach(language => {
         languages_select.innerHTML+=` <option ${language.code==langView?"selected":""}  value="${ language.code}">${ language.name}</option>`;
       });

    }
    function print(){
        var currentResponse;
        responses.forEach( function(response,i){
        if(current_response_id==response.id)
        currentResponse=response;
        });
        html=document.getElementById('show-response-body').innerHTML;

        Livewire.emit('print',current_response_id,currentResponse,html)
    }
    function intialshowresponse(id,viewed){

        // if(viewed==false)Livewire.emit('changestatus',id);
        // else
        showresponse(id);
    }

    window.addEventListener('changedstatus', event => {

        responses=event.detail.all;
        questions=event.detail.questions;
        languages=event.detail.languages;
        formlanguages=event.detail.formlanguages;

        langView=event.detail.langView;
        addformlanguages(formlanguages);
        intialshowresponse(event.detail.response.id,event.detail.response.viewed);

    });
    window.addEventListener('languagechanged', event => {

        responses=event.detail.all;
        questions=event.detail.questions;
        languages=event.detail.languages;
        formlanguages=event.detail.formlanguages;

        langView=event.detail.langView;
        addformlanguages(formlanguages);
        showresponse(current_response_id);
    });
    const progressBarScore = document.getElementById('progressBar_score');
    const progressBarCompletion = document.getElementById('progressBar_completion');
    const responseDate = document.getElementById('response_date');
    const responselangauge = document.getElementById('response_langauge');
    function showresponse(id){


         current_response_id=id;
        var body =document.getElementById('showresponse-tablebody');
        body.innerHTML="";

       questions.forEach(question => {
        console.log(question);
        body.innerHTML+=`
        <tr>
                       <td  data-bs-toggle="tooltip"   data-bs-html="true" title="${question.question_details }"  class="text-center
                           z-20    hover:cursor-pointer h-12 ml-1 mr-1 xs:text-xs border-[1px]   border-gray-200
                           p-2 w-1/2 "  >
                           <div class="max-w-[600px] w-[600px] xs:w-auto truncate whitespace-normal">${question.question_details }</div>
                        </td>
                        <td    data-bs-toggle="tooltip"   data-bs-html="true" title=""  class="text-center
                          z-20   hover:cursor-pointer h-12 ml-1 mr-1 xs:text-xs border-[1px]   border-gray-200
                           p-2  w-1/2"  >
                           <div id="showresponse-answer-${question.id }" class="max-w-[400px] w-[400px] xs:w-auto truncate whitespace-normal"></div>
                           </td>

        </tr>
        `;

       });


        responsebuttons=document.getElementById('show-response-buttons');
        responsebuttons.innerHTML=``;
       firstId=responses[0].id;
       lastId=responses[responses.length-1].id;
      var prevId;var nextId;
       var disablePrev="";
       var disableNext="";

        responses.forEach( function(response,i){

            if(id==response.id)
            {
                progressBarScore.innerHTML=`<x-progress-bar  id="score-${response.id}" value="${response.score}" class="bg-yellow-300" />`;
                progressBarCompletion.innerHTML=`<x-progress-bar  id="completpercent-${response.id}"  value="${response.complet_percent}" class="bg-valid" />`;
                responseDate.innerHTML=`<span class="text-sm">${response.reviewed_at}</span>`;
                responselangauge.innerHTML=`<span class="text-sm">${languages[response.lang]['name'] }</span>`;
                response.id==firstId?disablePrev="disabled":disablePrev="";
                response.id==lastId?disableNext="disabled":disableNext="";
                response.id==firstId?prevId=response.id:prevId=responses[i-1].id;
                response.id==lastId?nextId=response.id:nextId=responses[i+1].id;
                response.id==firstId?prevViewed=response.viewed:prevViewed=responses[i-1].viewed;
                response.id==lastId?nextViewed=response.viewed:nextViewed=responses[i+1].viewed;

                questions.forEach(question => {
                        answer=document.getElementById(`showresponse-answer-${question.id}`);
                        answer.innerHTML="";
                });
                if(response.questions.length>0)
                {
                    response.questions.forEach(question => {

                    answer=document.getElementById(`showresponse-answer-${question.question_id}`);
                    if(question.question_type=="drawing"){
                        value=`<div class="flex justify-center items-center">
                        <img width="200px" height="100px" src="{{ asset('${question.answer}') }}">
                        </div>`;
                    }
                    else{
                    const oldValue=answer.innerText;
                    const newValue=question.answer;
                    oldValue.length==0?value=newValue:value=oldValue+' , '+newValue;}
                    question.answer!=null?answer.innerHTML=`${value}`:(question.type_skip=="user"?answer.innerHTML=`<div class="flex justify-center items-center"><span>${translations.skipbyuser}</span>
                        <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                        <svg class="mx-1 w-6 h-6 text-yellow-500" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="CurrentColor" class="bi bi-skip-forward">
                        <path d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.752l-6.267 3.636c-.52.302-1.233-.043-1.233-.696v-2.94l-6.267 3.636C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696L7.5 7.248v-2.94c0-.653.713-.998 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5zM1 4.633v6.734L6.804 8 1 4.633zm7.5 0v6.734L14.304 8 8.5 4.633z"/>
                        </svg></div>`:answer.innerHTML=`<div class="flex justify-center items-center"><span>${translations.autoskip}</span>
                        <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                        <svg class="mx-1 w-6 h-6 text-yellow-500" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="CurrentColor" class="bi bi-skip-forward">
                        <path d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.752l-6.267 3.636c-.52.302-1.233-.043-1.233-.696v-2.94l-6.267 3.636C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696L7.5 7.248v-2.94c0-.653.713-.998 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5zM1 4.633v6.734L6.804 8 1 4.633zm7.5 0v6.734L14.304 8 8.5 4.633z"/>
                        </svg></div>`);

                    })
                }
                questions.forEach(question => {
                        var answer=document.getElementById(`showresponse-answer-${question.id}`);

                        if(answer.innerHTML.length==0){
                            answer.innerHTML=`<div class="flex justify-center items-center"><span>${translations.noanswer}</span>
                                <?xml version="1.0" encoding="utf-8"?>
                                <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                <svg class="mx-1 w-6 h-6 text-primary_red" fill="currentColor"  viewBox="0 0 24 24" id="exclamation"
                                xmlns="http://www.w3.org/2000/svg" class="icon line"><path id="primary"
                                d="M13,13H11a1,1,0,0,1-1-1V4a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1v8A1,1,0,0,1,13,13Zm1,6a2,2,0,1,0-2,2A2,2,0,0,0,14,19Z"
                                style="fill: none; stroke:currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 1.5;"></path></svg>
                                </div>`;
                        }
                });
                responsebuttons.innerHTML=`
                <button ${disablePrev} onclick="intialshowresponse(${prevId},${prevViewed})"   type="button"
                class="text-white  disabled:bg-blue-200 font-medium rounded-lg bg-secondary_blue
                text-sm px-5 py-2.5 text-center  ">&#8592; ${translations.prev}</button>
                <button ${disableNext}  onclick="intialshowresponse(${nextId},${nextViewed})"  type="button"  class="text-white  disabled:bg-blue-200 font-medium rounded-lg  bg-secondary_blue
                text-sm px-5 py-2.5 text-center  ">${translations.next} &#8594;</button>`;
            }
        });

    }




    function openNewTabWithRoute() {
        // Define the Laravel route URL
        var id = current_response_id;
        var lang = langView;

    // Define the Laravel route URL
    var routeUrl = "{{ route('printresponse', ['id' => 'placeholder', 'lang' => 'placeholder']) }}";

    // Replace the placeholders with actual data
    routeUrl = routeUrl.replace('placeholder', id);
    routeUrl = routeUrl.replace('placeholder', lang);
        console.log(routeUrl);
        // Open a new tab with the route URL
        window.open(routeUrl, '_blank');
    }
</script>

@endpush
