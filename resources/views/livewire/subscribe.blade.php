
<div>

<input type="hidden" id="dangerMessage" value="{{ session('danger') }}">

    {{-- buy responses --}}
    @if($action=="buyresponses"&&!$showCheckout)

    <div class=" grid justify-center items-center mt-6 ">
        <div class="grid justify-center items-center mb-10">
            <h1 class="font-bold text-lg text-center my-4">{{ __('main.getadditionalresponses') }}</h1>
            <h1 class="text-sm">{{ __('main.responsesvalid') }} <span class="text-secondary">{{ \Carbon\Carbon::parse($current_subscribe->expired_at)->subDays(1)->format('d m Y') }}</span></h1>
        </div>
        <div class="p-1 mt-4 mx-1 text-center">
            @if(!$validAddResponses)
            <span class="text-primary_red text-sm text-center">
           {{ __('main.responsesadderror') }}
            @elseif(!$current_subscribe->valid)
            <span class="text-primary_red text-sm text-center">
                {{ __('Your plan has been expired.') }}
            </span>
            @else
            <div class="relative flex justify-center items-center">
              <select wire:model="cateresponses" id="dropdown" name="dropdown" class="text-md width-1/2 rounded-lg block appearance-none  bg-white border border-gray-300 text-gray-700
               leading-tight focus:outline-none focus:border-gray-500 ">

               @foreach ($responsesCategories as $cat)

               @if($current_subscribe->num_of_responses+$cat->num<=$maxnumresponses&&$cat->price>0)
               <option class="text-md" value="{{$cat->id}}">{{ number_format($cat->num, 0, '.', ',') }}</option>
               @endif
               @endforeach

                <!-- Add more options as needed -->
              </select>
              <div class="pointer-events-none  inset-y-0 right-0 flex items-center px-2 text-gray-700">
                @php
                        $formattedPrice = number_format($priceresponses, 2);
                @endphp
                <span class="text-gray-900 mx-1">{{ __(' Price: ') }}</span>     <span class="text-lg text-secondary">{{$formattedPrice  }}<span class="text-xs text-gray-900">{{ __('AED') }}</span></span>
              </div>
            </div>

            @error('cateresponses') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror

            <div class="grid justify-center items-center mt-2">
                {{-- wire:click="buyresponses"  wire:click="buyresponses --}}
                <button wire:click="buyresponses"   class=" w-20 text-center justify-center
                mt-2 inline-flex items-center h-8 p-1 bg-secondary  border border-transparent
                rounded-md font-semibold text-xs text-white  uppercase tracking-widest hover:bg-secondary_1  focus:bg-secondary_1
                 active:bg-gray-900  focus:outline-none
                 transition ease-in-out duration-150">
                    {{ __('main.buy') }}
               </button>

            </div>
            @endif

        </div>
    </div>
    {{-- plans --}}
    @elseif($action!="buyresponses"&&!$showCheckout)
    <div class="  mt-6 ">

        <div class="grid justify-center items-center mb-10">

        <h1 class="font-bold text-lg text-center my-4">{{ __('main.upgradeaccount_title') }}</h1>
        <h1 class="text-sm">{{ __('main.upgradeaccount_text') }}</h1>
        </div>
        <div class="flex justify-center xs:block gap-2 ">

            @foreach ($types as $type )
            {{-- PRO --}}
              {{-- {{ in_array($type->subscription_type,$subscriptionsUpgrade[$current_subscribe->type])?"":"opacity-50" }} --}}
            {{-- @if($type->subscription_type!="Free" && in_array($type->subscription_type,$subscriptionsUpgrade[$current_subscribe->type])) --}}
            {{-- relative transition ease-in-out delay-150 -translate-z-1 scale-110 duration-300 --}}
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
                    <div class="grid  text-center mt-2 items-center">
                        @if($type->order_plan==1)
                        <div><span class="text-lg font-bold text-secondary_1">{{ $type->price }}</span><span class="text-xs">{{ __('AED') }}</span></div>
                        @else
                        <div><span class="text-lg font-bold text-secondary_1">{{ round((($type->price)+($priceresponses))) }}</span><span class="text-xs">{{ __('AED') }}</span><span class="text-sm text-secondary_1">{{ __(' / Year') }}</span></div>
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
                                <span class="text-md whitespace-normal" >{{ __('main.getupresponses',['num'=>number_format($type->num_responses, 0, '.', ',')]) }}</span>
                            </li>
                        @else
                            <li class="flex  mt-[2px]   ">

                                <x-subscriptionfeature_svg :colorid="0" />
                                <span class="text-md whitespace-normal" >{{ __('main.getflexableresponses') }}</span>
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
                    @if($type->subscription_type!="Free")
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
                    @endif
                    </ul>


                    {{-- buy button --}}
                    <div class="flex justify-center items-center mt-4 ">
                        {{-- current plan --}}
                        @if($type->order_plan==$current_subscribe->order_plan&&$current_subscribe->subscription_status=="Valid")
                            <a href="{{ route('subscriptions') }}" class="bg-secondary hover:bg-secondary_1 text-white text-center text-md rounded-lg p-1 w-25 min-w-[100px]">
                                {{ __('main.view') }}
                            </a>
                        @elseif($type->order_plan==$current_subscribe->order_plan&&($current_subscribe->subscription_status=="Grace"||$current_subscribe->subscription_status=="Locked"))
                        <button wire:click="ChoosePlan({{ $type->id }})" class="bg-secondary hover:bg-secondary_1 text-white text-md rounded-lg p-1 w-25 min-w-[100px]">
                            {{ __('main.renew') }}
                        </button>


                        @elseif($type->order_plan>$current_subscribe->order_plan)
                            <button wire:click="ChoosePlan({{ $type->id }})" class="bg-secondary hover:bg-secondary_1 text-white text-md rounded-lg p-1 w-25 min-w-[100px]">
                                {{ __('main.upgrade') }}
                            </button>

                        @endif

                    </div>

            </div>
            {{-- @endif --}}

            @endforeach
        </div>

    </div>
    @endif
    {{-- payment --}}
    @if($showCheckout)
    <div class="flex justify-center xs:block mt-6">

        <aside class="w-1/2 xs:w-full">
            <article class="bg-white rounded-lg shadow-lg">
                <div class="p-5 ">




                    <div class="grid grid-cols-12  border-2 rounded-lg   p-2 bg-gray-100 border-gray-200 min-h-[150px] mb-4">

                        <div class="col-span-8 xs:col-span-12 sm:col-span-12 md:col-span-12">
                            @if($action=="buyresponses")
                                <h1 class="mt-2 ">{{ __('main.buy_responses',['num'=>number_format($numresponses, 0, '.', ',')]) }}</h1>
                                <h1 class="mt-2">{{ __('main.valid',['start'=>\Carbon\Carbon::now()->format('d m Y'),'end'=>\Carbon\Carbon::parse($current_subscribe->expired_at)->subDays(1)->format('d m Y')]) }}</h1>
                            @else
                               <h1 class="mt-2">{{ __('main.newplan',['num'=>number_format($numresponses, 0, '.', ',')]) }}</h1>
                                @if($choosenPlanInfo->id==$current_subscribe->plan_id)
                                <h1 class="mt-2">{{ __('main.valid',['start'=>\Carbon\Carbon::parse($current_subscribe->expired_at)->format('d m Y'),'end'=>\Carbon\Carbon::parse($current_subscribe->expired_at)->format('d m Y')]) }}

                                @else
                                <h1 class="mt-2">{{ __('main.valid',['start'=>\Carbon\Carbon::now()->format('d m Y'),'end'=>\Carbon\Carbon::now()->addyear()->subDays(1)->format('d m Y')]) }}

                                @endif
                            @endif
                        </div>

                        <div class="col-span-4 xs:col-span-12 sm:col-span-12 md:col-span-12">
                            @php
                            $formattedPrice = number_format($totalprice, 2);
                            $formattedVat = number_format($totalprice*0.05, 2);
                            $formattedTotalPrice = number_format($totalprice+(($totalprice)*0.05), 2);
                            @endphp
                            <div class="grid grid-cols-12 items-center justify-center">
                                <span class="col-span-4">{{ __('main.price') }}</span>
                                <span class="col-span-4 text-secondary_blue  mx-1 text-right">{{  $formattedPrice }}</span>
                                <span class="col-span-1 text-xs">AED</span>
                            </div>
                            <div class="grid grid-cols-12 items-center justify-center">
                                <span class="col-span-4">{{ __('main.vat') }}</span>
                                <span class="col-span-4 text-secondary_blue  mx-1 text-right">{{  $formattedVat }}</span>
                                <span class="col-span-1 text-xs">AED</span>
                            </div>
                            <div class="grid grid-cols-12 items-center justify-center">
                                <span class="col-span-4 font-bold">{{ __('main.total') }}</span>
                                <span class="col-span-4 text-secondary_blue font-bold  mx-1 text-right">{{  $formattedTotalPrice }}</span>
                                <span class="col-span-1 text-xs">AED</span>
                            </div>

                        </div>
                    </div>




                    <div class="tab-content">
                        <div class="px-46 tab-pane fade show active" id="nav-tab-card">
                            @foreach (['danger', 'success'] as $status)
                                @if(Session::has($status))
                                    <p class="alert alert-{{$status}}">{{ Session::get($status) }}</p>
                                @endif
                            @endforeach
                                 {{-- onsubmit="return submitForm()" --}}
                            <form  role="form" method="get" id="payment-form" action="{{ route('payment.create')}}">
                                @csrf
                                <input type="hidden" name="subscription_id" id="subscription_id" value="{{ $choosenPlan }}">
                                <input type="hidden" name="price" id="price" value="{{ $totalprice }}">
                                <input type="hidden" name="action" id="action" value="{{ $action }}">
                                <input type="hidden" name="desc" id="desc" value="{{ $desc }}">

                                <input type="hidden" name="cateresponses" id="cateresponses" value="{{ $cateresponses }}">

                                <div class="flex justify-between items-center border-t-[1px] p-2 mt-2 border-gray-200">
                                    @if(!$renew)
                                    <button wire:click="Back" class="justify-center  min-w-[100px] w-auto h-10 p-1  text-center
                                    inline-flex items-center px-4 py-2 bg-primary_red text-white  border-gray-300
                                     rounded-md font-semibold text-xs   uppercase tracking-widest shadow-sm
                                       disabled:opacity-25 transition ease-in-out duration-150 ml-2
                                    " type="button">{{ __('main.back') }} </button>
                                    @endif


                                    <button id="submitButton" class="justify-center min-w-[100px] w-auto h-10 p-1 text-center
                                    inline-flex items-center px-4 py-2 bg-secondary
                                    border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                                    active:bg-gray-900  disabled:opacity-25 transition
                                    " type="submit"> {{ __('main.placeorder') }} </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </article>
            <div class=" hidden  p-1 mt-4  justify-center items-center" id="TextAfterSubmit">
                <h1 class="text-center" >{{ __('main.pleasewait')}}</h1>
                <h1 class="text-center" >{{ __('main.pleasewait_message') }}</h1>
            </div>
        </aside>

    </div>

    @endif
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

// document.addEventListener('DOMContentLoaded', function () {
//   const form = document.getElementById('paymentForm');
//   const submitButton = document.getElementById('submitButton');

//   form.addEventListener('submit', function (event) {
//     // Prevent the default form submission behavior
//     event.preventDefault();

//     // Disable the submit button
//     submitButton.disabled = true;

//   });
// });
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

