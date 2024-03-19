@push('styles')
<link
  rel="stylesheet"
  href="{{ asset('/styles/index.min.css') }}" />
  <link  rel="stylesheet" href="{{ asset('styles/bootstrap.min.css')}}">


@endpush
<div wire:loading.class="disabled opacity-50 "   >
    <input type="hidden" id="flashedMessage" value="{{ session('error_message') }}">

    @if ($accountStatus['status']=='Locked')

    <x-lockedaccount/>

    @endif
    <div  class="{{ $accountStatus['status']=='Locked'?"pointer-events-none opacity-50":"" }} grid grid-rows-12  overflow-hidden mt-2 ">

        <div class="w-full  mb-2 flex justify-between items-center p-2 pl-4 bg-white drop-shadow max-h-[18vh]     rounded-[0.5rem] " >
            {{-- add form --}}
            <button type="button" wire:click="$emit('add_form',{{ json_encode($main_languages)}},{{ json_encode($messages)}})"  data-toggle="modal"
            data-target="#addform" class="bg-secondary_blue rounded xs:p-1   xs:h-10 xs:w-[80px]   p-2 h-16   w-[100px] hover:cursor-pointer
            ease-in delay-100  hover:-translate-z-1 hover:scale-[1.1]  duration-200 xs:my-2   xs:flex xs:justify-between xs:items-center ">
                <div class="flex justify-center items-center">

                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                    <svg
                    class="w-6 h-6"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C2.34315 2 1 3.34315 1 5V9V10V19C1 20.6569 2.34315 22 4 22H12C12.5523 22 13 21.5523 13 21C13 20.4477 12.5523 20 12 20H4C3.44772 20 3 19.5523 3 19V10V9C3 8.44772 3.44772 8 4 8H11.7808H13.5H20.1C20.5971 8 21 8.40294 21 8.9V9C21 9.55228 21.4477 10 22 10C22.5523 10 23 9.55228 23 9V8.9C23 7.29837 21.7016 6 20.1 6H13.5H11.7808L11.3489 4.27239C11.015 2.93689 9.81505 2 8.43845 2H4ZM4 6C3.64936 6 3.31278 6.06015 3 6.17071V5C3 4.44772 3.44772 4 4 4H8.43845C8.89732 4 9.2973 4.3123 9.40859 4.75746L9.71922 6H4ZM20 13C20 12.4477 19.5523 12 19 12C18.4477 12 18 12.4477 18 13V16H15C14.4477 16 14 16.4477 14 17C14 17.5523 14.4477 18 15 18H18V21C18 21.5523 18.4477 22 19 22C19.5523 22 20 21.5523 20 21V18H23C23.5523 18 24 17.5523 24 17C24 16.4477 23.5523 16 23 16H20V13Z" fill="#ffffff"/> </g>
                    </svg>
                </div>
                <div class="flex justify-center">
                    <span class="mt-1 text-white text-sm xs:text-xs">{{ __('main.createform') }}</span>
                </div>
            </button>



            {{--  forms info --}}
            {{-- {{ $current_subscribe->num_forms-$totalforms==0?"bg-red-200 animate-pulse ":"bg-blue-200" }} --}}
            <div class="flex ">
                <div class="bg-primary_blue ml-2 mr-2 p-2  h-auto w-42 border-[1px] border-gray-300 rounded-[0.5rem] xs:p-1 xs-ml-1 xs:mr-1">
                    <x-total :title=" __('main.totalforms')" :total="$totalforms" :subscribenum="$this->current_subscribe->num_forms"  />
                    {{-- <div class=" text-sm xs:text-xs grid justify-start  items-center text-left ">
                        <span class=" mr-[2px]  ">{{ __('main.totalforms') }}</span>
                        <span class= "{{ $this->current_subscribe->num_forms<$totalforms?"text-primary_red font-bold":"text-secondary_blue" }}  text-md text-center">{{ $totalforms }}{{ __('/') }}{{ $this->current_subscribe->num_forms }}</span>
                    </div> --}}
                    {{-- <div class=" text-sm xs:text-xs flex justify-start  items-center text-left "><span class=" mr-[2px]  ">{{ __('main.active_num',['num'=>$totalactiveforms ]) }}</div>
                    <div class=" text-sm xs:text-xs flex justify-start  items-center text-left ">{{ __('main.inactive_num',['num'=>$totalforms-$totalactiveforms ]) }}</div> --}}

                </div>
                {{-- Responses info --}}
                <div class="bg-primary_blue ml-2 mr-2 p-2  h-auto w-42 border-[1px] border-gray-300 rounded-[0.5rem] xs:p-1 xs-ml-1 xs:mr-1">
                    <div class=" text-sm xs:text-xs grid justify-center  items-center text-left ">
                        <span class=" mr-[2px]  ">{{ __('main.totalresponses') }}</span>
                        <span class="text-secondary_blue text-md text-center">{{ $totalresponses }}</span>
                    </div>
                    {{-- <div class=" text-sm xs:text-xs flex justify-start  items-center text-left "><span class=" mr-[2px]  ">{{ __('From Kiosks : ') }}</span><span class="text-secondary_blue">{{ $totalresponses==0?'0':number_format(round(($totalresponses_kiosks*100)/$totalresponses, 0), 0)  }}%</span></div>
                    <div class=" text-sm xs:text-xs flex justify-start  items-center text-left "><span class=" mr-[2px]  ">{{ __('From share : ') }}</span><span class="text-secondary_blue">{{$totalresponses==0?'0':number_format(round((($totalresponses-$totalresponses_kiosks)*100)/$totalresponses, 0), 0)   }}%</span></div> --}}

            </div>
            </div>


            {{-- notes --}}
            {{-- <div class=" rounded-lg w-auto  ml-2  h-20  mr-2 p-2 xs:p-1 xs-ml-1 xs:mr-1">
            <h1>{{ ('You hava: ') }} <span class="text-red-400 text-lg"> {{ count($disabledForms) }} </span> {{ ('disable forms. ') }}</h1>
            <h1> {{ (' your plan is: ') }}<span class="text-green-300 text-lg">{{ $current_subscribe->type }}</span></h1>
            <h1> {{ (' you can enable: ') }}<span class="text-blue-300 text-lg">{{ $enableFormsNum }}</span>{{ (' forms') }}</h1>
            </div> --}}
        </div>
        {{-- all forms --}}

        <div class=" drop-shadow      p-4  rounded-[0.5rem] mb-8 h- max-h-[82vh] grow  overflow-y-auto border">
            @if($totalforms==0)
            <div class="col-span-12 flex justify-center items-center ">
            <span class="text-md text-center text-black">{{ __('main.noforms' ) }}</span>
            </div>
            @else
            @foreach ($this->typesForms as $key => $type)
            <div class="grid   ">
                <div class="flex justify-between items-center max-h-8   p-1">
                    {{ $type['type'] }} {{ __(' Forms') }}
                    @if($type['type_id']==1)
                    <div class="flex justify-between items-center">
                        <div class=" text-sm xs:text-xs flex justify-start  items-center text-left mx-2"><span class=" mr-[2px]  ">{{ __('main.active_num',['num'=>$type['activeFormsCount'] ]) }}</div>
                        <div class=" text-sm xs:text-xs flex justify-start  items-center text-left mx-2">{{ __('main.inactive_num',['num'=>$type['inactiveFormsCount'] ]) }}</div>
                    </div>
                    @endif
                </div>
               <div class="grid grid-cols-12 gap-3 my-1  h-[35vh] max-h-[35vh]  overflow-y-auto  p-1">
                @if(count($type['forms'])>0)
                @foreach ($type['forms'] as $key => $form)

                        <x-form :form="$form" :responsessvg="$responses_svg" :formagesvg="$formage_svg" :mediasvg="$media_svg"   />
                @endforeach
                @else
                <div class="flex col-span-12 justify-center items-center">
                 <h1>{{ __('main.noforms') }}</h1>
                </div>
                @endif
               </div>
            </div>
            @endforeach
            @endif
        </div>



    </div>

    {{-- share form modal --}}
    <x-share-form-box />

    {{-- add form modal--}}
    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " data-backdrop="static" data-keyboard="false" id="addform" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="xs:m-0 modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class=" modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">
        @livewire('addforms')
        </div>
    </div>
    </div>



</div>
@push('scripts')
<script src="{{ asset('js/index.min.js')}}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js')}}"></script>
<script defer src="{{ asset('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js')}}" defer></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>
<script>
  var translations = @json(__('main'));
  var WarningDeleteMessages={
    '1':translations.deleteform_qa,
    '2':translations.deleteform_media,
   };

    window.addEventListener('close_modal_add_form', event => {
        //  $("#addform").modal('hide');
        $('#addform').modal('hide').data('bs.modal', null);
            // $('.modal').remove();
            $('.modal-backdrop').remove();
        // $('body').removeClass('modal-open');
        // $('body').removeAttr('style');


    });
    // show modal of cannot delete form because connected to kiosks
    window.addEventListener('show-modal-haveKiosks', event => {
        (async () => {
            const { value: confirmUnlink } = await Swal.fire({
                text: translations.formhaveKiosksalarm,
                icon: 'question',
                showCancelButton: true,
                cancelButtonColor: '#f3f4f6',
                cancelButtonText: `<h5 style='color:000000;border:0;box-shadow: none;'>${translations.cancel}</h5>`,
                confirmButtonText: translations.unlink,
                confirmButtonColor: '#1277D1',
            });

            if (confirmUnlink) {
                Livewire.emit('unlink');
            }
        })();

    });
 //  show alarm
    window.addEventListener('show-alarm', event => {

        const id=@this.current_subscribe_id;
        if(@this.current_subscribe_type=="Free")
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Your plan has expired!',
            footer: `<a href="{{ route('subscribe','upgrade') }}" class="animate-pulse text-blue-400 hover:text-blue-500">Upgrade now</a>`
            })
        else if(@this.current_subscribe_type=="Ultimate")
                Swal.fire({

                icon: 'error',
                title: 'Oops...',
                text: 'Your plan has expired!',
                footer: `<a href="{{ route('subscribe',['renew']) }}/${id}" class="animate-pulse text-lg text-blue-400 hover:text-blue-500">Renew now</a>`
                })
        else

                Swal.fire({

            icon: 'error',
            title: 'Oops...',
            text: 'Your plan has expired!',
            footer: `<div class="flex justify-center items-center"><a href="{{ route('subscribe',['renew']) }}/${id}" class="animate-pulse text-lg text-blue-400 hover:text-blue-500">Renew now</a><span class="text-sm mx-[2px] ">or </span><a href="{{ route('subscribe','upgrade') }}" class="text-lg animate-pulse text-blue-400 hover:text-blue-500">Upgrade now</a></div>`
            })

    });
    //  show warning of form delete
    window.addEventListener('show-delete', event => {
        (async () => {

            const { value: accept } = await Swal.fire({

            text: WarningDeleteMessages[event.detail.typeId],
            input: 'checkbox',
            inputValue: 0,
            icon:'question',
            confirmButtonColor: '#dc2626',
            showCancelButton: true,
            cancelButtonColor:'#f3f4f6',
            cancelButtonText:`<h5 style='color:000000;border:0;box-shadow: none;'>${translations.cancel}</h5>`,
            inputPlaceholder:
                translations.suredelete,
            confirmButtonText:translations.delete,
            inputValidator: (result) => {
                return !result && translations.checkboxrequired
            }
            })

            if (accept) {
                Livewire.emit('deleted');
            }

        })()
    });
    // show copy link box
    function showboxlink(link,validAccount)  {
        if(validAccount){
            console.log(link);
            box_link=document.getElementById('box_link');
            box_link.value=link;
        }
        else
        {
            const id=@this.current_subscribe_id;
            if(@this.current_subscribe_type=="Free")
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Your plan has expired!',
                footer: `<a href="{{ route('subscribe','upgrade') }}" class="animate-pulse text-blue-400 hover:text-blue-500">Upgrade now</a>`
                })
            else if(@this.current_subscribe_type=="Ultimate")
                    Swal.fire({

                    icon: 'error',
                    title: 'Oops...',
                    text: 'Your plan has expired!',
                    footer: `<a href="{{ route('subscribe',['renew']) }}/${id}" class="animate-pulse text-lg text-blue-400 hover:text-blue-500">Renew now</a>`
                    })
            else

                    Swal.fire({

                icon: 'error',
                title: 'Oops...',
                text: 'Your plan has expired!',
                footer: `<div class="flex justify-center items-center"><a href="{{ route('subscribe',['renew']) }}/${id}" class="animate-pulse text-lg text-blue-400 hover:text-blue-500">Renew now</a><span class="text-sm mx-[2px] ">or </span><a href="{{ route('subscribe','upgrade') }}" class="text-lg animate-pulse text-blue-400 hover:text-blue-500">Upgrade now</a></div>`
                })
        }
    }

    </script>
    <script>
        var flashedMessage = document.getElementById('flashedMessage').value;
        if (flashedMessage) {
            Swal.fire({
            icon: 'error',
            title:translations.addformfailed,
            text:flashedMessage,
            confirmButtonColor:'#1277D1',
    })

    }

    </script>
@endpush
