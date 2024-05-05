<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('Forms Hub') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/fav_icon/favicon.ico') }}">    <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('styles/index.min.css')}}" />
        <link href="{{ asset('https://fonts.googleapis.com/icon?family=Material+Icons')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css')}}">
        <link rel="stylesheet" href="{{ asset('https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap')}}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

        {{-- <link
            rel="stylesheet"
            href="{{ asset('https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css')}}" /> --}}

        <link rel="stylesheet" type="text/css" href="{{ asset('styles/owl.carousel.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('styles/owl.theme.default.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('styles/loading.css')}}">
        <style>
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .text-red{
                color:bisque;
            }

    * {
        -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
        color-adjust: exact !important;  /*Firefox*/
    }
        </style>
        @stack('styles')
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body>
        <div wire:loading.class="disabled opacity-50  " id="show-response-body" class=" grid justify-center items-center rounded-[0.5rem] ">
            <div class="flex justify-center items-center w-full" id="formLogo">  </div>
            <div  class="flex justify-start items-center my-4 p-2">{{ __('main.formtitle_editform') }}<span  class="ml-1 font-bold" id="formTitle"></span></div>
            <div class="grid grid-cols-12 justify-center items-center bg-white rounded-[0.5rem] p-2">
                <div class="col-span-12 grid grid-cols-12">
                    {{-- score --}}
                    <div  class="flex justify-start items-center  col-span-6 ">
                        <div class="flex justify-center items-center mr-1"><span class="text-sm">{{ __('main.score') }}</span></div>
                        <div id="progressBar_score" class="flex justify-center items-center font-bold" ></div>
                    </div>
                    {{-- reviewed at  --}}
                    <div  class="flex justify-start items-center col-span-6 ">
                        <div class="flex justify-center items-center mr-1"><span class="text-sm">{{ __('main.submitiondateandtime') }}</span></div>
                        <div id="response_date" class="flex justify-center items-center font-bold"></div>
                    </div>
                    {{-- completion --}}
                    <div  class="flex justify-start items-center col-span-6 ">
                        <div class="flex justify-center items-center mr-1"><span class="text-sm">{{ __('main.completionpercent_todo') }}</span></div>
                        <div id="progressBar_completion" class="flex justify-center items-center font-bold"></div>
                    </div>

                    {{-- Language --}}
                    <div  class="flex justify-start items-center col-span-6 ">
                        <div class="flex justify-center items-center mr-1"><span class="text-sm">{{ __('main.submitionlanguage') }}</span></div>
                        <div id="response_langauge" class="flex justify-center items-center font-bold"></div>
                    </div>
                </div>

            </div>
            <div class="overflow-y-auto rounded-[0.5rem] ">
                <table class="w-full">
                    <thead class="" >
                        <tr id="showresponse-tablehead" class=" border-b-[1px] border-t-[1px] p-1   ">
                            <th  data-bs-toggle="tooltip"  data-bs-html="true" title=""   class="text-center left-0 top-0 sticky z-50
                            hover:cursor-pointer h-12 ml-1 mr-1 xs:text-xs border-[1px]   border-gray-200   p-2 bg-secondary_blue print:bg-secondary_blue    text-white" style="max-width:50%"
                            >{{ __('main.question') }}</th>
                            <th  data-bs-toggle="tooltip"  data-bs-html="true" title=""    class="text-center left-0 top-0 sticky z-50
                            hover:cursor-pointer h-12 ml-1 mr-1 xs:text-xs border-[1px]   border-gray-200  bg-secondary_blue  p-2  text-white"
                            >{{ __('main.answer') }}</th>

                        </tr>
                    </thead>
                        <tbody id="showresponse-tablebody" class="bg-white " >




                        </tbody>
                </table>
            </div>
        </div>

    <script>
         var translations = @json(__('main'));
         var langauges= {
        "ar": {
            "lang": "العربية"

        }
        , "en": {
            "lang": "English"

        }
        , "ur": {
            "lang": "Urdu"

        }
        , "tl": {
            "lang": "Tagalog"

        }
    }
        function getLanguageName(code) {
        return languages[code].lang;
    }
        var response = {!! json_encode($response, JSON_HEX_TAG) !!};
        var form = {!! json_encode($form, JSON_HEX_TAG) !!};

        var questions = {!! json_encode($questions->toArray(), JSON_HEX_TAG) !!};

        var lang = {!! json_encode($lang, JSON_HEX_TAG) !!};
        InitialResponseTable(response,lang);
            function InitialResponseTable(response,lang){
                console.log(form);
                const [datePart, timePart] = response.reviewed_at.split(' ');
                const formTitle = document.getElementById('formTitle');
                const formLogo=document.getElementById('formLogo');
                const progressBarScore = document.getElementById('progressBar_score');
                const progressBarCompletion = document.getElementById('progressBar_completion');
                const responseDate = document.getElementById('response_date');

                const responselangauge = document.getElementById('response_langauge');
                progressBarScore.innerHTML=`<x-progress-bar  id="score-${response.id}" value="${response.score}" class="bg-yellow-300" />`;
                progressBarCompletion.innerHTML=`<x-progress-bar  id="completpercent-${response.id}"  value="${response.complet_percent}" class="bg-valid" />`;
                responseDate.innerHTML=`<span class="text-sm">${datePart + ' ' + timePart.slice(0, 5)}</span>`;
                responselangauge.innerHTML=`<span class="text-sm">${getLanguageName(lang)}</span>`;
                formTitle.innerText=form.form_title;
                formLogo.innerHTML=`<img class="object-contain max-w-[120px] max-h-[90px] min-h-[90px] min-w-[120px] w-[120px] h-[90px]" src="{{ asset('${form.logo_url}') }}" alt="">`;
                var body =document.getElementById('showresponse-tablebody');
                body.innerHTML="";

            questions.forEach(question => {
                body.innerHTML+=`
                <tr>
                            <td  data-bs-toggle="tooltip"   data-bs-html="true" title="${question.question_details }"  class="text-center
                                z-20    hover:cursor-pointer h-12 ml-1 mr-1 xs:text-xs border-[1px]   border-gray-200
                                p-2 w-1/2 "  >
                                <div class="max-w-[400px] w-[400px] truncate whitespace-normal">${question.question_details }</div>
                                </td>
                                <td    data-bs-toggle="tooltip"   data-bs-html="true" title=""  class="text-center
                                z-20   hover:cursor-pointer h-12 ml-1 mr-1 xs:text-xs border-[1px]   border-gray-200
                                p-2  w-1/2"  >
                                <div id="showresponse-answer-${question.id }" class="max-w-[400px] w-[400px]  "></div>
                                </td>

                </tr>
                `;



            });
             // questions.forEach(question => {
                //         answer=document.getElementById(`showresponse-answer-${question.id}`);
                //         answer.innerHTML="";
                // });
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

                        <svg class="mx-1 w-6 h-6 text-yellow-500" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="CurrentColor" class="bi bi-skip-forward">
                        <path d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.752l-6.267 3.636c-.52.302-1.233-.043-1.233-.696v-2.94l-6.267 3.636C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696L7.5 7.248v-2.94c0-.653.713-.998 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5zM1 4.633v6.734L6.804 8 1 4.633zm7.5 0v6.734L14.304 8 8.5 4.633z"/>
                        </svg></div>`:answer.innerHTML=`<div class="flex justify-center items-center"><span>${translations.autoskip}</span>
                        <svg class="mx-1 w-6 h-6 text-yellow-500" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="CurrentColor" class="bi bi-skip-forward">
                        <path d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.752l-6.267 3.636c-.52.302-1.233-.043-1.233-.696v-2.94l-6.267 3.636C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696L7.5 7.248v-2.94c0-.653.713-.998 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5zM1 4.633v6.734L6.804 8 1 4.633zm7.5 0v6.734L14.304 8 8.5 4.633z"/>
                        </svg></div>`);

                    })
                }
                questions.forEach(question => {

                        var answer=document.getElementById(`showresponse-answer-${question.id}`);

                        if(answer.innerHTML.length==0){
                            answer.innerHTML=`<div class="flex justify-center items-center"><span>${translations.noanswer}</span>

                                <svg class="mx-1 w-6 h-6 text-primary_red" fill="currentColor"  viewBox="0 0 24 24" id="exclamation"
                                xmlns="http://www.w3.org/2000/svg" class="icon line"><path id="primary"
                                d="M13,13H11a1,1,0,0,1-1-1V4a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1v8A1,1,0,0,1,13,13Zm1,6a2,2,0,1,0-2,2A2,2,0,0,0,14,19Z"
                                style="fill: none; stroke:currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 1.5;"></path></svg>
                                </div>`;
                        }
                });
                window.print();

            }
    </script>
    </body>
</html>
