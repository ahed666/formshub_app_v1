@push('styles')
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
    </style>
      <link  rel="stylesheet" href="{{ asset('styles/bootstrap.min.css')}}">

@endpush
{{-- wire:loading.class="disabled opacity-50" --}}
<div >
    <input type="hidden" id="flashedMessage" value="{{ session('error_message') }}">

    {{-- locked account  --}}
    @if ($accountStatus['status']=="Locked")
    <x-lockedaccount/>

   @endif


    <div class="{{ $accountStatus['status']=="Locked"?"pointer-events-none opacity-50":"" }}  gap-1 mt-2 ">
        {{-- Add kiosks & info panel  --}}
        <div class="w-full  mb-2 flex justify-between p-2 pl-4  items-center bg-white drop-shadow     rounded-[0.5rem]" >

                <button data-toggle="modal" data-target="#adddevice" type="button" class="bg-secondary_blue rounded
                 xs:p-1   xs:h-10 xs:w-[80px]   p-2 h-16   w-[100px] hover:cursor-pointer ease-in delay-100  hover:-translate-z-1 hover:scale-[1.1]
                   duration-200 xs:my-2   xs:grid xs:justify-center xs:items-center ">
                    <div  class="flex   justify-center items-center">

                        <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                        <svg   class=" w-6 h-6 xs:w-3 xs:h-3  " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                        <g id="SVGRepo_iconCarrier"> <path d="M11 4H6C4.89543 4 4 4.89543 4 6V14C4 15.1046 4.89543 16 6 16H18C19.1046 16 20 15.1046 20 14V12" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M18 3V6M18 9V6M18 6H15M18 6H21" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M12 16V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M8 20H16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                        </svg>
                    </div>
                   <div class="flex justify-center">
                    <span class="mt-1 text-white text-sm xs:text-xs">{{ __('main.addkiosk') }}</span>
                   </div>
                </button>

            {{-- Info Panel --}}
            <div class="flex xs:block">
                {{-- total kiosks --}}
                @php
                    $total=count($kiosks);
                    // $inservice=0;
                    // $outofservice=0;
                    // foreach ($kiosks as $kiosk) {
                    // $kiosk->in_service?$inservice+=1:$outofservice+=1;
                    // }
                @endphp


                <div wire:ignore class="bg-primary_blue ml-2 mr-2 p-2  h-auto w-42 border-[1px] border-gray-300 rounded-[0.5rem] xs:p-1 xs-ml-1 xs:mr-1  ">
                    <x-total :title=" __('main.totalkiosks_num')" :total="$total" :subscribenum="$this->current_subscribe->num_kiosks"  />

                    {{-- <div class=" text-sm xs:text-xs grid justify-center  items-center text-left ">
                        <span class=" mr-[2px]  ">{{ __('main.totalkiosks_num') }}</span>
                        <span class="{{ $this->current_subscribe->num_kiosks>$total?"text-secondary_blue":"text-primary_red font-bold" }} text-md text-center">
                            {{  $total}} {{ __('/') }} {{ $this->current_subscribe->num_kiosks   }}
                        </span>
                    </div> --}}
                    {{-- <div class="text-sm xs:text-xs flex justify-start   items-center text-left"><span class=" mr-[2px] ">{{ __('In Service: ') }}</span><span class="text-secondary_blue">{{ $inservice }}</span></div>
                    <div class="text-sm xs:text-xs flex justify-start   items-center text-left"><span class=" mr-[2px] ">{{ __('Out Of Service: ') }}</span><span class="text-secondary_blue">{{ $outofservice }}</span></div> --}}

                </div>



            </div>

        </div>
        {{-- list of kiosks  --}}
        <div class="grid grid-cols-12 gap-3 drop-shadow  p-4  rounded-[0.5rem] max-h-[85vh] grow  overflow-y-auto border">
            @if(count($kiosks)==0)
                <div class="col-span-12 flex justify-center items-center ">
                  <span class="text-md text-center text-black">{{ __('main.nokiosks' ) }}</span>
                </div>
            @else
                @foreach ($kiosks as $i=> $kiosk)

                    <div class="col-span-3 lg:col-span-6  md:col-span-6 sm:col-span-12 xs:col-span-12 border-secondary_blue border-[1px] bg-white p-3 rounded-[0.5rem]">
                        <div class="grid grid-cols-6">
                            {{-- kiosk icon --}}
                            <div class="col-span-2 relative ">
                                {{-- <div class="rounded-full h-4 w-4 left-[-4px] absolute {{ $kiosk->in_service?"bg-valid":"bg-primary_red" }} "></div> --}}
                                <div class="grid">

                                       <svg class=" w-16 h-16 xs:w-10 xs:h-10" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" width="800px" height="800px" fill="#2d4b71" stroke="#2d4b71" stroke-width="0.00512">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                        <g id="SVGRepo_iconCarrier"> <g> <ellipse style="fill:#1277d1;" cx="256" cy="414.302" rx="93.936" ry="38.661"/> <path style="fill:#1277d1;" d="M265.404,414.302h-18.808c-5.771,0-10.449-4.678-10.449-10.449v-52.245h39.706v52.245 C275.853,409.624,271.175,414.302,265.404,414.302z"/> <path style="fill:#1277d1;" d="M483.265,351.608H28.735c-11.542,0-20.898-9.356-20.898-20.898V79.935 c0-11.542,9.356-20.898,20.898-20.898h454.531c11.542,0,20.898,9.356,20.898,20.898V330.71 C504.163,342.252,494.807,351.608,483.265,351.608z"/> </g> <rect x="39.184" y="90.384" style="fill:#e0e0e0;" width="433.633" height="219.429"/> <path d="M483.265,51.2H28.735C12.89,51.2,0,64.091,0,79.935V330.71c0,15.844,12.89,28.735,28.735,28.735H228.31v10.015 c-37.954,4.688-74.083,19.875-74.083,44.842c0,26.508,43.753,46.498,101.773,46.498s101.773-19.99,101.773-46.498 c0-24.967-36.129-40.152-74.083-44.842v-10.015h199.576c15.845,0,28.735-12.891,28.735-28.735V79.935 C512,64.091,499.11,51.2,483.265,51.2z M325.251,396.856c10.707,5.392,16.849,11.751,16.849,17.446 c0,12.871-32.755,30.824-86.1,30.824s-86.1-17.953-86.1-30.824c0-5.695,6.141-12.054,16.848-17.446 c10.747-5.413,25.283-9.443,41.561-11.595v18.592c0,10.082,8.203,18.286,18.286,18.286h18.808c10.082,0,18.286-8.204,18.286-18.286 v-18.592C299.967,387.414,314.504,391.444,325.251,396.856z M268.016,403.853c0,1.441-1.172,2.612-2.612,2.612h-18.808 c-1.44,0-2.612-1.171-2.612-2.612v-44.408h24.033V403.853z M496.327,330.71c0,7.203-5.859,13.061-13.061,13.061H28.735 c-7.202,0-13.061-5.859-13.061-13.061V79.935c0-7.202,5.859-13.061,13.061-13.061h454.531c7.202,0,13.061,5.859,13.061,13.061 V330.71z"/> <path d="M31.347,317.649h449.306V82.547H31.347V317.649z M47.02,98.22H464.98v203.755H47.02V98.22z"/> </g>
                                        </svg>

                                   <div class="flex justify-start xs:items-start   items-center">
                                     <h1 wire:ignore class="text-xs   w-16 overflow-hidden  text-gray-400">{{ $kiosk->device_model }}</h1>
                                    </div>
                                </div>
                            </div>
                            {{-- Kiosk code --}}
                            <div wire:ignore class="col-span-2  flex justify-center items-center ">
                                <span class="text-md font-bold text-black">{{ $kiosk->device_code }}</span>
                            </div>
                            {{-- inservice --}}
                            <div class="col-span-2 grid justify-end items-center  ">
                               <div class="grid justify-center  items-center">
                                <div class="flex justify-center items-center">

                                    <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                    <svg wire:click="setEditImageId({{$kiosk->id  }},'{{ $kiosk->standbyimage_path }}')"  onclick="setImageModal('{{ $kiosk->standbyimage_path }}')"  data-toggle="modal" data-target="#imagemodal"   class="mx-1 w-6 h-6 text-svg_primary hover:text-secondary_blue hover:cursor-pointer"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.2639 15.9376L12.5958 14.2835C11.7909 13.4852 11.3884 13.0861 10.9266 12.9402C10.5204 12.8119 10.0838 12.8166 9.68048 12.9537C9.22188 13.1096 8.82814 13.5173 8.04068 14.3327L4.04409 18.2802M14.2639 15.9376L14.6053 15.5991C15.4112 14.7999 15.8141 14.4003 16.2765 14.2544C16.6831 14.1262 17.12 14.1312 17.5236 14.2688C17.9824 14.4252 18.3761 14.834 19.1634 15.6515L20 16.4936M14.2639 15.9376L18.275 19.9566M18.275 19.9566C17.9176 20.0001 17.4543 20.0001 16.8 20.0001H7.2C6.07989 20.0001 5.51984 20.0001 5.09202 19.7821C4.71569 19.5904 4.40973 19.2844 4.21799 18.9081C4.12796 18.7314 4.07512 18.5322 4.04409 18.2802M18.275 19.9566C18.5293 19.9257 18.7301 19.8728 18.908 19.7821C19.2843 19.5904 19.5903 19.2844 19.782 18.9081C20 18.4803 20 17.9202 20 16.8001V16.4936M12.5 4L7.2 4.00011C6.07989 4.00011 5.51984 4.00011 5.09202 4.21809C4.71569 4.40984 4.40973 4.7158 4.21799 5.09213C4 5.51995 4 6.08 4 7.20011V16.8001C4 17.4576 4 17.9222 4.04409 18.2802M20 11.5V16.4936M14 10.0002L16.0249 9.59516C16.2015 9.55984 16.2898 9.54219 16.3721 9.5099C16.4452 9.48124 16.5146 9.44407 16.579 9.39917C16.6515 9.34859 16.7152 9.28492 16.8425 9.1576L21 5.00015C21.5522 4.44787 21.5522 3.55244 21 3.00015C20.4477 2.44787 19.5522 2.44787 19 3.00015L14.8425 7.1576C14.7152 7.28492 14.6515 7.34859 14.6009 7.42112C14.556 7.4855 14.5189 7.55494 14.4902 7.62801C14.4579 7.71033 14.4403 7.79862 14.4049 7.97518L14 10.0002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                 <h1 class="text-xs"> {{ __('main.editimage') }}</h1>
                                </div>
                            </div>

                        {{-- info --}}
                        </div>
                        {{-- kiosk info editable --}}
                        <div class="mt-2 grid  grid-cols-7 min-h-max h-max max-h-max gap-1">

                            {{-- kiosk name --}}
                            <div class=" col-span-3 md:col-span-3 xs:col-span-3">
                                <h1 class="text-sm xs:text-xs pointer-events-none   text-secondary_blue  left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                                transition-all duration-200 ease-out">{{ __('main.kioskname') }}</h1>
                                @if($edit&&$idEditing==$kiosk->id)
                                <input id="kiosk_name" maxlength="25" type="text" wire:model="edited_kiosk_name"
                                class="xs:text-xs w-full   h-10    text-gray-900 text-sm
                                border-gray-300  focus:border-secondary mr-2
                         focus:ring-secondary
                                rounded-lg  block       px-2">
                                @error('edited_kiosk_name') <li class="text-red-400 text-xs"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
                                @else
                                <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $kiosk->device_name }}" class="xs:text-xs w-full mr-2  h-10 bg-gray-50  text-gray-900
                                rounded-lg        px-2 text-sm flex items-center whitespace-nowrap overflow-hidden ">{{ $kiosk->device_name }}</div>
                            @endif
                            </div>
                            {{-- form name --}}
                            <div class=" col-span-3 md:col-span-3 xs:col-span-3">
                                <h1 class=" text-sm xs:text-xs pointer-events-none   text-secondary_blue  left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                                  transition-all duration-200 ease-out">{{ __('main.linkedform') }}</h1>
                                @if($edit&&$idEditing==$kiosk->id)
                                    <select  id="" name="" class="xs:text-xs w-full   h-10   {{$edited_form_id==""?"text-primary_red":"text-gray-900"}}  text-sm rounded-lg
                                           block px-2   focus:border-secondary mr-2
                                         focus:ring-secondary " wire:model="edited_form_id"  >
                                           {{-- without form  --}}

                                            <option value="" class="text-primary_red ">{{ __(' ⏱ ') }}{{ __('Stand-By') }}</option>
                                            {{-- for signature
                                            <option value="sign" class="">{{ __('For Signature') }}</option> --}}
                                            @if($forms!=null)
                                            @foreach ($this->forms as $form)
                                                <option class="text-gray-900" value="{{ $form->id }}">{{ $form->form_title}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                @else
                                <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $kiosk->form_title }}" class=" xs:text-xs w-full mr-2
                                     {{-- {{ $kiosk->form_title==null?"bg-red-100   ":"bg-gray-50" }} --}} bg-gray-50
                                     h-10   text-gray-900
                                rounded-lg        px-2 text-sm flex items-center whitespace-nowrap overflow-hidden">
                                @if($kiosk->sign_kiosk==false&&$kiosk->form_id==null)
                                <span class="text-primary_red">{{ __(' ⏱ ') }}{{ __('Stand-By') }}</span>
                                @else
                               <span class="text-gray-900">{{ $kiosk->form_title }}</span>
                                @endif
                            </div>

                                @endif

                            </div>

                            {{-- save button --}}


                            @if($edit&&$idEditing==$kiosk->id)
                                <div class="xs:text-xs col-span-1 md:col-span-1 xs:col-span-1 flex justify-end flex-col items-center" >
                                    <div class="block">
                                        <svg wire:click="saveChanges()"  class="w-6 h-6 text-svg_primary hover:text-valid hover:cursor-pointer"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="System / Save">
                                            <path id="Vector" d="M17 21.0002L7 21M17 21.0002L17.8031 21C18.921 21 19.48 21 19.9074 20.7822C20.2837 20.5905 20.5905 20.2843 20.7822 19.908C21 19.4806 21 18.921 21 17.8031V9.21955C21 8.77072 21 8.54521 20.9521 8.33105C20.9095 8.14 20.8393 7.95652 20.7432 7.78595C20.6366 7.59674 20.487 7.43055 20.1929 7.10378L17.4377 4.04241C17.0969 3.66374 16.9242 3.47181 16.7168 3.33398C16.5303 3.21 16.3242 3.11858 16.1073 3.06287C15.8625 3 15.5998 3 15.075 3H6.2002C5.08009 3 4.51962 3 4.0918 3.21799C3.71547 3.40973 3.40973 3.71547 3.21799 4.0918C3 4.51962 3 5.08009 3 6.2002V17.8002C3 18.9203 3 19.4796 3.21799 19.9074C3.40973 20.2837 3.71547 20.5905 4.0918 20.7822C4.5192 21 5.07899 21 6.19691 21H7M17 21.0002V17.1969C17 16.079 17 15.5192 16.7822 15.0918C16.5905 14.7155 16.2837 14.4097 15.9074 14.218C15.4796 14 14.9203 14 13.8002 14H10.2002C9.08009 14 8.51962 14 8.0918 14.218C7.71547 14.4097 7.40973 14.7155 7.21799 15.0918C7 15.5196 7 16.0801 7 17.2002V21M15 7H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </g>
                                        </svg>
                                        <span class="text-sm block">{{ __('main.save') }}</span>
                                    </div>
                                </div>
                            @endif


                        </div>

                        {{-- buttons  --}}
                        <div  class="flex justify-between items-center mt-2">
                            {{-- delete --}}
                            <div wire:ignore >
                                <svg wire:click="delete({{ $kiosk->id }})" class="w-6 h-6 text-svg_primary hover:text-primary_red hover:cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                    <g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M14 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M4 7H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                </svg>
                            </div>
                            <div  class="flex">
                                {{-- refresh --}}

                                <svg wire:click="sendrefresh({{ $kiosk->id }})"  class="mx-1 w-6 h-6 text-svg_primary hover:text-secondary_blue hover:cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.9381 13C19.979 12.6724 20 12.3387 20 12C20 7.58172 16.4183 4 12 4C9.49942 4 7.26681 5.14727 5.7998 6.94416M4.06189 11C4.02104 11.3276 4 11.6613 4 12C4 16.4183 7.58172 20 12 20C14.3894 20 16.5341 18.9525 18 17.2916M15 17H18V17.2916M5.7998 4V6.94416M5.7998 6.94416V6.99993L8.7998 7M18 20V17.2916" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                {{-- edit  --}}
                                    <svg   wire:click="setEditInfo('{{ $kiosk->id }}','{{ $kiosk->device_name }}','{{ $kiosk->form_id }}')" class="mx-1 w-6 h-6 text-svg_primary hover:text-secondary_blue hover:cursor-pointer"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g  id="SVGRepo_bgCarrier" stroke-width="0"/>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                        <g  id="SVGRepo_iconCarrier"> <path wire:ignore d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                    </svg>


                            </div>
                        </div>

                    </div>
                @endforeach
            @endif


        </div>

    </div>
   {{-- add device modal --}}

    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " data-backdrop="static" data-keyboard="false" id="adddevice" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="xs:m-0 modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">

          @livewire('add-device')

        </div>
        </div>
    </div>

  {{-- end add device modal --}}

  {{-- image modal  --}}
    <div wire:ignore  class="modal fade fixed top-0 left-0 z-[200px]  h-full w-full  " data-backdrop="static" data-keyboard="false" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">
        {{-- header --}}
        <div class="flex items-center justify-between p-4 border-b rounded-t ">
            <div class="flex items-center">
            <h3 class="text-xl font-semibold text-gray-900 ">
                {{ __('main.standbyimage') }}
            </h3>
            </div>
            <button wire:click="resetValue" type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
            items-center   close" data-dismiss="modal" aria-label="Close">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        {{-- end header --}}
        {{-- body --}}
        <div  class=" 2xl:max-h-[700px] xs:max-h-[400px] flex justify-center items-center p-2">
            <img class="w-[640px] h-[390px] xs:w-[320px] xs:h-[195px] object-contain" src="" class="" id="imageModal" alt="">
        </div>
        {{-- end body --}}
        {{-- footer --}}
        <div class="flex justify-between items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">
            <div class="flex justify-center space-x-2 items-center">
                <x-jet-secondary-button wire:click="resetValue"  data-dismiss="modal" aria-label="Close"  type="button"  wire:loading.attr="disabled">
                    {{ __('main.cancel') }}
                </x-jet-secondary-button>
                <x-jet-button wire:click="saveImageKiosk"  class="ml-3" type="button"   wire:loading.attr="disabled">
                                {{ __('main.save') }}
                </x-jet-button>
            </div>
            <div class="flex justify-between space-x-4 items-center">

                <label class="grid justify-center items-center mb-0" for="image">
                    <div class="flex justify-center items-center">
                        <svg  class="w-6 h-6  hover:cursor-pointer text-svg_primary hover:text-secondary_blue" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M8 10C8 7.79086 9.79086 6 12 6C14.2091 6 16 7.79086 16 10V11H17C18.933 11 20.5 12.567 20.5 14.5C20.5 16.433 18.933 18 17 18H16C15.4477 18 15 18.4477 15 19C15 19.5523 15.4477 20 16 20H17C20.0376 20 22.5 17.5376 22.5 14.5C22.5 11.7793 20.5245 9.51997 17.9296 9.07824C17.4862 6.20213 15.0003 4 12 4C8.99974 4 6.51381 6.20213 6.07036 9.07824C3.47551 9.51997 1.5 11.7793 1.5 14.5C1.5 17.5376 3.96243 20 7 20H8C8.55228 20 9 19.5523 9 19C9 18.4477 8.55228 18 8 18H7C5.067 18 3.5 16.433 3.5 14.5C3.5 12.567 5.067 11 7 11H8V10ZM15.7071 13.2929L12.7071 10.2929C12.3166 9.90237 11.6834 9.90237 11.2929 10.2929L8.29289 13.2929C7.90237 13.6834 7.90237 14.3166 8.29289 14.7071C8.68342 15.0976 9.31658 15.0976 9.70711 14.7071L11 13.4142V19C11 19.5523 11.4477 20 12 20C12.5523 20 13 19.5523 13 19V13.4142L14.2929 14.7071C14.6834 15.0976 15.3166 15.0976 15.7071 14.7071C16.0976 14.3166 16.0976 13.6834 15.7071 13.2929Z" fill="CurrentColor"/> </g>
                        </svg>
                    </div>
                    <h1 class="text-xs">{{ __('main.upload') }}</h1>

                    <input   wire:model="image" class="image opacity-0 absolute -z-10" type="file" name="image" id="image" accept="image/*" />
                </label>
                <div class="grid justify-center items-center">
                    <div class="flex justify-center items-center">
                        <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                        <svg wire:click="setDefultStandByImage" class="w-6 h-6  hover:cursor-pointer text-svg_primary hover:text-secondary_blue" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 5.5C17 4.11929 15.8807 3 14.5 3H5.5C4.11929 3 3 4.11929 3 5.5V14.5C3 15.8807 4.11929 17 5.5 17H9.59971C9.43777 16.6832 9.30564 16.3486 9.20703 16H5.5C4.67157 16 4 15.3284 4 14.5V7H16V9.20703C16.3486 9.30564 16.6832 9.43777 17 9.59971V5.5ZM5.5 4H14.5C15.3284 4 16 4.67157 16 5.5V6H4V5.5C4 4.67157 4.67157 4 5.5 4Z" fill="currentColor"/>
                        <path d="M10.4175 15.9412C11.2352 15.1544 11.2352 13.8457 10.4175 13.0588L10.2695 12.9165C10.4392 12.4312 10.6847 11.9834 10.9912 11.5885L11.1901 11.6473C12.2875 11.9715 13.4327 11.3106 13.701 10.1981L13.7712 9.90699C14.0085 9.86699 14.252 9.84619 14.5001 9.84619C14.7483 9.84619 14.9918 9.86699 15.2291 9.907L15.2993 10.1981C15.5676 11.3106 16.7128 11.9715 17.8102 11.6473L18.0091 11.5885C18.3156 11.9834 18.5611 12.4312 18.7308 12.9165L18.5828 13.0588C17.7651 13.8457 17.7651 15.1544 18.5828 15.9412L18.7307 16.0836C18.5611 16.5689 18.3156 17.0167 18.0091 17.4116L17.8102 17.3528C16.7128 17.0286 15.5676 17.6895 15.2993 18.8019L15.2291 19.0931C14.9918 19.1331 14.7483 19.1539 14.5001 19.1539C14.252 19.1539 14.0085 19.1331 13.7712 19.0931L13.701 18.8019C13.4327 17.6895 12.2875 17.0286 11.1901 17.3528L10.9912 17.4116C10.6847 17.0167 10.4392 16.5689 10.2695 16.0836L10.4175 15.9412ZM13.2735 14.5C13.2735 15.201 13.8227 15.7693 14.5001 15.7693C15.1776 15.7693 15.7268 15.201 15.7268 14.5C15.7268 13.7991 15.1776 13.2308 14.5001 13.2308C13.8227 13.2308 13.2735 13.7991 13.2735 14.5Z" fill="currentColor"/>
                        </svg>
                    </div>
                    <h1 class="text-xs">{{ __('main.setdefault') }}</h1>
                </div>


            </div>
        </div>

        </div>
        {{-- end footer --}}


        </div>

    </div>
  {{-- end image modal --}}

  {{-- crop modal --}}

    <div   id="cropimage-edit" class="modal    absolute z-[500px] top-4 bottom-4 left-1/4 xs:left-0 border-[1px] rounded-t-xl border-transparent
    max-h-[900px] h-full
      max-w-[900px] w-full bg-white {{ $modal?"block":"hidden" }}">
            <div class=" h-10 border-[1px] rounded-t-xl border-transparent p-2 flex justify-end modal-header">
                <a wire:click="closemodal" class=" w-10 h-6 text-secondary_red hover:text-primary_red cursor-pointer flex justify-center" >
                    <span  class=" close   ">&times;</span>
                </a>
            </div>
            <!-- Modal content -->
            <div class=" h-[80%]   overflow-y-scroll ">
                <div class=" result-upload flex justify-center"></div>
            </div>
            <!--rightbox-->
            <!-- input file -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b h-20">
                <!-- save btn -->
                <x-jet-secondary-button  wire:click="closemodal"   type="button" >
                    {{ __('main.cancel') }}
                </x-jet-secondary-button>
                <x-jet-button  wire:click="cropimage"  class="ml-3" type="button"   >
                    {{ __('main.crop') }}
                </x-jet-button>

            </div>


    </div>
</div>
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
      var translations = @json(__('main'));

    // show modal of cannot delete form because connected to kiosks
    window.addEventListener('show-modal-haveform', event => {
        (async () => {
            const { value: confirmUnlink } = await Swal.fire({
                text: translations.kioskhaveform,
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
    //  to confirm delete language
    window.addEventListener('show-device-delete-confirmation', event => {

        (async () => {

        const { value: accept } = await Swal.fire({
        text: translations.devicedeletealarm,
        input: 'checkbox',
        inputValue: 0,
        icon:'question',
        confirmButtonColor: '#dc2626',
        showCancelButton: true,
        cancelButtonColor:'#f3f4f6',
        cancelButtonText:`<h5 style='color:000000;border:0;box-shadow: none;'>${translations.cancel}</h5>`,
        inputPlaceholder:translations.kiosksuredelete,
        confirmButtonText:translations.delete,
        inputValidator: (result) => {
            return !result && translations.checkboxrequired
        }
        })

        if (accept) {
            Livewire.emit('deleteDeviceConfirmed');
        }

        })()
    });
    //   close modal add device
    window.addEventListener('close_modal_add_device', event => {
        $('#adddevice').modal('hide').data('bs.modal', null);
        $('.modal-backdrop').remove();
    });
    </script>
     <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('refreshTriggered', function (id) {

                Swal.fire({
                    icon: 'success',
                    title:translations.kioskupdated,
                    text:translations.refreshtriggeredsuccessfully.replace(':id', id),
                    confirmButtonColor:'#1277D1',
                    confirmButtonText: `<h5 style='color:ffffff;border:0;box-shadow: none;'>${translations.ok}</h5>`,

            })
            });
        });
    </script>

    <script>
        var flashedMessage = document.getElementById('flashedMessage').value;
        if (flashedMessage) {
            Swal.fire({
            icon: 'error',
            title:'Add kiosk failed!',
            text:flashedMessage,
            confirmButtonColor:'#1277D1',

    })

    }
    </script>
    <script >
        function setImageModal(path){
            document.getElementById('imageModal').src = '{{ asset('') }}' + path;
        }
        document.addEventListener('changeImagePath',event=>{

            setImageModal(event.detail.path);
        });
        document.addEventListener('image-updated-edit', event =>  {
            console.log('edit');
            result = document.querySelector('.result-upload');
            // img_w = document.querySelector('.img-w'),
            // img_h = document.querySelector('.img-h'),
            // options = document.querySelector('.options'),
            save = document.querySelector('.save');

            // dwn = document.querySelector('.download'),
            upload = document.querySelector('.image');
            cropper = '';
            var finalCropWidth = 640;
            var finalCropHeight = 390;
            var finalAspectRatio = finalCropWidth / finalCropHeight;
            // on change show image with crop options

                    // start file reader
                const reader = new FileReader();
                let img = document.createElement('img');
                img.id = 'image';
                img.src = @this.imagesrc;

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
                width:1280,
                height:780
                }).toDataURL();



                @this.saveImageTemp(imgSrc);
                @this.closemodalwithsave();
            // dwn.classList.remove('hide');
            // dwn.download = 'imagename.png';
            // dwn.setAttribute('href',imgSrc);
        });
    </script>
@endpush
