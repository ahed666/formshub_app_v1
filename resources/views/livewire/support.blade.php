@push('styles')
<link  rel="stylesheet" href="{{ asset('styles/bootstrap.min.css')}}">
@endpush
<div class="mt-2">
    <div class="min-h-[20%] max-h-[20%] border border-gray-200 bg-white mb-1 rounded-[0.5rem] p-4 ">
        <div class="flex  items-center">
            <h1 class="">
                {{ __('main.support_title') }}
            </h1>
        </div>
        <div class="mt-1 flex justify-start items-center">
            <a href="{{ route('knowledgebase') }}"  class="rounded bg-gray-300 p-2 text-secondary_blue hover:text-secondary_1 hover:no-underline focus:outline-none active:outline-none">
                {{ __('main.visit_kb') }}
            </a>
        </div>
        <div class="mt-8">
            <h1 class="font-bold">{{ __('main.support_lookingfor') }}</h1>
        </div>
         <div class="mt-2   container w-full overflow-hidden h-auto">
        <ul class="mt-2    owl_faq owl-carousel owl-theme align-content-center">
            @foreach ($questions as $question )
            <div  class="item relative  w-full">

                <li class=" border border-gray-200 hover:border-secondary_blue p-2  rounded-[0.5rem]">
                    <a href="https://formshub.net/knowledgebase/{{ $question->id }}" class="hover:no-underline hover:border-secondary_blue" target="_blank">
                        <div>
                            {{-- title question --}}
                            <div class="flex justify-center items-center font-bold">
                                @if(App::getLocale()=="en")    {{ $question->question }}
                                @else {{  $question->question_ar }}
                                @endif
                            </div>
                            {{-- text question --}}
                            <div  data-bs-toggle="tooltip"  data-bs-html="true" title="{{!! $question->answer !!}}" class="flex justify-center items-center mt-2 text-sm text-left whitespace-nowrap overflow-hidden">
                                @if(App::getLocale()=="en")

                                @php
                                $text = str_replace('__CONTACT_ROUTE__',route('contact'), $question->answer);
                                $text = str_replace('__PRODUCTS_ROUTE__',route('contact'), $question->answer);
                                $text = str_replace('__PRICING_ROUTE__',route('contact'), $question->answer);
                                $text = str_replace('__KB_ROUTE__',route('contact'), $question->answer);
                                $text = str_replace('__TERMS_ROUTE__',route('contact'), $question->answer);
                                $text = str_replace('__PP_ROUTE__',route('contact'), $question->answer);

                            @endphp
                            {!! $text !!}
                            @else
                            @php
                                $text = str_replace('__CONTACT_ROUTE__',route('contact'), $question->answer_ar);
                                $text = str_replace('__PRODUCTS_ROUTE__',route('contact'), $question->answer_ar);
                                $text = str_replace('__PRICING_ROUTE__',route('contact'), $question->answer_ar);
                                $text = str_replace('__KB_ROUTE__',route('contact'), $question->answer_ar);
                                $text = str_replace('__TERMS_ROUTE__',route('contact'), $question->answer_ar);
                                $text = str_replace('__PP_ROUTE__',route('contact'), $question->answer_ar);
                            @endphp
                            {!! $text !!}
                            @endif
                            </div>
                        </div>
                    </a>
                </li>


            </div>
            @endforeach

            {{-- <div  class="item relative  w-full">
                <li class=" border border-gray-200 hover:border-secondary_blue p-2  rounded-[0.5rem]">
                    <a href="" class="hover:no-underline hover:border-secondary_blue">
                        <div>

                            <div class="flex justify-center items-center font-bold">
                                {{ __('main.titlevalue_manage_accounts') }}
                            </div>

                            <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('main.textvalue_manage_accounts') }}" class="flex justify-center items-center mt-2 text-sm text-left whitespace-nowrap overflow-hidden">
                                {{ __('main.textvalue_manage_accounts') }}
                            </div>
                        </div>
                    </a>
                </li>
            </div>
            <div  class="item relative  w-full">
                <li class=" border border-gray-200 hover:border-secondary_blue p-2  rounded-[0.5rem]">
                    <a href="" class="hover:no-underline hover:border-secondary_blue">
                        <div>

                            <div class="flex justify-center items-center font-bold">
                                {{ __('main.titlevalue_add_kiosk') }}
                            </div>

                            <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('main.textvalue_add_kiosk') }}"  class="flex justify-center items-center mt-2 text-sm text-left whitespace-nowrap overflow-hidden">
                                {{ __('main.textvalue_add_kiosk') }}
                            </div>
                        </div>
                    </a>
                </li>
            </div>
            <div  class="item relative  w-full">
                <li class=" border border-gray-200 hover:border-secondary_blue p-2  rounded-[0.5rem]">
                    <a href="" class="hover:no-underline hover:border-secondary_blue">
                        <div>

                            <div class="flex justify-center items-center font-bold">
                                {{ __('main.titlevalue_form_customization') }}
                            </div>

                            <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('main.textvalue_form_customization') }}" class="flex justify-center items-center mt-2 text-sm text-left whitespace-nowrap overflow-hidden">
                                {{ __('main.textvalue_form_customization') }}
                            </div>
                        </div>
                    </a>
                </li>
            </div>
            <div  class="item relative  w-full">
                <li class=" border border-gray-200 hover:border-secondary_blue p-2  rounded-[0.5rem]">
                    <a href="" class="hover:no-underline hover:border-secondary_blue">
                        <div>

                            <div class="flex justify-center items-center font-bold">
                                {{ __('main.titlevalue_problem_diagnosis') }}
                            </div>

                            <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('main.textvalue_problem_diagnosis') }}" class="flex justify-center items-center mt-2 text-sm text-left whitespace-nowrap overflow-hidden">
                                {{ __('main.textvalue_problem_diagnosis') }}
                            </div>
                        </div>
                    </a>
                </li>
            </div>
            <div  class="item relative  w-full">
                <li class=" border border-gray-200 hover:border-secondary_blue p-2  rounded-[0.5rem]">
                    <a href="" class="hover:no-underline hover:border-secondary_blue">
                        <div>

                            <div class="flex justify-center items-center font-bold">
                                {{ __('main.titlevalue_billing_invoice') }}
                            </div>

                            <div data-bs-toggle="tooltip"  data-bs-html="true" title="  {{ __('main.textvalue_billing_invoice') }}" class="flex justify-center items-center mt-2 text-sm text-left whitespace-nowrap overflow-hidden">
                                {{ __('main.textvalue_billing_invoice') }}
                            </div>
                        </div>
                    </a>
                </li>
            </div>
            <div  class="item relative  w-full">
                <li class=" border border-gray-200 hover:border-secondary_blue p-2  rounded-[0.5rem]">
                    <a href="" class="hover:no-underline hover:border-secondary_blue">
                        <div>

                            <div class="flex justify-center items-center font-bold">
                                {{ __('main.titlevalue_subscription_problem') }}
                            </div>

                            <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('main.textvalue_subscription_problem') }}" class="flex justify-center items-center mt-2 text-sm text-left whitespace-nowrap overflow-hidden">
                                {{ __('main.textvalue_subscription_problem') }}
                            </div>
                        </div>
                    </a>
                </li>
            </div> --}}
        </ul>
       </div>

    </div>
    <div class=" border     shadow  rounded-[0.5rem] p-4  min-h-[80%] max-h-[80%] ">
        <div class="flex justify-start items-center   mb-2">
              <button type="button" data-toggle="modal" data-target="#addticket" class=" rounded bg-gray-300 p-2 text-secondary_blue hover:text-secondary_1 hover:no-underline focus:outline-none active:outline-none">
                {{ __('main.createticket') }}
              </button>
        </div>
        <div class="">
            @if(count($tickets)==0)
                    <div class="col-span-12 flex justify-center items-center ">
                    <span class="text-md text-center text-black">{{ __('main.notickets' ) }}</span>
                    </div>
            @else
            <div  class="grow rounded-[0.5rem]  overflow-y-auto max-h-screen">
                <table class="tickets-table table-fixed w-full rounded-xl">
                    <thead class="h-10">
                        <tr class="border-b-[1px] border-t-[1px] p-1  bg-white text-black">
                          <th data-sortas="numeric" class="sticky top-0 px-4 py-2 bg-white ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center ">{{ __('main.ticketid') }}</th>
                          <th class="sticky top-0 px-4 py-2 bg-white ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center ">{{ __('main.target') }}</th>
                          <th class="sticky top-0 px-4 py-2 bg-white ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center ">{{ __('main.subject') }}</th>
                          <th class="sticky top-0 px-4 py-2 bg-white ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center ">{{ __('main.description') }}</th>
                          <th class="sticky top-0 px-4 py-2 bg-white ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center ">{{ __('main.status') }}</th>

                        </tr>
                      </thead>
                      <tbody class="bg-white ">

                            @foreach ($tickets as $ticket )
                            <tr class="hover:border-2 hover:border-secondary_blue hover:z-20 hover:shadow  h-10 min-h-10 max-h-10 w-full   p-1 border-b-[1px] border-gray-200">
                                <td data-sortvalue="{{ $ticket->id }}}"  class="text-center ">
                                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('FHT-') }}{{ $ticket->id }}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                                    <span  class="truncate text-sm xs:text-xs">{{ __('FHT-') }}{{ $ticket->id }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $ticket->target }}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                                    <span  class="truncate text-sm xs:text-xs">{{ $ticket->target }}</span>
                                    </div>
                                </td>
                                <td class="text-center ">
                                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $ticket->subject }}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                                    <span  class="truncate text-sm xs:text-xs">{{ $ticket->subject }}</span>
                                    </div>
                                </td>
                                <td class="text-center ">
                                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $ticket->description }}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-start items-center">
                                    <span  class="truncate text-sm xs:text-xs text-left">{{ $ticket->description }}</span>
                                    </div>
                                </td>
                                <td class="text-center ">
                                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $ticket->status }}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                                    <span  class="truncate text-sm xs:text-xs text-{{ $StatusColors[$ticket->status] }}">
                                        {{ $ticket->status }}
                                       @if($ticket->status=="Open")
                                            <svg class="inline-block w-4 h-4 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                            <g id="SVGRepo_iconCarrier"> <path opacity="0.5" d="M2 16C2 13.1716 2 11.7574 2.87868 10.8787C3.75736 10 5.17157 10 8 10H16C18.8284 10 20.2426 10 21.1213 10.8787C22 11.7574 22 13.1716 22 16C22 18.8284 22 20.2426 21.1213 21.1213C20.2426 22 18.8284 22 16 22H8C5.17157 22 3.75736 22 2.87868 21.1213C2 20.2426 2 18.8284 2 16Z" fill="#ce2727"/> <path d="M12.75 14C12.75 13.5858 12.4142 13.25 12 13.25C11.5858 13.25 11.25 13.5858 11.25 14V18C11.25 18.4142 11.5858 18.75 12 18.75C12.4142 18.75 12.75 18.4142 12.75 18V14Z" fill="#ce2727"/> <path d="M6.75 8C6.75 5.10051 9.10051 2.75 12 2.75C14.4453 2.75 16.5018 4.42242 17.0846 6.68694C17.1879 7.08808 17.5968 7.32957 17.9979 7.22633C18.3991 7.12308 18.6405 6.7142 18.5373 6.31306C17.788 3.4019 15.1463 1.25 12 1.25C8.27208 1.25 5.25 4.27208 5.25 8V10.0546C5.68651 10.022 6.18264 10.0089 6.75 10.0036V8Z" fill="#ce2727"/> </g>
                                            </svg>
                                       @elseif($ticket->status=="Pending")
                                            <svg class="inline-block w-4 h-4 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                            <g id="SVGRepo_iconCarrier"> <path opacity="0.15" d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" fill="#ffee38"/> <path d="M12 16.99V17M12 7V14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#ccbb00" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                            </svg>
                                       @elseif($ticket->status=="In Progress")
                                            <svg class="inline-block w-4 h-4 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                            <g id="SVGRepo_iconCarrier"> <circle opacity="0.5" cx="12" cy="12" r="10" stroke="#003cff" stroke-width="1.5"/> <path d="M17 10L7 10L10.4375 7" stroke="#003cff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M7 14L17 14L13.5625 17" stroke="#003cff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                            </svg>
                                       @elseif($ticket->status=="Closed")
                                            <svg class="inline-block w-4 h-4 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                            <g id="SVGRepo_iconCarrier"> <path opacity="0.5" d="M2 16C2 13.1716 2 11.7574 2.87868 10.8787C3.75736 10 5.17157 10 8 10H16C18.8284 10 20.2426 10 21.1213 10.8787C22 11.7574 22 13.1716 22 16C22 18.8284 22 20.2426 21.1213 21.1213C20.2426 22 18.8284 22 16 22H8C5.17157 22 3.75736 22 2.87868 21.1213C2 20.2426 2 18.8284 2 16Z" fill="#007002"/> <path d="M12.75 14C12.75 13.5858 12.4142 13.25 12 13.25C11.5858 13.25 11.25 13.5858 11.25 14V18C11.25 18.4142 11.5858 18.75 12 18.75C12.4142 18.75 12.75 18.4142 12.75 18V14Z" fill="#007002"/> <path d="M6.75 8C6.75 5.10051 9.10051 2.75 12 2.75C14.8995 2.75 17.25 5.10051 17.25 8V10.0036C17.8174 10.0089 18.3135 10.022 18.75 10.0546V8C18.75 4.27208 15.7279 1.25 12 1.25C8.27208 1.25 5.25 4.27208 5.25 8V10.0546C5.68651 10.022 6.18264 10.0089 6.75 10.0036V8Z" fill="#007002"/> </g>
                                            </svg>
                                        @endif
                                    </span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                      </tbody>


                </table>



            </div>
            @endif
       </div>
    </div>
    {{-- add ticket modal --}}
    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " data-backdrop="static" data-keyboard="false" id="addticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">

        @livewire('add-ticket')

        </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js"></script>

    <script>
var $owl_faq = $('.owl_faq');
        //     $owl.trigger('destroy.owl.carousel');

        //    $owl.find('.owl-stage-outer').removeClass('owl-loaded');
            //    $(owl).owlCarousel($(owl).data()); // Initialize Owl carousel once again with same config options

            $owl_faq.owlCarousel({
                loop:false,
            margin:10,
            nav:false,
            responsiveClass:true,
            // navText: ["<div class=''><</div>", "<div class=''>></div>"],

            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:4
                },
                1800:{items:4}
            }
    });
$(".tickets-table").fancyTable({
			sortColumn:0,
            sortable:true,
            sortOrder: 'descending',
            searchable:false,
			globalSearch:false
		});


    </script>
@endpush
