@push('styles')
    <style>
        .swal2-confirm {
  @apply bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded;
}

.swal2-cancel {
  @apply bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded;
}
    </style>
@endpush
<div class="" >
    <div id="translations" data-translations="{{ json_encode(__('main')) }}"></div>

    <input type="hidden" id="flashedMessage" value="{{ session('message') }}">
    <input type="hidden" id="error_role" value="{{ session('error') }}">


    {{-- Liecence --}}
     <div class="border-[1px] border-gray-100 shadow rounded-[0.5rem] mb-10 mt-6 p-4 xs:p-2 bg-white">

       <div class="border-[1px] bg-primary  border-secondary flex justify-center items-center rounded-[0.5rem] w-36  p-1 ml-4 relative top-[-32px]">
        <span class=" text-secondary mr-1 ml-1">{{ $current_subscribe->type  }}</span>
            @if($current_subscribe->type=="Free")
            <x-subscriptionfeature_svg :colorid="0" />

            @else
            <x-subscriptionfeature_svg :colorid="1" />

            @endif
       </div>
        <div class="flex space-x-1 xs:block">
            {{-- lecinece info --}}
            <div class="p-2  xs:mb-2">
                <span>{{ __('main.yoursubscription') }}<span class="text-secondary  font-bold">{{$current_subscribe->type}}</span>  </span>
            <br><span class="whitespace-nowrap">{{ __('main.duedate') }}
                <span class="text-secondary  font-bold">{{ \Carbon\Carbon::parse($current_subscribe->expired_at)->addDay()->format('d m Y') }} </span>

                @if($current_subscribe['subscription_status']=="Valid")
                <span class="text-sm text-valid">({{ __('main.active_status') }})</span>
                @elseif($current_subscribe['subscription_status']=="Grace")
                <span class="text-sm text-primary_red">({{ __('main.expiredgrace_status') }})</span>
                @elseif($current_subscribe['subscription_status']=="Locked")
                <span class="text-sm text-primary_red">({{ __('main.expiredlocked_status') }})</span>



                @endif
            </span>
            </div>
            {{-- buttons options --}}
            <div class=" flex h-12 xs:mx-1 xs:flex xs:mt-2 xs:mb-2 xs:justify-between xs:items-center top-[4px] p-2 relative ">
                {{-- first button --}}
                @if($current_subscribe->order_plan!=1)
                           {{-- href="{{ route('subscribe',['renew',$current_subscribe->plan_id]) }}" --}}
                    <a wire:click="renewCheck({{ $current_subscribe->plan_id }})"   target="_blank" class=" cursor-pointer
                        mt-2 inline-flex items-center h-8 p-1 bg-secondary  border border-transparent
                        rounded-md font-semibold text-xs text-white  uppercase tracking-widest
                         hover:bg-secondary_1  focus:bg-secondary_1
                           focus:outline-none
                         transition ease-in-out duration-sw150">
                        {{ __('main.renew') }}
                    </a>
                @else
                    <a href="{{ route('subscribe') }}" target="_blank" class="
                        mt-2 inline-flex items-center h-8 p-1 bg-secondary border border-transparent
                        rounded-md font-semibold text-xs text-white  uppercase tracking-widest hover:bg-secondary_1  focus:bg-secondary_1
                         active:bg-gray-900  focus:outline-none
                         transition ease-in-out duration-150">
                            {{ __('main.upgrade') }}
                    </a>
                @endif
                {{-- second: the list of options --}}
                @if($current_subscribe->order_plan!=1)
                <div class="p-2">
                    <button id="dropdownRadioButton1" data-dropdown-toggle="listadd" class=" text-white
                    font-medium  text-sm px-1 py-1   focus:outline-none
                    text-center justify-center flex items-center "
                    type="button">
                        <span class="text-center text-lg">
                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">

                            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                            <svg fill="currentColor" class="w-6 h-6 hover:cursor-pointer text-svg_primary hover:text-secondary_blue" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 460.054 460.054" xml:space="preserve">

                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                            <g id="SVGRepo_iconCarrier"> <g> <g> <path d="M40.003,69.679C17.914,69.679,0,87.592,0,109.697c0,22.089,17.914,39.987,40.003,39.987 c22.089,0,40.003-17.898,40.003-39.987C80.006,87.592,62.092,69.679,40.003,69.679z"/> </g> <g> <path d="M40.003,190.032C17.914,190.032,0,207.93,0,230.035c0,22.089,17.914,40.002,40.003,40.002 c22.089,0,40.003-17.913,40.003-40.002C80.006,207.93,62.092,190.032,40.003,190.032z"/> </g> <g> <path d="M40.003,310.37C17.914,310.37,0,328.283,0,350.372c0,22.089,17.914,40.003,40.003,40.003 c22.089,0,40.003-17.914,40.003-40.003C80.006,328.283,62.092,310.37,40.003,310.37z"/> </g> <g> <path d="M429.973,79.601H145.419c-16.611,0-30.081,13.47-30.081,30.096c0,16.612,13.469,30.081,30.081,30.081h284.554 c16.61,0,30.081-13.469,30.081-30.081C460.054,93.071,446.583,79.601,429.973,79.601z"/> </g> <g> <path d="M429.973,199.939H145.419c-16.611,0-30.081,13.469-30.081,30.096c0,16.612,13.469,30.081,30.081,30.081h284.554 c16.61,0,30.081-13.469,30.081-30.081C460.054,213.408,446.583,199.939,429.973,199.939z"/> </g> <g> <path d="M429.973,320.291H145.419c-16.611,0-30.081,13.469-30.081,30.081c0,16.611,13.469,30.08,30.081,30.08h284.554 c16.61,0,30.081-13.469,30.081-30.08C460.054,333.759,446.583,320.291,429.973,320.291z"/> </g> </g> </g>

                            </svg>
                        </span>
                    </button>
                    <div id="listadd" class="z-20 hidden w-auto bg-white divide-y divide-gray-100 rounded-[0.5rem]   ">
                        <ul class="p-1 space-y-1 text-sm text-gray-700  border-[1px] rounded-[0.5rem] border-gray-200" aria-labelledby="dropdownRadioButton1">
                            @if($current_subscribe->valid)
                            <li  class=" hover:cursor-pointer pt-2 rounded-[0.5rem]">
                                    <a href="{{ route('subscribe','buyresponses') }}" target="_blank" class="block hover:font-bold text-center w-full xs:text-xs  rounded-lg   text-black hover:text-secondary_blue  p-[2px] hover:cursor-pointer hover:no-underline">
                                        <span class="text-center w-full"> {{ __('main.getmoreresponses') }}</span>
                                    </a>
                            </li>
                            @endif

                            {{-- cancel --}}
                            <li  class=" hover:cursor-pointer pt-1 rounded-[0.5rem]">
                                    <a wire:click="cancel()" class="block hover:font-bold text-center w-full xs:text-xs  rounded-lg   text-black hover:text-secondary_blue  p-[2px] hover:cursor-pointer hover:no-underline">
                                        <span class="text-center w-full ">   {{ __('main.cancelsubscription') }}</span>
                                    </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @endif


            </div>
        </div>
          {{--features  --}}
        <ul class=" mt-10 p-2 w-1/2 sm:w-full xs:w-full">
            {{-- num of forms --}}
            <li class="flex space-x-1 mt-1 ">
             {{-- feature --}}
             <div class="xs:text-xs grid grid-cols-4 rounded-lg px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300" >
                <div class="col-span-3 min-w-[310px] max-w-[310px]">
                  <span>{{ __('main.maxnum_forms')}}</span>
                </div>
                <div class="col-span-1 rounded-lg text-center ">

                    <span class="font-bold">{{ $current_subscribe->num_forms }}</span>

                </div>

             </div>


            </li>
            {{-- num of questions --}}
            <li class="flex space-x-1 mt-1">
                {{-- feature --}}
                <div class="xs:text-xs grid grid-cols-4 rounded-lg px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300" >
                    <div class="col-span-3 min-w-[310px] max-w-[310px] ">
                      <span>{{ __('main.maxnum_questions')}}</span>
                    </div>
                    <div class="col-span-1 text-center rounded-lg ">

                        <span class="font-bold">{{ $current_subscribe->num_questions }}</span>

                    </div>

                </div>



            </li>
            {{-- num of kiosks --}}
            <li class="flex space-x-1 mt-1">
                {{-- feature --}}
                <div class="xs:text-xs grid grid-cols-4 rounded-lg px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300" >
                    <div class="col-span-3 min-w-[310px] max-w-[310px] ">
                      <span>{{ __('main.maxnum_kiosks')}}</span>
                    </div>
                    <div class="col-span-1 text-center rounded-lg ">

                        <span class="font-bold">{{ $current_subscribe->num_kiosks }}</span>

                    </div>

                </div>



            </li>
            {{-- num of responses --}}
            <li class="flex space-x-1 mt-1">
                {{-- feature --}}

                <div class="xs:text-xs grid grid-cols-4 rounded-[0.5rem] px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300" >
                    @if($current_subscribe->order_plan==1)
                    <div class="col-span-3 min-w-[310px] max-w-[310px] ">
                        <span>{{ __('main.maxnum_respponses')}}</span>
                    </div>
                    <div class="col-span-1 text-center rounded-[0.5rem] ">
                        <span class="font-bold"> {{ number_format($current_subscribe->num_responses, 0, '.', ',') }}</span>
                    </div>
                    @else
                    <div class="col-span-3 min-w-[310px] max-w-[310px]">
                        <span>{{ __('main.responsesmount')}}</span>
                    </div>
                    <div class="col-span-1 text-center rounded-[0.5rem] ">
                        <span class="font-bold"> {{ __('100,000') }}</span>
                    </div>
                    @endif
                </div>

            </li>

            {{-- Multi-languages form --}}
            <li class="flex space-x-1 mt-1">
                {{-- feature --}}
                <div class="xs:text-xs grid grid-cols-4 rounded-[0.5rem] px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300" >
                    <div class="col-span-3 min-w-[310px] max-w-[310px] ">
                      <span>{{ __('main.multilanguages')}}</span>
                    </div>
                    <div class="col-span-1 text-center rounded-[0.5rem] ">
                    @if($current_subscribe->multi_languages)
                        <span class="font-bold text-valid">{{ __('✔') }}</span>
                    @else
                        <span class="font-bold text-primary_red">{{ __('✘') }}</span>
                    @endif
                    </div>

                </div>



            </li>
            {{-- Professional dashboard & statistics --}}
            <li class="flex space-x-1 mt-1">
                {{-- feature --}}
                <div class="xs:text-xs grid grid-cols-4 rounded-[0.5rem] px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300" >
                    <div class="col-span-3 min-w-[310px] max-w-[310px] ">
                      <span>{{ __('main.professionaldash')}}</span>
                    </div>
                    <div class="col-span-1 text-center rounded-[0.5rem] ">
                        @if($current_subscribe->professional_dashboard_statistics)
                        <span class="font-bold text-valid">{{ __('✔') }}</span>
                    @else
                        <span class="font-bold text-primary_red">{{ __('✘') }}</span>
                    @endif
                    </div>

                </div>



            </li>
            {{-- Pro question types --}}
            <li class="flex space-x-1 mt-1">
                {{-- feature --}}
                <div class="xs:text-xs grid grid-cols-4 rounded-[0.5rem] px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300" >
                    <div class="col-span-3 min-w-[310px] max-w-[310px] ">
                      <span>{{ __('main.proquestion_types')}}</span>
                    </div>
                    <div class="col-span-1 text-center rounded-[0.5rem] ">
                        @if($current_subscribe->pro_questions)
                        <span class="font-bold text-valid">{{ __('✔') }}</span>
                    @else
                        <span class="font-bold text-primary_red">{{ __('✘') }}</span>
                    @endif
                    </div>

                </div>



            </li>
            {{-- Custom form logo--}}
            <li class="flex space-x-1 mt-1">
                {{-- feature --}}
                <div class="xs:text-xs grid grid-cols-4 rounded-[0.5rem] px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300" >
                    <div class="col-span-3 min-w-[310px] max-w-[310px]">
                      <span>{{ __('main.customformlogo')}}</span>
                    </div>
                    <div class="col-span-1 text-center rounded-[0.5rem]">
                        @if($current_subscribe->custom_form)
                            <span class="font-bold text-valid">{{ __('✔') }}</span>
                        @else
                            <span class="font-bold text-primary_red">{{ __('✘') }}</span>
                        @endif
                    </div>

                </div>
            </li>
             {{-- form terms agreement: --}}
            <li class="flex space-x-1 mt-1">
                {{-- feature --}}
                <div class="xs:text-xs grid grid-cols-4 rounded-[0.5rem] px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300" >
                    <div class="col-span-3 min-w-[310px] max-w-[310px] ">
                      <span>{{ __('main.formsterms')}}</span>
                    </div>
                    <div class="col-span-1 text-center rounded-[0.5rem] ">
                        @if($current_subscribe->form_terms)
                        <span class="font-bold text-valid">{{ __('✔') }}</span>
                    @else
                        <span class="font-bold text-primary_red">{{ __('✘') }}</span>
                    @endif
                    </div>

                </div>



            </li>
            {{-- Add accountteam member: --}}
            <li class="flex space-x-1 mt-1">
                {{-- feature --}}
                <div class="xs:text-xs grid grid-cols-4 rounded-[0.5rem] px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300" >
                    <div class="col-span-3 min-w-[310px] max-w-[310px] ">
                      <span>{{ __('main.addaccountmember')}}</span>
                    </div>
                    <div class="col-span-1 text-center rounded-[0.5rem] ">
                        @if($current_subscribe->account_members>0)
                        <span class="font-bold text-valid">{{ __($current_subscribe->account_members) }}</span>
                        @else
                            <span class="font-bold text-primary_red">{{ __('✘') }}</span>
                        @endif
                    </div>

                </div>


            </li>
            {{-- To-Do manager --}}
            <li class="flex space-x-1 mt-1 ">
                {{-- feature --}}

                <div class="xs:text-xs grid grid-cols-4 rounded-[0.5rem] px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300 " >
                    <div class="col-span-3 min-w-[310px] max-w-[310px] ">
                      <span>{{ __('main.todomanager')}} </span>
                    </div>
                    <div class="col-span-1 text-center rounded-[0.5rem] ">
                        @if($current_subscribe->todo)
                            <span class="font-bold text-valid">{{ __('✔') }}</span>
                        @else
                            <span class="font-bold text-primary_red">{{ __('✘') }}</span>
                        @endif
                    </div>

                </div>


            </li>
            {{-- Sign pdf manager --}}
            <li class="flex space-x-1 mt-1 ">
                {{-- feature --}}

                <div class="xs:text-xs grid grid-cols-4 rounded-[0.5rem] px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300 " >
                    <div class="col-span-3 min-w-[310px] max-w-[310px] ">
                      <span>{{ __('main.signpdf')}} </span>
                    </div>
                    <div class="col-span-1 text-center rounded-[0.5rem] ">
                        @if($current_subscribe->signpdf)
                            <span class="font-bold text-valid">{{ __('✔') }}</span>
                        @else
                            <span class="font-bold text-primary_red">{{ __('✘') }}</span>
                        @endif
                    </div>

                </div>


            </li>
            {{-- Export statistics & responses reports --}}
            <li class="flex space-x-1 mt-1">
                {{-- feature --}}

                <div class="xs:text-xs grid grid-cols-4 rounded-[0.5rem] px-4 py-1 bg-primary transition ease-in-out delay-150  hover:-translate-y-1 hover:scale-110  hover:shadow uration-300" >
                    <div class="col-span-3 min-w-[310px] max-w-[310px] ">
                      <span>{{ __('main.exportstatistics')}}</span>
                    </div>
                    <div class="col-span-1 text-center rounded-[0.5rem] ">
                        @if($current_subscribe->export)
                                <span class="font-bold text-valid">{{ __('✔') }}</span>
                        @else
                                <span class="font-bold text-primary_red">{{ __('✘') }}</span>
                        @endif
                    </div>

                </div>


            </li>
        </ul>
        {{-- progress bar --}}
           <div class=" mt-24 p-2 w-1/2 xs:w-full">
                <div class="flex text-sm xs:text-xs justify-between items-center">
                    @php
                        $start_date = \Carbon\Carbon::parse($current_subscribe->start_date)->format('d m Y');
                    @endphp
                    <span>{{ $start_date }}</span>
                    <span>{{ \Carbon\Carbon::parse($current_subscribe->expired_at)->format('d m Y') }}</span>
                </div>
                <div class="w-full bg-neutral-200  rounded-[0.5rem]">

                    <div
                    class=" {{$progressbarValue>90?" animate-pulse bg-primary_red":"bg-secondary"  }} p-1 text-center text-xs font-medium leading-none text-primary-100 rounded-[0.5rem] "
                    style="width: {{ $progressbarValue }}%">
                    {{ $progressbarValue }}%
                    </div>
                </div>
                {{-- num of responses --}}
                <div class="mt-2 text-sm xs:text-xs">
                    <h1 class="whitespace-nowrap">{{ __('main.avilableresponses') }}
                        <span class="mx-[1px] text-secondary">{{ number_format($current_subscribe->num_of_responses, 0, '.', ',') }}</span>
                     @if($current_subscribe['subscription_status']=="Valid")
                    <span class="text-sm text-valid">({{ __('main.active_status') }})</span>
                    @elseif($current_subscribe['subscription_status']=="Grace")
                    <span class="text-sm text-primary_red">({{ __('main.expiredgrace_status') }})</span>
                    @elseif($current_subscribe['subscription_status']=="Locked")
                    <span class="text-sm text-primary_red">({{ __('main.expiredlocked_status') }})</span>
                    @endif
                    </h1>
                </div>
          </div>


    </div>
    {{-- plans --}}




</div>
@push('scripts')
<script src="{{ asset('js/sweetalert.min.js') }}"></script>


<script>
//    var translationsElement = document.getElementById('translations');
//    var translations = JSON.parse(translationsElement.getAttribute('data-translations'));
   var translations = @json(__('main'));

     var flashedMessage = document.getElementById('flashedMessage').value;
     var error_role=document.getElementById('error_role').value;
     if (flashedMessage) {
        Swal.fire({
        icon: 'success',
        title:translations.paymentsuccess,
        text:flashedMessage,
        confirmButtonColor:'#1277D1',
     })}
     if(error_role)showRoleWarning();
   function showRoleWarning(){
    Swal.fire({
            icon: 'error',
            title:translations.errorpermission.replace(':error_role', errorRole),
            confirmButtonColor:'#f3f4f6',
            confirmButtonText:`<h5 style='color:000000;border:0;box-shadow: none;'>${translations.ok}</h5>`,
            text:' ',

            })
   }
</script>

<script src="https://js.stripe.com/v3/"></script>
<style>
    .swal2-popup .swal2-styled:focus {
    box-shadow: none !important;
}
</style>
<script>
    window.addEventListener('show-role-warning', event => {
        showRoleWarning();
    });
     window.addEventListener('show-cancel-warning', event => {
        (async () => {

            const { value: accept } = await Swal.fire({
            text:translations.cancelsubscriptionalarm,
            input: 'checkbox',
            inputValue: 0,
            icon:'question',
            confirmButtonColor:'#dc2626',
            cancelButtonColor:'#f3f4f6',
            cancelButtonText:`<h5 style='color:000000'>${translations.back_button}</h5>`,
            showCancelButton: true,
            css: {
            cancelButton: 'color: orange;', // Example: Change confirm button text color to orange
             },
            inputPlaceholder:
                translations.cancelsubscriptionalarm_suremessage,
            confirmButtonText:
                translations.cancelsubscription_button,
            inputValidator: (result) => {
                return !result && translations.checkboxrequired;
            }
            })
            if (accept) {
                Livewire.emit('canceled');
            }

        })()
    });

     //  warning renew
     window.addEventListener('show-renew-warning', event => {

         Swal.fire({
            icon: 'error',
            title:translations.renewdisablemessage_title,
            confirmButtonColor:'#f3f4f6',
            confirmButtonText:`<h5 style='color:000000;border:0;box-shadow: none;'>${translations.close}</h5>`,
            text:translations.renewdisablemessage,

            })
    });
</script>

@endpush

