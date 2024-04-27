
<div>

<input type="hidden" id="dangerMessage" value="{{ session('danger') }}">


    {{-- plans --}}
    {{-- @if($step==1) --}}
    <div class="  mt-6 ">

        <div class="grid justify-center items-center mb-10">

        <h1 class="font-bold text-lg text-center my-4">{{ __('main.upgradeaccount_title') }}</h1>
        <h1 class="text-sm">{{ __('main.upgradeaccount_text') }}</h1>
        </div>
        <div class="flex justify-center xs:block gap-2 ">

            @foreach ($types as $type )

            <div  class="{{$type->subscription_type==$current_subscribe->type?"z-50 shadow relative bg-primary border-[2px] border-secondary ":"bg-[#fafafa] border-[1px]"  }} col-span-2 xs:mt-2   shadow-md rounded-2xl p-4  ">
                    {{-- current subscribe  --}}

                    @if($type->subscription_type==$current_subscribe->type)
                    <div class="flex justify-center items-center  absolute w-full top-[-14px] right-0 ">
                      <h1 class="text-sm bg-primary border-[1px] border-secondary text-center p-1 rounded-lg text-secondary"> {{ __('main.currentplan') }}</h1>

                    </div>
                    @endif
                    {{-- type --}}
                    <div class="flex justify-center items-center mt-4">
                    <span class="text-secondary text-xl font-bold">{{ $type->subscription_type }}</span>
                    </div>
                    {{-- price --}}
                    <div class="grid  text-center mt-2 items-center text-3xl xs:text-lg font-bold text-secondary_1">
                        @if($type->order_plan==1)
                        <div><span class= "">{{ $type->price }}</span><span class="text-xs">{{ __('AED') }}</span></div>
                        @else
                        <div><span class="">{{ round($type->price) }}</span><span class="text-xs">{{ __('AED') }}</span><span class="text-sm text-secondary_1">{{ __(' / Year') }}</span></div>
                        @endif
                    </div>
                    {{-- features --}}
                    <ul style="height:370px" class="mt-8 ">
                      {{--  num of forms --}}
                        <li class="flex  mt-[2px] ">
                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">


                            <x-subscriptionfeature_svg :colorid="0" />
                           <span class="text-md whitespace-normal " >{{ __('main.createuptodoforms',['num'=>$type->num_forms]) }}</span>
                        </li>
                        {{--  num of kiosks --}}
                        <li class="flex  mt-[2px] ">
                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">

                            <x-subscriptionfeature_svg :colorid="0" />
                           <span class="text-md whitespace-normal" >{{ __('main.connectuptokiosks',['num'=>$type->num_kiosks]) }}</span>
                        </li>
                        {{--  num of responses --}}
                        @if($type->subscription_type=="Free")
                            <li class="flex  mt-[2px]   ">

                                <x-subscriptionfeature_svg :colorid="0" />
                                <span class="text-md whitespace-normal" >{{ __('main.getupresponses',['num'=>env('NUM_OF_RESPONSES_FREE',500)]) }}</span>
                            </li>
                        @else
                            <li class="flex  mt-[2px]   ">

                                <x-subscriptionfeature_svg :colorid="0" />
                                <span class="text-md whitespace-normal" >{{ __('main.getflexableresponses',['num'=>env('NUM_OF_RESPONSES_PREMIUM',30000),'max'=>$type->num_responses]) }}</span>
                            </li>
                        @endif
                        {{--  num of questions --}}
                        <li class="flex   mt-[2px] ">

                            <x-subscriptionfeature_svg :colorid="0" />
                            <span class="text-md whitespace-normal " >{{ __('main.addquestionsperform',['num'=>$type->num_questions]) }}</span>
                        </li>
                        {{-- Multi-languages form --}}
                        @if($type->multi_languages)

                            <li class="flex mt-[2px] ">
                                <x-subscriptionfeature_svg :colorid="0" />
                               <span class="text-md whitespace-normal" >{{ __('main.multilangaugeform') }}</span>
                            </li>
                        @endif
                        {{--Professional dashboard & statistics --}}
                        @if($type->professional_dashboard_statistics)

                            <li class="flex mt-[2px] ">
                                <x-subscriptionfeature_svg :colorid="0" />
                               <span class="text-md whitespace-normal" >{{ __('main.professionaldash') }}</span>
                            </li>
                        @endif
                        {{-- Use pro question types --}}
                        @if($type->pro_questions)

                            <li class="flex mt-[2px] ">
                                <x-subscriptionfeature_svg :colorid="0" />
                               <span class="text-md whitespace-normal" >{{ __('main.useproquestions') }}</span>
                            </li>
                        @endif
                        {{-- Custom form logo --}}
                        @if($type->custom_form)

                            <li class="flex mt-[2px] ">
                                <x-subscriptionfeature_svg :colorid="1" />
                                 <span class="text-md whitespace-normal" >{{ __('main.customformlogo') }}</span>
                            </li>
                        @endif
                        {{--Add form terms agreement --}}
                        @if($type->form_terms)

                            <li class="flex mt-[2px] ">
                                <x-subscriptionfeature_svg :colorid="1" />

                                <span class="text-md whitespace-normal" >{{ __('main.addtermsagreement') }}</span>
                            </li>
                        @endif
                         {{--Add  account members --}}
                        @if($type->team_members)
                            <li class="flex mt-[2px]">
                                <x-subscriptionfeature_svg :colorid="1" />

                                 <span class="text-md whitespace-normal" >{{ __('main.addupaccountmembers',['num'=>5]) }}</span>
                            </li>
                        @endif
                        {{-- Access to To-Do manager --}}
                        @if($type->todo)

                            <li class="flex mt-[2px] ">
                                <x-subscriptionfeature_svg :colorid="1" />

                           <span class="text-md whitespace-normal" >{{ __('main.accesstodomanager') }}</span>
                            </li>
                        @endif
                         {{-- Sign pdf --}}
                         @if($type->signpdf)

                         <li class="flex mt-[2px] ">
                            <x-subscriptionfeature_svg :colorid="1" />

                        <span class="text-md whitespace-normal" >{{ __('main.signpdf') }}</span>
                         </li>
                     @endif
                          {{-- Export statistics & responses reports--}}
                        @if($type->export)

                            <li class="flex mt-[2px] ">
                                <x-subscriptionfeature_svg :colorid="1" />

                                <span class="text-md whitespace-normal" >{{ __('main.exportstatistics') }}</span>
                            </li>
                        @endif
                        {{-- select num of responses --}}
                    {{-- @if($type->subscription_type!="Free")
                    <div class="p-1 mt-4 mx-1">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="dropdown">
                         {{ __('main.selectnumofresponses') }}
                        </label>
                        <div class="relative">
                          <select wire:model="cateresponses" id="dropdown" name="dropdown" class="text-md width-1/2 rounded-lg block appearance-none  bg-white border border-gray-300 text-gray-700
                           leading-tight focus:outline-none focus:border-gray-500 ">

                           @foreach ($responsesCategories as $cat  )

                           <option class="text-md" value="{{$cat->id}}">{{ number_format($cat->num, 0, '.', ',') }}</option>

                           @endforeach

                            <!-- Add more options as needed -->
                          </select>

                        </div>
                        @error('cateresponses') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror

                    </div>
                    @endif --}}
                    </ul>


                    {{-- buy button --}}
                    <div class="flex justify-center items-center mt-4 ">
                        {{-- current plan --}}
                        @if($type->order_plan==$current_subscribe->order_plan&&$current_subscribe->subscription_status=="Valid")
                            <a href="{{ route('subscriptions') }}"
                            class="bg-secondary hover:bg-secondary_1 text-white flex justify-center items-center text-center text-md rounded-lg p-1 w-25 min-w-[100px] h-12">
                                {{ __('main.view') }}
                            </a>
                        @elseif($type->order_plan==$current_subscribe->order_plan&&($current_subscribe->subscription_status=="Grace"||$current_subscribe->subscription_status=="Locked"))
                        <button wire:click="ChoosePlan({{ $type->id }})"
                            class="bg-secondary hover:bg-secondary_1 text-white text-md rounded-lg p-1 w-25 h-12 min-w-[100px]">
                            {{ __('main.renew') }}
                        </button>


                        @elseif($type->order_plan>$current_subscribe->order_plan)
                            <button wire:click="ChoosePlan({{ $type->id }})"
                                class="bg-secondary hover:bg-secondary_1 text-white text-md rounded-lg p-1 w-25 h-12 min-w-[100px]">
                                {{ __('main.upgrade') }}
                            </button>

                        @endif

                    </div>

            </div>
            {{-- @endif --}}

            @endforeach
        </div>

    </div>
    {{-- @elseif($step==2)
    <div class=" grid justify-center items-center mt-6 ">
        <div class="grid justify-center items-center mb-10">
            <h1 class="font-bold text-lg text-center my-4">{{ __('Select  Responses Category') }}</h1>
            <h1 class="text-center ">
                {!! nl2br(e(__('main.responses_text'))) !!}
            </h1>
        </div>
    <x-buy-responses :action="$action" :choosenCategory="$choosenCategory" :validAddResponses="$validAddResponses" :maxnumresponses="$maxnumresponses"  :responsesCategories="$responsesCategories" :currentsubscribe="$current_subscribe" />
    </div>
    @endif --}}


</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    //  warning downgrade
    window.addEventListener('show-payment-warning', event => {
         Swal.fire({
            icon: 'error',
            title: 'Oops...Something went wrong!',
            text: event.detail.error,

            })
    });
</script>
<script>
    var dangerMessage = document.getElementById('dangerMessage').value;
    if (dangerMessage) {
   Swal.fire({

   icon: 'error',

   title:'Payment Failed!',
   text:dangerMessage,
   confirmButtonColor:'#1277D1',
   })
}

</script>
<script>


function initBuy() {


    try {
            value=document.querySelector('input[name="category_responses"]:checked').value;
         if(value)
        Livewire.emit('nextStep', value);
        } catch (error) {
            document.getElementById('error').innerHTML = 'Please choose category';


        }

     }

let formSubmitted = false;
function submitForm(){
  const form = document.getElementById('paymentForm');
  const submitButton = document.getElementById('submitButton');
   submitButton.disabled=true;
   formSubmitted = true;
    document.getElementById('TextAfterSubmit').classList.remove('hidden');
    document.getElementById('TextAfterSubmit').classList.add('grid');
   submitButton.innerHTML=`<svg class="w-4 h-4 animate-spin text-secondary_1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" d="M0 0h24v24H0z" />
                <path d="M12 2a10 10 0 0 1 10 10h-2a8 8 0 0 0-8-8V2z" />
            </svg>`;
//    form.submit();
}

// window.addEventListener('beforeunload', function (event) {
//   // Check if the form has been submitted
//   if (!formSubmitted) {
//     // Display a confirmation message to the user
//     event.returnValue = 'Are you sure you want to leave the page? Your form data may not be saved.';
//   }
// });




</script>
@endpush

