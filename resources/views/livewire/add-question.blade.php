<div wire:loading.class="" wire:target="save" >

        <!-- Modal header -->


                    @if($step==1)

                        <div class="grid grid-cols-6 p-4 border-b rounded-t ">
                            <div  class="grid col-span-3 ">
                                <div wire:loading.class="animate-pulse"  class="bg-primary_blue rounded-[0.5rem] px-2 py-1  grid grid-cols-3 xs:grid-rows-2 space-x-1 items-center ">
                                   <span class="text-sm font-bold text-left col-span-1 xs:col-span-3">{{ __('main.componenttype') }}</span>
                                   <span class="text-sm col-span-2 xs:col-span-3">{{ __('Select Question Type') }}</span>
                                </div>
                                <div wire:loading.class="animate-pulse"  class="bg-primary_blue rounded-[0.5rem] px-2 py-1  grid grid-cols-3 xs:grid-rows-2 space-x-1 items-center mt-1">
                                    <span class="text-sm font-bold text-left col-span-1 xs:col-span-3">{{ __('main.displaylanguage') }}</span>
                                    <span class="text-sm col-span-2 xs:col-span-3">{{$languageNamesByCode[$local] ?? 'Language Not Found' }}</span>
                                 </div>

                            </div>
                            <div class="col-span-2 flex justify-center items-center">
                                <h3 class="text-xl font-bold text-gray-900  ">
                                    {{ __('Step ') }} {{ $step }}
                                </h3>
                            </div>
                            <div class="col-span-1 flex justify-center items-center"><button type="button" wire:click="resetvalue()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                                items-center  close" data-dismiss="modal" aria-label="Close">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                                011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </button></div>
                        </div>

                        @if($valid==false)
                        <x-add_item_error  :error="$error" :subscribe="$this->current_subscribe" />

                        @elseif(!$this->current_subscribe->valid)
                        <div class=" flex justify-center items-center text-red-400 bg-red-200 ">{{ ('Your plan had expried since ') }}{{ $current_subscribe->expired_at }}</div>
                            @if($current_subscribe->type!="Free")
                                <a  href="{{ route('subscribe',['renew',$current_subscribe->plan_id]) }}" target="_blank" class="text-blue-400 rounded-xl  hover:text-blue-500 hover:cursor-pointer hover:font-bold hover:no-underline focus:no-underline no-underline p-2">
                                {{ __('Renew Now') }} </a>
                                <span class="text-sm">or</span>
                                <a   href="{{ route('subscribe','upgrade') }}" target="_blank" class="text-blue-400 rounded-xl  hover:text-blue-500 hover:cursor-pointer hover:font-bold hover:no-underline focus:no-underline no-underline p-2">
                                    {{ __('Upgrade Now') }} </a>
                                @elseif($current_subscribe->type!="ultimate")
                                <a  href="{{ route('subscribe',['renew',$current_subscribe->plan_id]) }}" target="_blank" class="text-blue-400 rounded-xl  hover:text-blue-500 hover:cursor-pointer hover:font-bold hover:no-underline focus:no-underline no-underline p-2">
                                    {{ __('Renew Now') }} </a>
                                    <span class="text-sm">or</span>
                                    <a   href="{{ route('subscribe','downgrade') }}" target="_blank" class="text-blue-400 rounded-xl  hover:text-blue-500 hover:cursor-pointer hover:font-bold hover:no-underline focus:no-underline no-underline p-2">
                                        {{ __('Downgrade Now') }} </a>
                                @else
                                <a   href="{{ route('subscribe','upgrade') }}" target="_blank" class="text-blue-400 rounded-xl  hover:text-blue-500 hover:cursor-pointer hover:font-bold hover:no-underline focus:no-underline no-underline p-2">
                                    {{ __('Upgrade Now') }} </a>
                            @endif
                        @else
                        <!-- Modal body -->
                        <div wire:ignore class="px-2 overflow-y-auto 2xl:max-h-[600px] xs:max-h-[400px]">
                             @foreach ( $category_types as $i=>$category )
                                <div class="mb-1 mt-2 px-2 font-bold text-black  " >
                                    <span>
                                        @if (App::getLocale() == 'en')
                                    {{ $category->category_name }}
                                    @else
                                    {{ $category->category_name_ar }}
                                    @endif

                                    </span>
                                </div>
                                <ul  class="  grid w-full  grid-cols-10  gap-4 p-1  " >
                                    @foreach ($category->enabledQuestionTypes as $t )


                                            @php
                                                if (App::getLocale() == 'en')
                                                    $type_details=$t->question_type_details ;
                                                else
                                                    $type_details= $t->question_type_details_ar;

                                            @endphp
                                                <li   class="2xl:col-span-2 xl:col-span-2 lg:col-span-2 md:col-span-4  sm:col-span-4 xs:col-span-5 "  >
                                                    <input wire:loading.class="disabled"

                                                     wire:model.defer="selectedTypeId"
                                                      value="{{ $t->id }}"  class="hidden peer" name="question" id="item{{ $t->id }}" type="radio" required>
                                                        <label for="item{{ $t->id }}" class="inline-flex items-center justify-between w-full p-1  text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                                        peer-checked:border-blue-400
                                                        hover:text-gray-600 hover:bg-gray-100 ">
                                                        <img src="{{asset($t->image)}}" alt="">

                                                    </label>

                                                    <div class="flex items-baseline">
                                                        <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $type_details }}">
                                                            <svg   class="inline-block text-blue-400 ml-[1px] mr-[1px] w-[20px] h[20px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                                            </svg>
                                                        </a>
                                                        <span class="text-sm text-left whitespace-normal inline-block">
                                                            {{ $type_details }}
                                                            </span>

                                                    </div>

                                                </li>

                                    @endforeach
                                </ul>
                            @endforeach
                       </div>
                        <!-- Modal footer -->
                        <div class="flex justify-between items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">
                            <div>  <x-jet-secondary-button data-te-modal-dismiss
                            data-dismiss="modal" aria-label="Close"  type="button" wire:click="resetvalue()"  wire:loading.attr="disabled">
                                {{ __('main.cancel') }}
                            </x-jet-secondary-button>
                            <button class="inline-flex items-center px-4 py-2 bg-secondary_blue
                            border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                             active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                             wire:click="increasestep()"  type="submit"   wire:loading.attr="disabled">
                                    {{ __('main.next') }}
                            </button> </div>

                            <div>
                                @error('selectedTypeId') <li class="text-red-400 animate-pulse"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
                            </div>
                        </div>
                         @endif


                    @elseif($step==2)

                        <div class="grid grid-cols-6 p-4 border-b rounded-t ">
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
                            <div class="col-span-2 flex justify-center items-center">
                                <h3 class="text-xl font-bold text-gray-900  ">
                                    {{ __('Step ') }} {{ $step }}
                                </h3>
                            </div>
                            <div class="col-span-1 flex justify-center items-center"><button type="button" wire:click="resetvalue()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                                items-center  close" data-dismiss="modal" aria-label="Close">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                                011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </button></div>
                        </div>

                            <!-- Modal body -->

                            <form wire:submit.prevent="save" >
                               @csrf
                                {{-- question text --}}
                                <x-question-text  :text="$question_text" :local="$local"   />
                                <div class="mt-2 flex justify-center items-center space-x-1 px-4">
                                    <span class="text-sm text-secondary_red font-bold">{{ __('main.answers') }}</span>
                                    @if($type=="email"||$type=="yes_no"||$type=="like_dislike"||$type=="Agree_Disagree"||$type=="satisfaction"||$type=="rating"||$type=="drawing"||$type=="number"||$type=="date_question"||$type=="long_text_question"||$type=="short_text_question")
                                    <span class="text-sm">{{ __('main.hintAddAnswers_premade') }} </span>

                                    @else
                                    <span class="text-sm">{{ __('main.hintAddAnswers') }} </span>
                                    @endif
                                 </div>
                               {{-- yes or no || like or dislike || accept or not accept --}}
                                @if($type=="yes_no"||$type=="like_dislike"||$type=="Agree_Disagree"||$type=="satisfaction"||$type=="rating")


                                    <div class="flex xs:grid  justify-center my-8" x-data="{ showScore: {} }">
                                        {{-- yes or no --}}
                                        @if($type=="yes_no")
                                            @for($i = 1; $i >=0; $i--)

                                                <div class="mx-8 mx-4 xs:mx-0 xs:flex xs:justify-between xs:items-center xs:space-x-2 xs:mb-2">
                                                    <div class="border-[1px] border-gray-300 select-none peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold peer-checked:text-xl w-32 max-w-32 min-w-32 h-16
                                                     flex justify-center items-center p-2   text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                                     peer-checked:border-blue-400
                                                    hover:text-gray-600 hover:bg-gray-100  mx-1">
                                                        <span class="text-black font-bold">
                                                            {{ $answers[$i]['value'] }}
                                                        </span>
                                                    </div>

                                                    <x-options-logic :i="$i" :answers="$answers" />

                                                </div>
                                            @endfor
                                        {{-- satisfaction or rating --}}
                                        @elseif($type=="satisfaction"||$type=="rating")
                                            @for($i = 4; $i >=0; $i--)
                                                <div class="mx-4 mx-4 xs:mx-0 xs:flex xs:justify-between xs:items-center xs:space-x-2 xs:mb-2">


                                                    @if($type=="rating")
                                                    <div class="border-[1px] border-gray-300 peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600
                                                    peer-checked:font-bold  w-32 min-w-32 max-w-32 min-h-32 max-h-32  h-32 flex justify-center items-center p-2
                                                    text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                                     peer-checked:border-blue-400 hover:text-gray-600 hover:bg-gray-100  ">
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
                                                            {!! $answers[$i]['svg'] !!}
                                                        </div>
                                                        <div class="text-center min-w-full w-full h-12 min-h-12"><span class="text-sm  text-black  pointer-events-none">{{ $answers[$i]['value'] }}</span></div>
                                                    </div>
                                                    </div>
                                                    @endif

                                                    {{-- answer options --}}
                                                    <x-options-logic :i="$i" :answers="$answers" />
                                                </div>
                                            @endfor
                                        {{-- Agree disagree --}}
                                        @elseif($type=="Agree_Disagree")
                                            @for($i = 1; $i >=0; $i--)
                                                <div class="mx-8 mx-4 xs:mx-0 xs:flex xs:justify-between xs:items-center xs:space-x-2 xs:mb-2">
                                                    <div class="border-[1px] border-gray-300 peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold peer-checked:text-xl w-48 max-w-48 min-w-32 h-16
                                                    flex justify-center items-center p-2   text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                                  peer-checked:border-blue-400
                                                 hover:text-gray-600 hover:bg-gray-100 ">
                                                        <span class="text-black  text-xl  text-center pointer-events-none ">
                                                            {{ $answers[$i]['value'] }}
                                                        </span>
                                                    </div>
                                                    {{-- answer options --}}
                                                    <x-options-logic :i="$i" :answers="$answers" />
                                                </div>
                                            @endfor

                                        {{-- like dislike --}}
                                        @elseif ($type=="like_dislike")
                                            @for($i = 1; $i >=0; $i--)
                                                <div class="mx-8 mx-4 xs:mx-0 xs:flex xs:justify-between xs:items-center xs:space-x-2 xs:mb-2">
                                                    <div class="border-[1px] border-gray-300 peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold peer-checked:text-xl w-32 max-w-36 min-w-36 h-16
                                                       flex justify-center items-center p-2   text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                                       peer-checked:border-blue-400
                                                    hover:text-gray-600 hover:bg-gray-100 ">
                                                        <span class=" text-lg text-black ">{{$answers[$i]['value']}}</span>
                                                        <img class="object-contain w-10  ml-1 mr-1 "  src="{{$i==1?asset('images/icons/dislike.png'):asset('images/icons/like.png') }}" alt="">
                                                    </div>
                                                    {{-- answer options --}}
                                                    <x-options-logic :i="$i" :answers="$answers" />

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
                                {{-- multi option question --}}
                                @elseif ($type=="mcq"||$type=="checkbox")



                                        {{-- answers  --}}
                                    <div x-data="{ selectedHideCount: 0 }"  class="xs:mt-2 my-8 xs:border-t-[1px] border-gray-100 flex justify-center py-2 px-4">
                                            <div  x-on:selected-hide-changed.window="selectedHideCount += $event.detail.value ? 1 : -1"  class="mt-2 w-full  max-h-[500px]   overflow-y-scroll  grid 2xl:grid-cols-12 lg:grid-cols-12
                                             md:grid-cols-12 sm:grid-cols-2 xs:grid-cols-2 gap-2 " >
                                                @foreach ($answers as $i =>  $answer )
                                                @if( $stepanswer>=$i)
                                                    <div  id="list{{ $i }}" class="col-span-4  border-[1px] border-gray-300 rounded-lg p-1 ">
                                                        <div  class="flex row-span-6   h-20 mb-1" >
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
                                                        <x-options-multianswers :i="$i" :answers="$answers" />
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
                                {{-- end --}}
                                {{-- Multi Option Question multi answers with image section --}}
                                @elseif($type=="mcq_pic"||$type=="checkbox_pic")




                                    <div x-data="{ selectedHideCount: 0 }" x-on:selected-hide-changed.window="selectedHideCount += $event.detail.value ? 1 : -1" class="my-8
                                     xs:border-t-[1px] border-gray-100 grid grid-cols-12 max-h-[500px]   overflow-y-scroll sm:grid-cols-3 xs:grid-cols-3 gap-3 py-2 px-4" >

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
                                                    <img  wire:ignore id="answerimage-image{{ $i }}" wire:model.defer="answers.{{$i}}.image" class="w-full h-full object-contain block ml-auto mr-auto"
                                                        src="{{ asset($answer['image'])}}" alt="">

                                                        <label class="items-center w-4 relative  flex bottom-[10px] right-[8px]  bg-green-300 border-[1px] rounded-2xl" for="image{{ $i }}">
                                                            <svg  class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                                                            </svg>
                                                            {{-- wire:model="image" --}}
                                                        <input onchange="uploadImageAdd(event,{{ $i }},'add')"    class="image opacity-0 absolute -z-10" type="file" name="image{{ $i }}" id="image{{ $i }}" accept="image/*" /></label>
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
                                                <x-options-multianswers :i="$i" :answers="$answers" />
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
                                {{-- list question --}}
                                @elseif($type=="list")
                                    <div x-data="{ selectedHideCount: 0 }" class="flex justify-center my-8  " >
                                        <div x-on:selected-hide-changed.window="selectedHideCount += $event.detail.value ? 1 : -1" class="relative grid grid-cols-12 gap-1 w-[80%] min-w-max  max-h-[500px]  overflow-y-scroll overflow-x-hidden  p-2" >
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
                                                        <x-options-multianswers :i="$i" :answers="$answers" />
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

                                    {{-- Rating and satisfaction with image question --}}
                                @elseif($type=="satisfaction_image"||$type=="rating_image")

                                    {{-- add image section --}}
                                    <div class=" mt-2 flex justify-center  " >
                                        <div class="border-[1px] border-gray-300 p-[2px] rounded-lg w-[150px] h-[150px] ">
                                            <img wire:ignore id="answerimage-image0" wire:model.defer="{{ asset($question_image)}}" class="w-full h-full object-contain block ml-auto mr-auto"
                                                src="{{ asset($question_image)}}" alt="">

                                                <label class="items-center w-4 relative  flex bottom-[10px] right-[8px]  bg-green-300 border-[1px] rounded-2xl" for="image">
                                                    <svg  class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                                                    </svg>
                                                <input onchange="uploadImageAdd(event,'0','add')"    class="image opacity-0 absolute -z-10" type="file" name="image" id="image" accept="image/*" /></label>
                                        </div>
                                    </div>
                                   {{--end add image section --}}
                                   {{-- answers --}}
                                   <div class="flex xs:grid  justify-center my-8">
                                        @for($i = 4; $i >=0; $i--)
                                            <div class="mx-4 xs:mx-0 xs:flex xs:justify-between xs:items-center xs:space-x-2 xs:mb-2">
                                                @if($type=="rating_image")
                                                    <div class="border-[1px] border-gray-300 peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600
                                                    peer-checked:font-bold  w-32 min-w-32 max-w-32 min-h-32 max-h-32  h-32 flex justify-center items-center p-2
                                                    text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                                     peer-checked:border-blue-400 hover:text-gray-600 hover:bg-gray-100   ">
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
                                                           {!! $answers[$i]['svg'] !!}
                                                        </div>
                                                        <div class="text-center min-w-full w-full h-12 min-h-12"><span class="text-sm  text-black  pointer-events-none">{{ $answers[$i]['value'] }}</span></div>
                                                    </div>
                                                    </div>
                                                @endif


                                                {{-- answer options --}}
                                                <x-options-logic :i="$i" :answers="$answers" />
                                            </div>
                                        @endfor
                                   </div>




                                {{-- end Rating and satisfaction with image question --}}

                                @endif



                                <!-- Modal footer -->
                                {{-- data-te-modal-dismiss
                                aria-label="Close" --}}
                                {{-- {{ $disable?"disabled":""}} --}}

                                <div class="flex justify-between border-t border-gray-200 rounded-b " >
                                    <div class="flex items-center p-6 ">
                                        <x-jet-secondary-button   type="button" wire:click="resetvalue()"  wire:loading.attr="disabled">
                                                {{ __('main.back') }}
                                        </x-jet-secondary-button>
                                        <x-jet-button class="ml-3" type="submit"   wire:loading.attr="disabled">
                                            {{ __('main.save') }}
                                        </x-jet-button>
                                        {{-- mandetory --}}
                                        <div class="ml-14 grid justify-center items-center ">
                                            <div class="text-center flex justify-center"><span class="text-sm text-center font-medium text-gray-900 ">{{ __('main.mandatory') }}</span></div>
                                            <label class="relative  items-center  cursor-pointer">

                                                <input wire:model="is_mandetory_question" type="checkbox" value="" class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 rounded-full peer
                                                      peer-checked:after:translate-x-full
                                                    peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                                                    after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5
                                                    after:transition-all  peer-checked:bg-secondary_blue"></div>

                                            </label>
                                        </div>
                                    </div>
                                    {{-- mandetory button --}}
                                    <div class="flex items-center p-6 space-x-2 ">
                                        <ol class="list-decimal" >
                                        @error('answers.*.value') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
                                        @error('question_text') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
                                        @error('answers') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
                                        @error('answers.*.score') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
                                    </ol>
                                    </div>
                                </div>
                            </form>
                    @endif
                {{-- crop image modal --}}

                <x-crop-image-modal :modal="$modal" :type="'add'" />
                {{-- end crop image modal --}}


</div>
@push('scripts')
{{-- hint on hover --}}
{{-- <script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js" charset="utf-8"></script>
<script type="text/javascript">
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl);
  });
</script>
{{-- crop image --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script> --}}
<script >



    let indexImage;

    let cropper;
    let imageInput;
    let modal;
    function closemodal(){
        modal.classList.add('hidden');
    }
    function uploadImageAdd(event,index,type){

         modal=document.getElementById(`cropimage-${type}`);
        const  result = document.querySelector(`.result-upload-${type}`);

        indexImage=index;

        imageInput=event.target;
        console.log(indexImage,event,imageInput.id);
         file = imageInput.files[0];
        const reader = new FileReader();
        modal.classList.remove('hidden');
        reader.onload = (event) => {
            const img = new Image();
            img.src = event.target.result;
            img.onload = () => {

                    result.innerHTML = '';
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    const canvasWidth = 640;
                const canvasHeight = 640;
                canvas.width = canvasWidth;
                canvas.height = canvasHeight;
                const finalAspectRatio = canvasWidth / canvasHeight;

                // Calculate the scaling to maintain aspect ratio
                const imgAspectRatio = img.width / img.height;
                let drawWidth, drawHeight, offsetX, offsetY;

                if (imgAspectRatio > finalAspectRatio) {
                    drawWidth = canvasWidth;
                    drawHeight = canvasWidth / imgAspectRatio;
                    offsetX = 0;
                    offsetY = (canvasHeight - drawHeight) / 2;
                } else {
                    drawWidth = canvasHeight * imgAspectRatio;
                    drawHeight = canvasHeight;
                    offsetX = (canvasWidth - drawWidth) / 2;
                    offsetY = 0;
                }
             context.drawImage(img, offsetX, offsetY, drawWidth, drawHeight);
                    result.appendChild(canvas);
                    cropper = new Cropper(canvas, {
                        dragMode: 'move',
                        aspectRatio: 1,
                        autoCropArea: 0.9,
                        restore: false,
                        guides: false,
                        center: false,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,

                        toggleDragModeOnDblclick: false,
                    });

            };
        };

        reader.readAsDataURL(file);

    }
     function cropimageadd(){
        image=document.getElementById(`answerimage-image${indexImage}`);
        console.log(image,indexImage);
        const canvas = cropper.getCroppedCanvas({
            width:300,
            height:300
            });
        const croppedImage = canvas.toDataURL('image/jpeg');

        image.src=croppedImage;
        @this.saveimage(croppedImage,indexImage);

        modal.classList.add('hidden');

     }
</script>

@endpush
