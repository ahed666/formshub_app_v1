<div >

    <div class="flex items-start justify-between p-4 border-b rounded-t ">
        <div  class="grid col-span-3">
            <div wire:loading.class="animate-pulse"  class="bg-primary_blue rounded-[0.5rem] px-2 py-1  grid grid-cols-3   space-x-1 items-center ">
            <span class="text-sm font-bold text-left col-span-1 xs:col-span-3">{{ __('main.componenttype') }}</span>
            <span class="text-sm col-span-2 xs:col-span-3">{{ $type_detail }}</span>
            </div>
            <div wire:loading.class="animate-pulse"  class="bg-primary_blue rounded-[0.5rem] px-2 py-1  grid grid-cols-3  space-x-1 items-center mt-1">
                <span class="text-sm font-bold text-left col-span-1 xs:col-span-3 ">{{ __('main.displaylangauge') }}</span>
                <span class="text-sm col-span-1 xs:col-span-3 ">{{$languageNamesByCode[$local] ?? 'Language Not Found' }}</span>
            </div>

        </div>
        <button wire:click="resetvalue()" type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
            items-center  close" data-dismiss="modal" aria-label="Close">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
            011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </div>
    <!-- Modal body -->

    <form  wire:submit.prevent="save" >
        @csrf
            {{-- question text --}}
            <x-question-text :text="$question_text" :hint="$hint_question" :local="$local"   />

            {{-- yes or no || like or dislike || accept or not accept --}}
            @if($type=="yes_no"||$type=="like_dislike"||$type=="Agree_Disagree"||$type=="satisfaction"||$type=="rating")

                <div class="flex  justify-center my-8">
                    {{-- yes or no --}}
                    @if($type=="yes_no")

                        @for($i = 1; $i >=0; $i--)

                            <div class="mx-4">
                                <div class="border-[1px] border-gray-300 select-none peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold peer-checked:text-xl w-32 max-w-32 min-w-32 h-16
                                flex justify-center items-center p-2   text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                peer-checked:border-blue-400
                               hover:text-gray-600 hover:bg-gray-100  mx-1">
                                   <span class="text-black font-bold">
                                       {{ $answers[$i]['value'] }}
                                   </span>
                               </div>


                               <div class="pl-2 w-[90%] h-auto grid grid-cols-12  justify-center mt-[2px] ">
                                    {{-- score --}}
                                    <div class="col-span-6"><x-score-item :i="$i" :answers="$answers" /></div>
                                    <div class="col-span-6"><x-answer-actions :i="$i" :answers="$answers" /></div>
                                </div>
                            </div>
                        @endfor
                    {{-- satisfaction --}}
                    @elseif($type=="satisfaction"||$type=="rating")
                        @for($i = 4; $i>=0; $i--)
                            <div class="mx-2">
                                    @php
                                        $idx=$i+1;
                                        $path="images/emoji/$idx.png"
                                    @endphp
                                @if($type=="rating")
                                    <div class="border-[1px] border-gray-300 peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600
                                    peer-checked:font-bold  w-32 min-w-32 max-w-32 min-h-32 max-h-32  h-32 flex justify-center items-center p-2
                                    text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                     peer-checked:border-blue-400 hover:text-gray-600 hover:bg-gray-100 ">
                                <span class="text-black  text-4xl pointer-events-none">{{ $answers[$i]['value'] }}</span></div>
                                @else
                                    <div class=" border-[1px] border-gray-300 select-none grid peer-checked:drop-shadow-lg peer-checked:bg-blue-100
                                    peer-checked:text-blue-600 peer-checked:font-bold w-32 min-w-32 max-w-32 min-h-32 max-h-32  h-32   flex
                                    justify-center items-center p-2 text-gray-500  border-[2px] rounded-lg cursor-pointer
                                     peer-checked:border-blue-400 hover:text-gray-600 hover:bg-gray-100
                                    ">
                                    <div class="grid">
                                        <div class="flex justify-center items-center">
                                            {{-- <img class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16" src="{{ asset($answers[$i]['image']) }}" alt=""> --}}
                                            @switch($answers[$i]['value'] )
                                                @case('راضي تماماٌ')
                                                @case('Very Satisfied')
                                                @case('مکمل طور پر مطمئن')
                                                @case('Ganap na Nasiyahan')
                                                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                    <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <g id="SVGRepo_iconCarrier"> <path d="M6.70504 10.7092C6.8501 10.5689 7.01205 10.4438 7.1797 10.3321C7.50489 10.1153 7.80058 10 8 10C8.19942 10 8.49511 10.1153 8.8203 10.3321C9.07494 10.5018 9.26866 10.6837 9.2931 10.7074C9.68451 11.0859 10.3173 11.0969 10.7071 10.7071C11.0976 10.3166 11.0976 9.68342 10.7071 9.29289C10.4723 9.05848 10.2052 8.85164 9.9297 8.66795C9.50489 8.38475 8.80058 8 8 8C7.19942 8 6.49511 8.38475 6.0703 8.66795C5.79505 8.85145 5.52844 9.05816 5.29363 9.29216C4.90926 9.67754 4.90613 10.3203 5.29289 10.7071C5.68258 11.0968 6.31431 11.0972 6.70504 10.7092Z" fill="#1ba211"/> <path d="M8.88875 13.5414C8.63822 13.0559 8.0431 12.8607 7.55301 13.1058C7.05903 13.3528 6.8588 13.9535 7.10579 14.4474C7.18825 14.6118 7.29326 14.7659 7.40334 14.9127C7.58615 15.1565 7.8621 15.4704 8.25052 15.7811C9.04005 16.4127 10.2573 17.0002 12.0002 17.0002C13.7431 17.0002 14.9604 16.4127 15.7499 15.7811C16.1383 15.4704 16.4143 15.1565 16.5971 14.9127C16.7076 14.7654 16.8081 14.6113 16.8941 14.4485C17.1387 13.961 16.9352 13.3497 16.4474 13.1058C15.9573 12.8607 15.3622 13.0559 15.1117 13.5414C15.0979 13.5663 14.9097 13.892 14.5005 14.2194C14.0401 14.5877 13.2573 15.0002 12.0002 15.0002C10.7431 15.0002 9.96038 14.5877 9.49991 14.2194C9.09071 13.892 8.90255 13.5663 8.88875 13.5414Z" fill="#1ba211"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#1ba211"/> <path d="M14.705 10.7092C14.8501 10.5689 15.0121 10.4438 15.1797 10.3321C15.5049 10.1153 15.8006 10 16 10C16.1994 10 16.4951 10.1153 16.8203 10.3321C17.0749 10.5018 17.2687 10.6837 17.2931 10.7074C17.6845 11.0859 18.3173 11.0969 18.7071 10.7071C19.0976 10.3166 19.0976 9.68342 18.7071 9.29289C18.4723 9.05848 18.2052 8.85164 17.9297 8.66795C17.5049 8.38475 16.8006 8 16 8C15.1994 8 14.4951 8.38475 14.0703 8.66795C13.795 8.85145 13.5284 9.05816 13.2936 9.29216C12.9093 9.67754 12.9061 10.3203 13.2929 10.7071C13.6826 11.0968 14.3143 11.0972 14.705 10.7092Z" fill="#1ba211"/> </g>
                                                    </svg>
                                                    @break
                                                @case('راضي')
                                                @case('Satisfied')
                                                @case('مطمئن')
                                                @case('Nasiyahan')
                                                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                    <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <g id="SVGRepo_iconCarrier"> <path d="M8.5 11C9.32843 11 10 10.3284 10 9.5C10 8.67157 9.32843 8 8.5 8C7.67157 8 7 8.67157 7 9.5C7 10.3284 7.67157 11 8.5 11Z" fill="#0c6006"/> <path d="M17 9.5C17 10.3284 16.3284 11 15.5 11C14.6716 11 14 10.3284 14 9.5C14 8.67157 14.6716 8 15.5 8C16.3284 8 17 8.67157 17 9.5Z" fill="#0c6006"/> <path d="M8.88875 13.5414C8.63822 13.0559 8.0431 12.8607 7.55301 13.1058C7.05903 13.3528 6.8588 13.9535 7.10579 14.4474C7.18825 14.6118 7.29326 14.7659 7.40334 14.9127C7.58615 15.1565 7.8621 15.4704 8.25052 15.7811C9.04005 16.4127 10.2573 17.0002 12.0002 17.0002C13.7431 17.0002 14.9604 16.4127 15.7499 15.7811C16.1383 15.4704 16.4143 15.1565 16.5971 14.9127C16.7076 14.7654 16.8081 14.6113 16.8941 14.4485C17.1387 13.961 16.9352 13.3497 16.4474 13.1058C15.9573 12.8607 15.3622 13.0559 15.1117 13.5414C15.0979 13.5663 14.9097 13.892 14.5005 14.2194C14.0401 14.5877 13.2573 15.0002 12.0002 15.0002C10.7431 15.0002 9.96038 14.5877 9.49991 14.2194C9.09071 13.892 8.90255 13.5663 8.88875 13.5414Z" fill="#0c6006"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#0c6006"/> </g>
                                                    </svg>
                                                    @break
                                                @case('محايد')
                                                @case('Natural')
                                                @case('غیر جانبدار')
                                                @case('Natural')
                                                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                    <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <g id="SVGRepo_iconCarrier"> <path d="M8.5 11C9.32843 11 10 10.3284 10 9.5C10 8.67157 9.32843 8 8.5 8C7.67157 8 7 8.67157 7 9.5C7 10.3284 7.67157 11 8.5 11Z" fill="#c2a800"/> <path d="M17 9.5C17 10.3284 16.3284 11 15.5 11C14.6716 11 14 10.3284 14 9.5C14 8.67157 14.6716 8 15.5 8C16.3284 8 17 8.67157 17 9.5Z" fill="#c2a800"/> <path d="M8 14C7.44772 14 7 14.4477 7 15C7 15.5523 7.44772 16 8 16H15.9991C16.5514 16 17 15.5523 17 15C17 14.4477 16.5523 14 16 14H8Z" fill="#c2a800"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#c2a800"/> </g>
                                                    </svg>
                                                    @break
                                                @case('غير راضي')
                                                @case('Unsatisfied')
                                                @case('غیر مطمئن')
                                                @case('Hindi Nasisiyahan')
                                                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                    <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <g id="SVGRepo_iconCarrier"> <path d="M8.5 11C9.32843 11 10 10.3284 10 9.5C10 8.67157 9.32843 8 8.5 8C7.67157 8 7 8.67157 7 9.5C7 10.3284 7.67157 11 8.5 11Z" fill="#a21111"/> <path d="M17 9.5C17 10.3284 16.3284 11 15.5 11C14.6716 11 14 10.3284 14 9.5C14 8.67157 14.6716 8 15.5 8C16.3284 8 17 8.67157 17 9.5Z" fill="#a21111"/> <path d="M15.1091 16.4588C15.3597 16.9443 15.9548 17.1395 16.4449 16.8944C16.9388 16.6474 17.1391 16.0468 16.8921 15.5528C16.8096 15.3884 16.7046 15.2343 16.5945 15.0875C16.4117 14.8438 16.1358 14.5299 15.7473 14.2191C14.9578 13.5875 13.7406 13 11.9977 13C10.2547 13 9.03749 13.5875 8.24796 14.2191C7.85954 14.5299 7.58359 14.8438 7.40078 15.0875C7.29028 15.2348 7.1898 15.3889 7.10376 15.5517C6.85913 16.0392 7.06265 16.6505 7.55044 16.8944C8.04053 17.1395 8.63565 16.9443 8.88619 16.4588C8.9 16.4339 9.08816 16.1082 9.49735 15.7809C9.95782 15.4125 10.7406 15 11.9977 15C13.2547 15 14.0375 15.4125 14.498 15.7809C14.9072 16.1082 15.0953 16.4339 15.1091 16.4588Z" fill="#a21111"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#a21111"/> </g>
                                                    </svg>
                                                    @break
                                                @default
                                                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                    <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <g id="SVGRepo_iconCarrier"> <path d="M15.1091 16.4588C15.3597 16.9443 15.9548 17.1395 16.4449 16.8944C16.9388 16.6474 17.1391 16.0468 16.8921 15.5528C16.8096 15.3884 16.7046 15.2343 16.5945 15.0875C16.4117 14.8438 16.1358 14.5299 15.7473 14.2191C14.9578 13.5875 13.7406 13 11.9977 13C10.2547 13 9.03749 13.5875 8.24796 14.2191C7.85954 14.5299 7.58359 14.8438 7.40078 15.0875C7.29028 15.2348 7.1898 15.3889 7.10376 15.5517C6.85913 16.0392 7.06265 16.6505 7.55044 16.8944C8.04053 17.1395 8.63565 16.9443 8.88619 16.4588C8.9 16.4339 9.08816 16.1082 9.49735 15.7809C9.95782 15.4125 10.7406 15 11.9977 15C13.2547 15 14.0375 15.4125 14.498 15.7809C14.9072 16.1082 15.0953 16.4339 15.1091 16.4588Z" fill="#d92626"/> <path d="M6.29289 7.29289C6.68342 6.90237 7.31658 6.90237 7.70711 7.29289L9.70711 9.29289C10.0976 9.68342 10.0976 10.3166 9.70711 10.7071C9.31658 11.0976 8.68342 11.0976 8.29289 10.7071L6.29289 8.70711C5.90237 8.31658 5.90237 7.68342 6.29289 7.29289Z" fill="#d92626"/> <path d="M17.7071 8.70711C18.0976 8.31658 18.0976 7.68342 17.7071 7.29289C17.3166 6.90237 16.6834 6.90237 16.2929 7.29289L14.2929 9.29289C13.9024 9.68342 13.9024 10.3166 14.2929 10.7071C14.6834 11.0976 15.3166 11.0976 15.7071 10.7071L17.7071 8.70711Z" fill="#d92626"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#d92626"/> </g>
                                                    </svg>


                                            @endswitch
                                        </div>
                                        <div class="text-center min-w-full w-full h-12 min-h-12"><span class="text-sm  text-black  pointer-events-none">{{ $answers[$i]['value'] }}</span></div>
                                    </div>
                                    </div>
                                @endif
                                {{-- answer options --}}
                                {{-- answer options --}}
                                <div class="pl-2 w-full h-auto grid grid-cols-12  justify-center mt-[2px] ">
                                    {{-- score --}}
                                <div class="col-span-6"><x-score-item :i="$i" :answers="$answers" /></div>
                                <div class="col-span-6"><x-answer-actions :i="$i" :answers="$answers" /></div>
                                </div>
                            </div>
                        @endfor
                    @elseif($type=="Agree_Disagree")
                        @for($i = 1; $i >=0; $i--)
                            <div class="mx-4">
                                <div class="border-[1px] border-gray-300 peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold peer-checked:text-xl w-40 max-w-40 min-w-40 h-16
                                flex justify-center items-center p-2   text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                              peer-checked:border-blue-400
                             hover:text-gray-600 hover:bg-gray-100 ">

                                    <span class="text-black  text-xl  text-center pointer-events-none">
                                        {{ $i==1?$answers[$i]['value']:$answers[$i]['value']}}
                                    </span>
                                </div>
                               {{-- answer options --}}
                               <div class="pl-2 w-[90%] h-auto grid grid-cols-12  justify-center mt-[2px] ">
                                {{-- score --}}
                               <div class="col-span-6"><x-score-item :i="$i" :answers="$answers" /></div>
                                <div class="col-span-6"><x-answer-actions :i="$i" :answers="$answers" /></div>
                                </div>

                            </div>
                        @endfor

                    @elseif ($type=="like_dislike")
                        @for($i = 1; $i >=0; $i--)
                        <div class="mx-4">
                            <div class="border-[1px] border-gray-300 peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold peer-checked:text-xl w-36 max-w-36 min-w-36 h-16
                                                       flex justify-center items-center p-2   text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                                     peer-checked:border-blue-400
                                                    hover:text-gray-600 hover:bg-gray-100 ">
                                                        <span class=" text-lg text-black ">{{$answers[$i]['value']}}</span>
                                                        <img class="object-contain w-10  ml-1 mr-1 "  src="{{$i==1?asset('images/icons/dislike.png'):asset('images/icons/like.png') }}" alt="">
                            </div>
                            {{-- answer options --}}
                            <div class="pl-2 w-[90%] h-auto grid grid-cols-12  justify-center mt-[2px] ">
                                {{-- score --}}
                            <div class="col-span-6"><x-score-item :i="$i" :answers="$answers" /></div>
                                <div class="col-span-6"><x-answer-actions :i="$i" :answers="$answers" /></div>
                            </div>
                        </div>
                        @endfor

                    @endif

                </div>


            {{-- end yes or no ||...... --}}
            {{-- text questions --}}
            @elseif($type=="email"||$type=="drawing"||$type=="number"||$type=="date_question"||$type=="long_text_question"||$type=="short_text_question")
            @php
                $src=$questionsTextImages[$type];
            @endphp
             <div class="flex justify-center items-center w-full ">

               <img class="w-[400px] h-[300px] xs:w-[200px] xs:h-[200px] object-contain" src="{{asset($src)}}" alt="">
             </div>

            {{-- end text questions --}}
           {{-- custom satisfaction and custom rating --}}


            {{--end of custom satisfaction and custom rating --}}
            {{-- Multi Option Question  with image section --}}
            @elseif($type=='mcq_pic'||$type=='checkbox_pic')





                <div x-data="{ selectedHideCount: 0 }" x-on:selected-hide-changed.window="selectedHideCount += $event.detail.value ? 1 : -1" class="my-8 ml-1 mr-1 xs:border-t-[1px] border-gray-100 grid grid-cols-12 max-h-[500px]   overflow-y-scroll sm:grid-cols-3 xs:grid-cols-3 gap-3 py-2 px-4" >

                    @foreach ($answers as $i =>  $answer )
                        @if( $stepanswer>=$i)

                        <div id="list{{ $i }}" class="   p-1  col-span-3 border-[1px] border-gray-300 rounded-lg" >
                            {{-- header of answer  --}}
                            <div class="flex justify-between items-center" >
                                <div class=""><span class="whitespace-nowrap text-sm font-bold " >{{ $answer['code'] }}</span></div>

                            {{-- delete answer  --}}
                            <x-answer-delete :i="$i" :deleteAction="$deleteaction" />
                            </div>
                            {{-- add image section --}}
                            <div class="{{  $answer['hide']==true?"opacity-25":"" }} mt-2 flex justify-center  " >
                            <div class="border-[1px] border-gray-300 p-[2px] rounded-lg w-[100px] h-[100px] ">
                                <img wire:model="{{ asset($answer['image'])}}" class="w-full h-full object-contain block ml-auto mr-auto"
                                    src="{{ asset($answer['temp_image'])}}" alt="">

                                    <label class="items-center w-4 relative  flex bottom-[10px] right-[8px]  bg-green-300 border-[1px] rounded-2xl" for="image">
                                        <svg wire:click="updatecurrentimageindex({{ $i }})" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                                        </svg>
                                    <input   wire:model="image" class="image opacity-0 absolute -z-10" type="file" name="image" id="image" accept="image/*" /></label>
                            </div>
                            </div>
                            {{--end add image section --}}
                            {{-- input answer for description of image --}}
                            <div  class="{{  $answer['hide']==true?"opacity-25":"" }} mt-2 flex justify-center w-full " >
                                <div class="w-full">
                                    <textarea maxlength="80"  rows="3"   class="{{ $local=='en'||$local=='tl'?"text-left":"text-right " }} resize-none focus:shadow-none focus:border-b-2 focus:border-t-0 focus:border-l-0 focus:border-r-0 shadow-none border-t-0 border-r-0 border-l-0 border-b-2 outline-none  w-full  {{ $errors->first("answers.$i.value")?"border-primary_red":"border-valid" }}"    wire:model.defer="answers.{{$i}}.value"  name="answers.{{ $i }}.value"
                                      id="answers.{{ $i }}.value"  required autofocus >
                                    </textarea>
                                </div>
                            </div>
                            {{-- answer option --}}
                            <div class="pl-10 w-full h-auto grid grid-cols-12  justify-center mt-[1px] ">
                                {{-- score --}}
                               <div class="col-span-4 "><x-score-item :i="$i" :answers="$answers" /></div>
                                <div class="col-span-4 "><x-answer-actions :i="$i" :answers="$answers" /></div>
                                <div class="col-span-4 "><x-hide-answer :i="$i" :answers="$answers" /></div>
                            </div>
                        </div>

                        @endif

                    @endforeach

                    @if(count($answers)<=$maxAnswersNum)
                    <div class="col-span-3 flex justify-center items-center  border-[1px] border-gray-300 rounded-lg h-20 ">
                        <x-add-answer-button />
                    </div>
                    @endif
                </div>


            {{-- End Multi Option Question multi answers with image section --}}
            {{-- Multi Option Questions --}}
            @elseif($type=='mcq'||$type=='checkbox')

                {{-- answers  --}}
                <div x-data="{ selectedHideCount: 0 }"  class="xs:mt-2 my-8 xs:border-t-[1px] border-gray-100 flex justify-center py-2 px-4">
                        <div  x-on:selected-hide-changed.window="selectedHideCount += $event.detail.value ? 1 : -1"  class="mt-2 w-full  max-h-[500px]   overflow-y-scroll  grid 2xl:grid-cols-12 lg:grid-cols-12
                         md:grid-cols-12 sm:grid-cols-2 xs:grid-cols-2 gap-2 " >
                            @foreach ($answers as $i =>  $answer )
                            @if( $stepanswer>=$i)
                                <div  id="list{{ $i }}" class="col-span-4  ">
                                    <div  class="flex row-span-6 border-[1px] border-gray-300 p-1 rounded-lg h-20" >
                                        <div class="w-[10%] flex justify-center items-center" >
                                        <span class="whitespace-nowrap text-sm font-bold text-center ">{{ $answer['code'] }}</span>
                                        </div>
                                        {{-- answer input --}}
                                        <textarea maxlength="130"  rows="2"   class="resize-none focus:shadow-none focus:border-b-2 focus:border-t-0 focus:border-l-0 focus:border-r-0 shadow-none border-t-0 border-r-0 border-l-0 border-b-2 outline-none text-black {{  $answer['hide']==true?"opacity-25":"" }} {{ $local=='en'||$local=='tl'?"text-left":"text-right " }} w-[80%] border-b-2 outline-none {{ $errors->first("answers.$i.value")?"border-primary_red":"border-valid" }}"   wire:model.defer="answers.{{$i}}.value"  name="answers.{{ $i }}.value"
                                        id="answers.{{ $i }}.value"  required autofocus ></textarea>
                                        {{-- end answer --}}
                                        {{-- delete answer  --}}
                                        <x-answer-delete :i="$i" :deleteAction="$deleteaction" />
                                    </div>
                                    <div class="pl-10 w-[60%] h-auto grid grid-cols-12  justify-center mt-[1px] ">
                                        {{-- score --}}
                                       <div class="col-span-4 "><x-score-item :i="$i" :answers="$answers" /></div>
                                        <div class="col-span-4 "><x-answer-actions :i="$i" :answers="$answers" /></div>
                                        <div class="col-span-4 "><x-hide-answer :i="$i" :answers="$answers" /></div>
                                    </div>
                                </div>
                            @endif
                            @endforeach



                            @if(count($answers)<=$maxAnswersNum)
                            <div class="col-span-4 flex justify-center items-center  border-[1px] border-gray-300 rounded-lg h-20 ">
                                <x-add-answer-button />
                            </div>
                            @endif


                        </div>
                </div>


            {{-- End Multi Option Questions --}}
            {{-- list question --}}
            @elseif($type=='list')
               {{-- question text --}}


               <div x-data="{ selectedHideCount: 0 }" class="flex justify-center my-8  " >
                   <div x-on:selected-hide-changed.window="selectedHideCount += $event.detail.value ? 1 : -1" class="grid grid-cols-12 gap-1 w-[70%] min-w-max  max-h-[500px]   overflow-y-scroll overflow-x-hidden p-2" >
                       @foreach ($answers as $i =>  $answer )
                           @if( $stepanswer>=$i)
                           <div class="{{  $answer['hide']==true?"opacity-25":"" }} col-span-8 h-16 flex  items-center border-[1px] border-gray-200 p-1 rounded-lg">
                               {{-- tag of each answer --}}
                               <div class="w-[20px] col-span-1 flex justify-center items-center" >  <span class="whitespace-nowrap text-sm font-bold   ">{{ $answer['code'] }}</span></div>
                               {{-- answer input --}}
                               <textarea maxlength="130" rows="3"    class="max-h-[60px] w-[90%] resize-none focus:shadow-none focus:border-b-2 focus:border-t-0 focus:border-l-0 focus:border-r-0 shadow-none border-t-0 border-r-0 border-l-0 border-b-2 outline-none  {{ $local=='en'||$local=='tl'?"text-left":"text-right " }} {{ $errors->first("answers.$i.value")?"border-primary_red":"border-valid" }}
                               "   wire:model.defer="answers.{{$i}}.value"  name="answers.{{ $i }}.value"
                               id="answers.{{ $i }}.value"  required autofocus ></textarea>
                               {{-- end answer --}}

                               {{-- delete answer  --}}
                               <x-answer-delete :i="$i" :deleteAction="$deleteaction" />

                           </div>
                           <div class="col-span-4 flex justify-center items-center h-16">
                                   {{-- answer option --}}
                                   <div class=" pl-2 w-[90%] h-auto grid grid-cols-12  justify-center mt-[1px] ">
                                       {{-- score --}}
                                       <div class="col-span-4 "><x-score-item :i="$i" :answers="$answers" /></div>
                                       <div class="col-span-4 "><x-answer-actions :i="$i" :answers="$answers" /></div>
                                       <div class="col-span-4 "><x-hide-answer :i="$i" :answers="$answers" /></div>
                                   </div>

                           </div>

                           @endif
                       @endforeach



                       @if(count($answers)<=$maxAnswersNum)
                       <div class="col-span-4 flex justify-center items-center  border-[1px] border-gray-300 rounded-lg h-20 ">
                           <x-add-answer-button />
                       </div>
                       @endif

                   </div>

               </div>
            {{-- end list question --}}
            {{--satisfaction or rating with image  Questions --}}
            @elseif($type=="satisfaction_image"||$type=="rating_image")

                {{-- add image section --}}
                <div class=" mt-2 flex justify-center  " >
                    <div class="border-[1px] border-gray-300 p-[2px] rounded-lg w-[150px] h-[150px] ">
                        <img wire:model="{{ asset($question_image_temp)}}" class="w-full h-full object-contain block ml-auto mr-auto"
                            src="{{ asset($question_image_temp)}}" alt="">

                            <label class="items-center w-4 relative  flex bottom-[10px] right-[8px]  bg-green-300 border-[1px] rounded-2xl" for="image">
                                <svg  class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                                </svg>
                            <input   wire:model="image" class="image opacity-0 absolute -z-10" type="file" name="image" id="image" accept="image/*" /></label>
                    </div>
                </div>
               {{--end add image section --}}
                <div class="flex  justify-center my-8">
                    @for($i = 4; $i >=0; $i--)
                        <div class="mx-1">
                            @php
                            $idx=$i+1;
                            $path="images/emoji/$idx.png"
                            @endphp
                            @if($type=="rating_image")
                            <div class="border-[1px] border-gray-300 peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600
                            peer-checked:font-bold  w-32 min-w-32 max-w-32 min-h-32 max-h-32  h-32 flex justify-center items-center p-2
                            text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                             peer-checked:border-blue-400 hover:text-gray-600 hover:bg-gray-100 ">
                            <span class="text-black  text-4xl pointer-events-none">{{ $answers[$i]['value'] }}</span></div>
                            @else
                                <div class=" border-[1px] border-gray-300 select-none grid peer-checked:drop-shadow-lg peer-checked:bg-blue-100
                                peer-checked:text-blue-600 peer-checked:font-bold w-32 min-w-32 max-w-32 min-h-32 max-h-32  h-32   flex
                                justify-center items-center p-2 text-gray-500  border-[2px] rounded-lg cursor-pointer
                                 peer-checked:border-blue-400 hover:text-gray-600 hover:bg-gray-100
                                ">
                                <div class="grid">
                                    <div class="flex justify-center items-center">
                                        {{-- <img class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16" src="{{ asset($answers[$i]['image']) }}" alt=""> --}}
                                        @switch($answers[$i]['value'] )
                                            @case('راضي تماماٌ')
                                            @case('Very Satisfied')
                                            @case('مکمل طور پر مطمئن')
                                            @case('Ganap na Nasiyahan')
                                                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                <g id="SVGRepo_iconCarrier"> <path d="M6.70504 10.7092C6.8501 10.5689 7.01205 10.4438 7.1797 10.3321C7.50489 10.1153 7.80058 10 8 10C8.19942 10 8.49511 10.1153 8.8203 10.3321C9.07494 10.5018 9.26866 10.6837 9.2931 10.7074C9.68451 11.0859 10.3173 11.0969 10.7071 10.7071C11.0976 10.3166 11.0976 9.68342 10.7071 9.29289C10.4723 9.05848 10.2052 8.85164 9.9297 8.66795C9.50489 8.38475 8.80058 8 8 8C7.19942 8 6.49511 8.38475 6.0703 8.66795C5.79505 8.85145 5.52844 9.05816 5.29363 9.29216C4.90926 9.67754 4.90613 10.3203 5.29289 10.7071C5.68258 11.0968 6.31431 11.0972 6.70504 10.7092Z" fill="#1ba211"/> <path d="M8.88875 13.5414C8.63822 13.0559 8.0431 12.8607 7.55301 13.1058C7.05903 13.3528 6.8588 13.9535 7.10579 14.4474C7.18825 14.6118 7.29326 14.7659 7.40334 14.9127C7.58615 15.1565 7.8621 15.4704 8.25052 15.7811C9.04005 16.4127 10.2573 17.0002 12.0002 17.0002C13.7431 17.0002 14.9604 16.4127 15.7499 15.7811C16.1383 15.4704 16.4143 15.1565 16.5971 14.9127C16.7076 14.7654 16.8081 14.6113 16.8941 14.4485C17.1387 13.961 16.9352 13.3497 16.4474 13.1058C15.9573 12.8607 15.3622 13.0559 15.1117 13.5414C15.0979 13.5663 14.9097 13.892 14.5005 14.2194C14.0401 14.5877 13.2573 15.0002 12.0002 15.0002C10.7431 15.0002 9.96038 14.5877 9.49991 14.2194C9.09071 13.892 8.90255 13.5663 8.88875 13.5414Z" fill="#1ba211"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#1ba211"/> <path d="M14.705 10.7092C14.8501 10.5689 15.0121 10.4438 15.1797 10.3321C15.5049 10.1153 15.8006 10 16 10C16.1994 10 16.4951 10.1153 16.8203 10.3321C17.0749 10.5018 17.2687 10.6837 17.2931 10.7074C17.6845 11.0859 18.3173 11.0969 18.7071 10.7071C19.0976 10.3166 19.0976 9.68342 18.7071 9.29289C18.4723 9.05848 18.2052 8.85164 17.9297 8.66795C17.5049 8.38475 16.8006 8 16 8C15.1994 8 14.4951 8.38475 14.0703 8.66795C13.795 8.85145 13.5284 9.05816 13.2936 9.29216C12.9093 9.67754 12.9061 10.3203 13.2929 10.7071C13.6826 11.0968 14.3143 11.0972 14.705 10.7092Z" fill="#1ba211"/> </g>
                                                </svg>
                                                @break
                                            @case('راضي')
                                            @case('Satisfied')
                                            @case('مطمئن')
                                            @case('Nasiyahan')
                                                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                <g id="SVGRepo_iconCarrier"> <path d="M8.5 11C9.32843 11 10 10.3284 10 9.5C10 8.67157 9.32843 8 8.5 8C7.67157 8 7 8.67157 7 9.5C7 10.3284 7.67157 11 8.5 11Z" fill="#0c6006"/> <path d="M17 9.5C17 10.3284 16.3284 11 15.5 11C14.6716 11 14 10.3284 14 9.5C14 8.67157 14.6716 8 15.5 8C16.3284 8 17 8.67157 17 9.5Z" fill="#0c6006"/> <path d="M8.88875 13.5414C8.63822 13.0559 8.0431 12.8607 7.55301 13.1058C7.05903 13.3528 6.8588 13.9535 7.10579 14.4474C7.18825 14.6118 7.29326 14.7659 7.40334 14.9127C7.58615 15.1565 7.8621 15.4704 8.25052 15.7811C9.04005 16.4127 10.2573 17.0002 12.0002 17.0002C13.7431 17.0002 14.9604 16.4127 15.7499 15.7811C16.1383 15.4704 16.4143 15.1565 16.5971 14.9127C16.7076 14.7654 16.8081 14.6113 16.8941 14.4485C17.1387 13.961 16.9352 13.3497 16.4474 13.1058C15.9573 12.8607 15.3622 13.0559 15.1117 13.5414C15.0979 13.5663 14.9097 13.892 14.5005 14.2194C14.0401 14.5877 13.2573 15.0002 12.0002 15.0002C10.7431 15.0002 9.96038 14.5877 9.49991 14.2194C9.09071 13.892 8.90255 13.5663 8.88875 13.5414Z" fill="#0c6006"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#0c6006"/> </g>
                                                </svg>
                                                @break
                                            @case('محايد')
                                            @case('Natural')
                                            @case('غیر جانبدار')
                                            @case('Natural')
                                                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                <g id="SVGRepo_iconCarrier"> <path d="M8.5 11C9.32843 11 10 10.3284 10 9.5C10 8.67157 9.32843 8 8.5 8C7.67157 8 7 8.67157 7 9.5C7 10.3284 7.67157 11 8.5 11Z" fill="#c2a800"/> <path d="M17 9.5C17 10.3284 16.3284 11 15.5 11C14.6716 11 14 10.3284 14 9.5C14 8.67157 14.6716 8 15.5 8C16.3284 8 17 8.67157 17 9.5Z" fill="#c2a800"/> <path d="M8 14C7.44772 14 7 14.4477 7 15C7 15.5523 7.44772 16 8 16H15.9991C16.5514 16 17 15.5523 17 15C17 14.4477 16.5523 14 16 14H8Z" fill="#c2a800"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#c2a800"/> </g>
                                                </svg>
                                                @break
                                            @case('غير راضي')
                                            @case('Unsatisfied')
                                            @case('غیر مطمئن')
                                            @case('Hindi Nasisiyahan')
                                                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                <g id="SVGRepo_iconCarrier"> <path d="M8.5 11C9.32843 11 10 10.3284 10 9.5C10 8.67157 9.32843 8 8.5 8C7.67157 8 7 8.67157 7 9.5C7 10.3284 7.67157 11 8.5 11Z" fill="#a21111"/> <path d="M17 9.5C17 10.3284 16.3284 11 15.5 11C14.6716 11 14 10.3284 14 9.5C14 8.67157 14.6716 8 15.5 8C16.3284 8 17 8.67157 17 9.5Z" fill="#a21111"/> <path d="M15.1091 16.4588C15.3597 16.9443 15.9548 17.1395 16.4449 16.8944C16.9388 16.6474 17.1391 16.0468 16.8921 15.5528C16.8096 15.3884 16.7046 15.2343 16.5945 15.0875C16.4117 14.8438 16.1358 14.5299 15.7473 14.2191C14.9578 13.5875 13.7406 13 11.9977 13C10.2547 13 9.03749 13.5875 8.24796 14.2191C7.85954 14.5299 7.58359 14.8438 7.40078 15.0875C7.29028 15.2348 7.1898 15.3889 7.10376 15.5517C6.85913 16.0392 7.06265 16.6505 7.55044 16.8944C8.04053 17.1395 8.63565 16.9443 8.88619 16.4588C8.9 16.4339 9.08816 16.1082 9.49735 15.7809C9.95782 15.4125 10.7406 15 11.9977 15C13.2547 15 14.0375 15.4125 14.498 15.7809C14.9072 16.1082 15.0953 16.4339 15.1091 16.4588Z" fill="#a21111"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#a21111"/> </g>
                                                </svg>
                                                @break
                                            @default
                                                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                <g id="SVGRepo_iconCarrier"> <path d="M15.1091 16.4588C15.3597 16.9443 15.9548 17.1395 16.4449 16.8944C16.9388 16.6474 17.1391 16.0468 16.8921 15.5528C16.8096 15.3884 16.7046 15.2343 16.5945 15.0875C16.4117 14.8438 16.1358 14.5299 15.7473 14.2191C14.9578 13.5875 13.7406 13 11.9977 13C10.2547 13 9.03749 13.5875 8.24796 14.2191C7.85954 14.5299 7.58359 14.8438 7.40078 15.0875C7.29028 15.2348 7.1898 15.3889 7.10376 15.5517C6.85913 16.0392 7.06265 16.6505 7.55044 16.8944C8.04053 17.1395 8.63565 16.9443 8.88619 16.4588C8.9 16.4339 9.08816 16.1082 9.49735 15.7809C9.95782 15.4125 10.7406 15 11.9977 15C13.2547 15 14.0375 15.4125 14.498 15.7809C14.9072 16.1082 15.0953 16.4339 15.1091 16.4588Z" fill="#d92626"/> <path d="M6.29289 7.29289C6.68342 6.90237 7.31658 6.90237 7.70711 7.29289L9.70711 9.29289C10.0976 9.68342 10.0976 10.3166 9.70711 10.7071C9.31658 11.0976 8.68342 11.0976 8.29289 10.7071L6.29289 8.70711C5.90237 8.31658 5.90237 7.68342 6.29289 7.29289Z" fill="#d92626"/> <path d="M17.7071 8.70711C18.0976 8.31658 18.0976 7.68342 17.7071 7.29289C17.3166 6.90237 16.6834 6.90237 16.2929 7.29289L14.2929 9.29289C13.9024 9.68342 13.9024 10.3166 14.2929 10.7071C14.6834 11.0976 15.3166 11.0976 15.7071 10.7071L17.7071 8.70711Z" fill="#d92626"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#d92626"/> </g>
                                                </svg>


                                        @endswitch
                                    </div>
                                    <div class="text-center min-w-full w-full h-12 min-h-12"><span class="text-sm  text-black  pointer-events-none">{{ $answers[$i]['value'] }}</span></div>
                                </div>
                                </div>
                            @endif

                            {{-- answer options --}}
                            <div class="pl-2 w-full h-auto grid grid-cols-12  justify-center mt-[2px] ">
                                {{-- score --}}
                            <div class="col-span-6"><x-score-item :i="$i" :answers="$answers" /></div>
                            <div class="col-span-6"><x-answer-actions :i="$i" :answers="$answers" /></div>
                            </div>
                        </div>
                    @endfor
                </div>
            {{--end of satisfaction or rating with image  Questions --}}

            @endif


    <!-- Modal footer -->
    <div class="flex justify-between border-t border-gray-200 rounded-b " >
        <div class="flex items-center p-6 ">
            <x-jet-secondary-button data-dismiss="modal" aria-label="Close"  type="button" wire:click="resetvalue()"  wire:loading.attr="disabled">
                    {{ __('main.cancel') }}
            </x-jet-secondary-button>
            <x-jet-button class="ml-3" type="submit"   wire:loading.attr="disabled">
                {{ __('main.save') }}
            </x-jet-button>

            {{-- mandetory --}}
            <div class="ml-14 grid justify-center items-center ">
                <div class="text-center flex justify-center">
                    <span class="text-sm text-center font-medium text-gray-900 ">{{ __('main.mandatory') }}</span></div>
                    <label class="relative  items-center  cursor-pointer">
                        <input wire:model="is_mandetory_question" type="checkbox" value="" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer
                             peer-checked:after:translate-x-full
                            peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                            after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5
                            after:transition-all  peer-checked:bg-secondary_blue">
                        </div>
                    </label>
            </div>

        </div>
        {{-- mandetory button --}}
        <div class="flex items-center p-6 space-x-2 ">
            <ol class="list-decimal" >
            @error('answers.*.value') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
            @error('question') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
            @error('answers') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
            @error('answers.*.score') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
            </ol>
        </div>
    </div>
   </form>
    {{-- crop modal --}}

    <div  id="cropimage-edit"
         class="modal    absolute z-[500px] top-4 bottom-4 left-0 xs:left-0 border-[1px] rounded-t-xl border-transparent
         max-h-[900px]  w-full bg-white
          {{ $modal?"block":"hidden" }}">

            <div class=" h-10 border-[1px] rounded-t-xl border-transparent p-2 flex justify-end modal-header">
            <a wire:click="closemodal" class=" w-10 h-6 text-secondary_red hover:text-primary_red cursor-pointer flex justify-center" >
                <span  class=" close   ">&times;</span>
            </a>
            </div>
            <!-- Modal content -->
            <div class=" h-[80%]   overflow-y-scroll">
                <div class=" result-upload  flex justify-center"></div>
            </div>
            <!--rightbox-->

            <!-- input file -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">
                <!-- save btn -->
                <x-jet-secondary-button  wire:click="closemodal"   type="button" >
                    {{ __('main.cancel') }}
                </x-jet-secondary-button>
                <x-jet-button  wire:click="cropimage"  class="ml-3" type="button"   >
                    {{ __('main.crop') }}
                </x-jet-button>
                {{-- <button wire:click="closemodal" class="cursor-pointer ml-2 mr-2 p-2 border-[2px] border-transparent hover:bg-blue-400  rounded-xl bg-blue-500 w-auto">close</button>
                <a wire:click="cropingimage"   class="btn save hide cursor-pointer ml-2 mr-2 p-2 border-[2px] border-transparent hover:bg-blue-400 rounded-xl bg-blue-500 w-auto">Save</a> --}}
            </div>


    </div>
    {{-- end  crop modal --}}
</div>
@push('scripts')

{{-- hint on hover --}}
<script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js" charset="utf-8"></script>


<script type="text/javascript">
     var translations = @json(__('main'));

  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl);
  });
</script>
{{-- crop image --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- sweet alert delete confirm --}}
<script>
    // to confirm delete form
     window.addEventListener('show-delete-answer-confirmation', event => {
        (async () => {

const { value: accept } = await Swal.fire({
    text: translations.deleteanswer_message,
  input: 'checkbox',
  inputValue: 0,
  icon:'question',
  confirmButtonColor: '#dc2626',
    showCancelButton: true,
    cancelButtonColor:'#f3f4f6',
    cancelButtonText:"<h5 style='color:000000;border:0;box-shadow: none;'>Cancel</h5>",
  inputPlaceholder:translations.suredelete_answer,
  confirmButtonText:translations.delete,
  inputValidator: (result) => {
    return !result && translations.checkboxrequired
  }
})

if (accept) {
    Livewire.emit('deleteanswerConfirmed');

}

})()
     });
</script>
<script >

    document.addEventListener('image-updated-edit', event =>  {

        result = document.querySelector('.result-upload');
        // img_w = document.querySelector('.img-w'),
        // img_h = document.querySelector('.img-h'),
        // options = document.querySelector('.options'),
        save = document.querySelector('.save');

        // dwn = document.querySelector('.download'),
        upload = document.querySelector('.image');
        cropper = '';
        var finalCropWidth = 640;
        var finalCropHeight = 640;
        var finalAspectRatio = finalCropWidth / finalCropHeight;
        // on change show image with crop options

                // start file reader
            const reader = new FileReader();
            let img = document.createElement('img');
            img.id = 'image';
            img.src = @this.imagesrc;
            console.log(img.src);
                        // clean result before
            result.innerHTML = '';
                        // append new image
            result.appendChild(img);

                        // show save btn and options
            // save.classList.remove('hide');
            // options.classList.remove('hide');
                        // init cropper
            cropper = new Cropper(img, {
                dragMode: 'move',
                aspectRatio: finalAspectRatio,
                autoCropArea: 0.9,
                restore: false,
                guides: false,
                center: false,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,

                toggleDragModeOnDblclick: false,
            });




        // save on click

    });
    document.addEventListener('save',(e)=>{
        e.preventDefault();
        // get result to data uri
        let imgSrc = cropper.getCroppedCanvas({
            width:300,
            height:300
            }).toDataURL();



            @this.saveimage(imgSrc);
            @this.closemodalwithsave();
        // dwn.classList.remove('hide');
        // dwn.download = 'imagename.png';
        // dwn.setAttribute('href',imgSrc);
    });
</script>
@endpush
