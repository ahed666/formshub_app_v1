
@push('styles')
<link
  rel="stylesheet"
  href="{{ asset('/styles/index.min.css') }}" />
  <link  rel="stylesheet" href="{{ asset('styles/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf_viewer.min.css') }}">
  <style>
     #pdf-container {
      width: 100%;
      height: 100%;
      position: relative;
    }

    #pdf-viewer {
      width: 100%;
      height: 100%;
      overflow: auto;
    }
  </style>
@endpush

<div   class="h-screen overflow-hidden xs:overflow-y-auto xs:h-full">

    <input type="hidden" id="flashedMessage_messagessaved" value="{{ session('success_message_messagessaved') }}">
    {{-- <div id="toast-update" class="hidden absolute z-50 w-full max-w-xs top-5 right-5  text-sm  border-t-4 rounded-l-full rounded-r-full rounded border-secondary_blue text-secondary_blue bg-primary_blue px-4 py-3 shadow" role="alert">
        <div class="flex">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 ">
                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                <svg class="text-valid w-6 h-6 inline-block" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                <g id="SVGRepo_iconCarrier"> <path opacity="0.1" d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" fill="currentColor"/> <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2"/> <path d="M9 12L10.6828 13.6828V13.6828C10.858 13.858 11.142 13.858 11.3172 13.6828V13.6828L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                </svg>
            </div>
            @if($current_form_kiosks)
            <div class="ml-3 text-sm font-normal">
                <span class="mb-1 text-sm font-semibold text-gray-900 ">Successful Action</span>
                @if(count($current_form_kiosks)>0)
                <div class="mb-2 text-sm text-black font-normal">Your changes have been saved and will be applied the next time this form is loaded, therefore you have a kiosk or more linked to this form, would you like to send a request to all linked kiosks to apply changes now?</div>
                @else
                <div class="mb-2 text-sm text-black font-normal">Your changes have been saved and will be applied the next time this form is loaded</div>
                @endif
                @if(count($current_form_kiosks)>0)
                <div class="grid grid-cols-2 gap-2">
                    <x-jet-secondary-button onclick="hideAlert()" class="text-center justify-center"  type="button"   >
                        {{ __('Not Now') }}
                    </x-jet-secondary-button>
                    <x-jet-button class="ml-3 text-center justify-center" onclick="hideAlert()" wire:click="updateformonkiosks()" type="button"  >
                        {{ __('Update') }}
                    </x-jet-button>
                </div>
                @endif
            </div>
            @endif
            <button type="button" class="ml-auto -mx-1.5 -my-1.5  items-center justify-center flex-shrink-0 text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 " data-dismiss-target="#toast-update" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    </div> --}}
    <div  wire:loading.class="flex z-[100]" wire:loading.remove.class="hidden" class="hidden  justify-center items-center absolute top-1/2 right-[44%] ">
        <svg class="animate-spin h-10 w-10 mr-1 text-secondary_blue" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
          </svg>

          <span class="text-sm">{{ __('Please Wait...') }}</span>
    </div>


    <div wire:loading.class="disabled opacity-50 animate-pulse" class="grid grid-rows-12 min-h-screen">






            {{-- form info --}}



            <div class="w-full h-full  row-span-12 mt-4  ">



                <div class="grid xs:block 2xl:grid-cols-12 xl:grid-cols-12 lg:grid-cols-12 md:grid-cols-12 gap-2   ">
                    {{-- form settings --}}
                    <div class="col-span-3   " >

                        {{-- buttons --}}
                        <div class="w-full flex justify-between space-x-4 items-center p-4  rounded-[0.5rem] bg-white  xs:my-2 xs:p-2 drop-shadow mb-2">
                           {{-- add button --}}
                            <label class="relative hover:cursor-pointer cursor-pointer  border-[1px] border-gray-200 bg-gray-300 rounded-[0.5rem] h-16 w-[35%] mb-0" for="image">
                                <input   wire:model="currentFile" class=" h-full  opacity-0 absolute  hover:cursor-pointer cursor-pointer w-full" type="file" name="file" id="file" accept="application/pdf" />
                                <div  class="pl-2 pr-2 pt-2 hover:cursor-pointer cursor-pointer flex justify-center items-center">

                                    <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                    <svg  fill="#000000" xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 hover:cursor-pointer cursor-pointer" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve">
                                    <path d="M20,37.5c0-0.8-0.7-1.5-1.5-1.5h-15C2.7,36,2,36.7,2,37.5v11C2,49.3,2.7,50,3.5,50h15c0.8,0,1.5-0.7,1.5-1.5
                                        V37.5z"/>
                                    <path d="M8.1,22H3.2c-1,0-1.5,0.9-0.9,1.4l8,8.3c0.4,0.3,1,0.3,1.4,0l8-8.3c0.6-0.6,0.1-1.4-0.9-1.4h-4.7
                                        c0-5,4.9-10,9.9-10V6C15,6,8.1,13,8.1,22z"/>
                                    <path d="M41.8,20.3c-0.4-0.3-1-0.3-1.4,0l-8,8.3c-0.6,0.6-0.1,1.4,0.9,1.4h4.8c0,6-4.1,10-10.1,10v6
                                        c9,0,16.1-7,16.1-16H49c1,0,1.5-0.9,0.9-1.4L41.8,20.3z"/>
                                    <path d="M50,3.5C50,2.7,49.3,2,48.5,2h-15C32.7,2,32,2.7,32,3.5v11c0,0.8,0.7,1.5,1.5,1.5h15c0.8,0,1.5-0.7,1.5-1.5
                                        V3.5z"/>
                                    </svg>
                                </div>
                                <div class="pl-2 pr-2 pb-2 hover:cursor-pointer cursor-pointer   flex justify-center">
                                   <h1 class="mt-1  text-sm">{{ __('main.changepdf') }}</h1>
                                </div>
                            </label>
                            {{-- sign button --}}
                            <a     onclick="SignPdf()"   class="bg-secondary_blue rounded hover:no-underline  p-2  h-16 w-[65%]  xs:my-2
                            xs:flex xs:justify-center xs:items-center hover:cursor-pointer cursor-pointer">
                                <div  class="flex justify-center items-center hover:cursor-pointer cursor-pointer">

                                        <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                        <svg class="w-4 h-4 mx-1 text-white  hover:cursor-pointer cursor-pointer " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.0005 15.9995L15.0005 11.9995M15.0005 11.9995L11.0005 7.99951M15.0005 11.9995H3.00049M11.0005 2.99951H17.7997C18.9198 2.99951 19.4799 2.99951 19.9077 3.2175C20.284 3.40925 20.59 3.71521 20.7817 4.09153C20.9997 4.51935 20.9997 5.07941 20.9997 6.19951V17.7995C20.9997 18.9196 20.9997 19.4797 20.7817 19.9075C20.59 20.2838 20.284 20.5898 19.9077 20.7815C19.4799 20.9995 18.9198 20.9995 17.7997 20.9995H11.0005" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                </div>
                                <div class="flex justify-center hover:cursor-pointer cursor-pointer">
                                    <span class="mt-1 text-white text-sm">{{ __('main.sendtokiosk') }}</span>
                                </div>
                            </a>


                        </div>
                        {{-- end buttons --}}



                        {{-- sign settigs--}}
                        <div class=" w-full p-4  rounded-[0.5rem]  bg-white xs:my-2 xs:p-2 drop-shadow mb-2">
                            <div class="flex mb-4 text-black justify-between items-center "  >
                                <h1 class="  text-sm font-bold" >{{ __('main.settings') }}</h1>
                            </div>
                            <div  class="mt-1 mb-1  w-full overflow-hidden " >
                                    {{-- kiosks --}}
                                    <div >
                                        <label for="language" class="block text-xs font-medium text-gray-700">{{ __('main.selectkiosk') }}</label>
                                        @if(count($allKiosks)>0)
                                            <div wire:ignore class="mt-1 mb-1 owl-form owl-carousel owl-theme align-content-center  pr-2">

                                                @foreach ( $allKiosks as $kiosk)
                                                    <div  wire:key="{{ $kiosk->id }}"    class="  item relative  w-full " >

                                                        <input wire:model.defer="selectedKiosk" id="radio_{{ $kiosk->id }}" type="radio"
                                                        value="{{ $kiosk->id }}" name="radio_kiosk"
                                                        class="hidden peer" required>


                                                        <label for="radio_{{ $kiosk->id }}" class="inline-flex items-center justify-between w-full
                                                            bg-white border-[1px] border-gray-400 rounded-[0.5rem] p-1    cursor-pointer
                                                            peer-checked:border-secondary_blue  peer-checked:bg-primary_blue peer-checked:border-[2px]
                                                            hover:text-gray-600 hover:bg-gray-100 ">
                                                            <div class="w-full">
                                                                <div class="flex justify-between space-x-2 items-center">
                                                                    {{-- kiosk icon --}}
                                                                    <div class=" relative">

                                                                        <div>
                                                                            <svg class=" w-4 h-4" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" width="800px" height="800px" fill="#2d4b71" stroke="#2d4b71" stroke-width="0.00512">
                                                                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                <g id="SVGRepo_iconCarrier"> <g> <ellipse style="fill:#1277d1;" cx="256" cy="414.302" rx="93.936" ry="38.661"/> <path style="fill:#1277d1;" d="M265.404,414.302h-18.808c-5.771,0-10.449-4.678-10.449-10.449v-52.245h39.706v52.245 C275.853,409.624,271.175,414.302,265.404,414.302z"/> <path style="fill:#1277d1;" d="M483.265,351.608H28.735c-11.542,0-20.898-9.356-20.898-20.898V79.935 c0-11.542,9.356-20.898,20.898-20.898h454.531c11.542,0,20.898,9.356,20.898,20.898V330.71 C504.163,342.252,494.807,351.608,483.265,351.608z"/> </g> <rect x="39.184" y="90.384" style="fill:#e0e0e0;" width="433.633" height="219.429"/> <path d="M483.265,51.2H28.735C12.89,51.2,0,64.091,0,79.935V330.71c0,15.844,12.89,28.735,28.735,28.735H228.31v10.015 c-37.954,4.688-74.083,19.875-74.083,44.842c0,26.508,43.753,46.498,101.773,46.498s101.773-19.99,101.773-46.498 c0-24.967-36.129-40.152-74.083-44.842v-10.015h199.576c15.845,0,28.735-12.891,28.735-28.735V79.935 C512,64.091,499.11,51.2,483.265,51.2z M325.251,396.856c10.707,5.392,16.849,11.751,16.849,17.446 c0,12.871-32.755,30.824-86.1,30.824s-86.1-17.953-86.1-30.824c0-5.695,6.141-12.054,16.848-17.446 c10.747-5.413,25.283-9.443,41.561-11.595v18.592c0,10.082,8.203,18.286,18.286,18.286h18.808c10.082,0,18.286-8.204,18.286-18.286 v-18.592C299.967,387.414,314.504,391.444,325.251,396.856z M268.016,403.853c0,1.441-1.172,2.612-2.612,2.612h-18.808 c-1.44,0-2.612-1.171-2.612-2.612v-44.408h24.033V403.853z M496.327,330.71c0,7.203-5.859,13.061-13.061,13.061H28.735 c-7.202,0-13.061-5.859-13.061-13.061V79.935c0-7.202,5.859-13.061,13.061-13.061h454.531c7.202,0,13.061,5.859,13.061,13.061 V330.71z"/> <path d="M31.347,317.649h449.306V82.547H31.347V317.649z M47.02,98.22H464.98v203.755H47.02V98.22z"/> </g>
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    {{-- kiosk code --}}
                                                                    <div class="w-full ">
                                                                        <span class="text-xs">{{ $kiosk->device_code }}</span>
                                                                    </div>
                                                                </div>
                                                                <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{$kiosk->device_name }}" class="flex justify-center items-center">
                                                                    <span class="text-xs whitespace-nowrap overflow-hidden px-[1px]"> {{ $kiosk->device_name }}</span>
                                                                </div>
                                                            </div>
                                                        </label>


                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('selectedKiosk')
                                                <div class="mt-2 text-xs text-red-500 ">{{ $message }}</div>
                                            @enderror

                                        @else
                                            <div class="w-full flex justify-center items-center  ">
                                                <span class="text-xs text-primary_red text-center ">
                                                    {{ __('main.nokiosksavilable_signpdf') }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- langauge --}}
                                    <div >
                                        <label for="language" class="block text-xs font-medium text-gray-700">{{ __('main.selectlanguage') }}</label>
                                        <select wire:model.defer="selectedLanguage" id="language" name="language" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 xs:text-xs text-sm">

                                            @foreach ($current_languages as $language )

                                                <option {{  $language['code']=="en"?"selected":""  }} class="text-sm" value="{{ $language['code'] }}">{{ $language['name'] }}</option>
                                            @endforeach
                                        </select>

                                        @error('selectedLanguage')
                                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- end  sign settigs --}}

                        {{-- select language --}}
                        <div  class=" w-full p-4  rounded-[0.5rem] bg-white  xs:my-2 xs:p-2 drop-shadow mb-2 ">
                            <div class="flex mb-4 text-black justify-between items-center "  >
                                <h1 class=" text-sm font-bold" >{{ __('main.formmessage') }}</h1>
                            </div>
                            <div class="">
                                @foreach ($fileMessages as $index=> $message )
                                <div class="my-2">
                                    <span class="text-xs font-bold text-secondary_blue">{{ $message['language'] }}</span>
                                    <h1 class="whitespace-normal text-xs">{{ $message['message'] }}</h1>
                                </div>
                                @endforeach
                            </div>

                            <div class="grid justify-end items-center">
                                <span class="text-xs text-center">{{ __('main.edit') }}</span>
                                <svg data-toggle="modal"
                                data-target="#editmessages"
                                class="w-6 h-6  text-svg_primary hover:text-secondary_blue hover:cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                    <g id="SVGRepo_iconCarrier"> <path d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                </svg>

                            </div>
                        </div>
                        {{-- end select language --}}


                    </div>

                    {{-- pdf view  --}}
                    <div wire:ignore target="signPdf"  class="col-span-9   px-2 pb-2 border-[1px] border-gray-400  rounded-[0.5rem] bg-white
                     min-h-[95vh] max-h-full    drop-shadow"  >

                        <div class="flex justify-center  items-center space-x-12 my-2 ">


                                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                <svg id="prev" class="w-6 h-6 text-secondary_blue hover:cursor-pointer" fill="currentColor"  viewBox="0 0 24 24" id="previous" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color" transform="rotate(0)">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                <g id="SVGRepo_iconCarrier">
                                <path id="primary" d="M17.45,2.11a1,1,0,0,0-1.05.09l-12,9a1,1,0,0,0,0,1.6l12,9a1,1,0,0,0,1.05.09A1,1,0,0,0,18,21V3A1,1,0,0,0,17.45,2.11Z" style="fill: currentColor;"/>
                                </g>
                                </svg>

                                <h1 >Page: <span id="page_num"></span> / <span id="page_count"></span></h1>

                                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                <svg fill="currentColor" id="next" class="w-6 h-6 text-secondary_blue hover:cursor-pointer" viewBox="0 0 24 24" id="previous" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color" transform="rotate(180)">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                <g id="SVGRepo_iconCarrier">
                                <path id="primary" d="M17.45,2.11a1,1,0,0,0-1.05.09l-12,9a1,1,0,0,0,0,1.6l12,9a1,1,0,0,0,1.05.09A1,1,0,0,0,18,21V3A1,1,0,0,0,17.45,2.11Z" style="fill: currentColor;"/>
                                </g>
                                </svg>



                            {{-- <x-jet-button id="next" class="ml-3" type="button" onclick="addSignature()"  >
                                {{ __('Add Signature') }}
                            </x-jet-button> --}}

                        </div>
                        <div class="relative flex justify-center items-center  min-h-[90vh] max-h-full overflow-auto ">
                            <canvas class="absolute top-0 left-1/4 xs:left-0 border border-gray-200" width="595" height="842"  id="canvasPdf"></canvas>
                            <canvas class="absolute top-0 left-1/4 xs:left-0 border border-gray-200" width="595" height="842"   id="canvasRect"></canvas>
                        </div>

                    </div>


                </div>

            </div>


        {{-- modal of sign setting --}}

        {{-- modal of edit messages --}}
        <div wire:ignore  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="editmessages" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[1000px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
                <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
                    outline-none ">
                    {{-- header --}}
                    <div class="flex items-center space-x-10 justify-between p-4 border-b rounded-t ">
                        <div class="grid">
                            <div class="bg-primary_blue rounded-[0.5rem] px-2 py-1  grid grid-cols-2 space-x-1 items-center ">
                            <span class="text-sm font-bold text-left col-span-1">{{ __('main.editmessage') }}</span>

                            </div>
                        </div>
                        <button   type="button"   class="close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                            items-center "  data-dismiss="modal" aria-label="Close">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                            011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    {{-- end header --}}
                    {{-- body --}}
                    <div class="grid p-4">
                           <form wire:submit.prevent="editMessages">
                            @foreach ($fileMessages as $index=> $message )

                             <div class="my-4">
                                <label for="formmessages-{{ $index }}" class="inline-flex items-center justify-between w-full p-1
                                text-gray-500 bg-white hover:text-gray-600 hover:bg-gray-100 ">
                                {{ $message['language'] }}
                                </label>

                                <textarea maxlength="250" value="{{ $message['message'] }}" type="text" id="formmessages-{{ $index }}"
                                name="formmessages-{{ $index }}" class=" w-full  mr-2  bg-gray-50 border border-gray-300 text-gray-900 text-sm
                                rounded-lg focus:ring-blue-500 focus:border-blue-500 block   px-2 max-h-[100px]"  wire:model.defer="fileMessages.{{$index}}.message"   required></textarea>
                            </div>
                            @endforeach

                    </div>

                    {{-- end body --}}
                    {{-- footer --}}

                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">

                        <x-jet-secondary-button data-dismiss="modal" aria-label="Close"   type="button"  wire:loading.attr="disabled">
                        {{ __('main.cancel') }}
                        </x-jet-secondary-button>
                        <x-jet-button   class="ml-3" type="submit" wire:loading.attr="disabled">
                            {{ __('main.save') }}
                        </x-jet-button>


                    </div>
                    </form>
                    {{-- end footer --}}
                </div>
            </div>
       </div>


</div>

@push('scripts')
<script src="{{ asset('js/index.min.js')}}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js')}}"></script>
<script defer src="{{ asset('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js')}}" defer></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js') }}"></script>
{{-- detect the start date of expiry  --}}
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js";
    var canvasPdf = document.getElementById('canvasPdf');
    var canvasRect = document.getElementById('canvasRect');
    var ctxRect = canvasRect.getContext('2d');
    var form_id;
    var signed=false;
    let rect = {
        x: 50,
        y: 50,
        width: 180,
        height: 90,
        color: '#FFFF00',
        isDragging: false,
        offsetX: 0,
        offsetY: 0,
        draw:false,
    };
    let defultRect = {
        x: 50,
        y: 50,
        width: 180,
        height: 90,
        color: '#FFFF00',
        isDragging: false,
        offsetX: 0,
        offsetY: 0,
        draw:false,
    };
    var ctxPdf;
    var PdfSize;
    var start=null,end=null;
    var url,filePath,pdfDoc = null;
    var pageNum = 1,pageRendering = false,pageNumPending = null,scale = 1;
    //  check if there are previous files foor this form

    document.addEventListener('DOMContentLoaded', function() {
        // Emit a Livewire event

        Livewire.emit('checkPrevFile');
    });
    // new file
    document.addEventListener('file-uploaded', event =>  {
        pageNum = 1;
        rect=defultRect;
        url = event.detail.uploadedFileInfo.path;
        PdfSize= event.detail.uploadedFileInfo.size;
        canvasPdf.height = parseInt(PdfSize['height'], 10);
        canvasPdf.width = parseInt(PdfSize['width'], 10);
        canvasRect.height = parseInt(PdfSize['height'], 10);
        canvasRect.width = parseInt(PdfSize['width'], 10);
        filePath =`{{ asset('${url}') }}`;

        ctxPdf = canvasPdf.getContext('2d');
        let image = new Image();


        document.getElementById('prev').addEventListener('click', onPrevPage);
        document.getElementById('next').addEventListener('click', onNextPage);

        // initial pdf into canvas
        pdfjsLib.getDocument(filePath).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page_count').textContent = pdfDoc.numPages;

                // Initial/first page rendering
                renderPage(pageNum);

        });

        // sign
        addSignature();




    });
    // previous file
    document.addEventListener('prevfile-uploaded', event =>  {

        url = event.detail.uploadedFileInfo.path;
        pageNum=event.detail.uploadedFileInfo.pageNum;
        PdfSize= event.detail.uploadedFileInfo.size;
        canvasPdf.height = parseInt(PdfSize['height'], 10);
        canvasPdf.width = parseInt(PdfSize['width'], 10);
        canvasRect.height = parseInt(PdfSize['height'], 10);
        canvasRect.width = parseInt(PdfSize['width'], 10);
        filePath =`{{ asset('${url}') }}`;

        ctxPdf = canvasPdf.getContext('2d');

      // Replace 'drawButton' with the actual id of your draw button

        document.getElementById('prev').addEventListener('click', onPrevPage);
        document.getElementById('next').addEventListener('click', onNextPage);

        // initial pdf into canvas
        pdfjsLib.getDocument(filePath).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page_count').textContent = pdfDoc.numPages;
                // Initial/first page rendering
            renderPage(pageNum);
        });

        setRectCoordinates(event.detail.uploadedFileInfo);





    });
    // error
    document.addEventListener('error', event =>  {
        const errorMessage=event.detail.message;
        const title=event.detail.title;


        Swal.fire({
            icon: 'error',
            title: title,
            text: errorMessage,
            confirmButtonColor:'#1277D1',
            })
    });


    //    queue for render pages
    function queueRenderPage(num) {
        if (pageRendering) {
        pageNumPending = num;
        } else {
        renderPage(num);
        }
    }
    // render page
    function renderPage(num) {
        pageRendering = true;
       num= parseInt(num, 10);
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function(page) {
        var viewport = page.getViewport({scale: scale});


        // Render PDF page into canvas context
        var renderContext = {
            canvasContext: ctxPdf,
            viewport: viewport
        };
        var renderTask = page.render(renderContext);
            // Draw the initial rectangle
            renderTask.promise.then(function () {
            pageRendering = false;
            if (pageNumPending !== null) {
                renderPage(pageNumPending);
                pageNumPending = null;
            }
        });






        // Wait for rendering to finish
        renderTask.promise.then(function() {
            pageRendering = false;
            if (pageNumPending !== null) {
            // New page rendering is pending
            renderPage(pageNumPending);
            pageNumPending = null;
            }
        });
        });

        // Update page counters
        document.getElementById('page_num').textContent = num;
    }
    //when click on prev page button
    function onPrevPage() {
        if (pageNum <= 1) {
        return;
        }
        pageNum--;
        queueRenderPage(pageNum);
    }
    //when click on next page button
    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
        return;
        }
        pageNum++;
        queueRenderPage(pageNum);
    }

    //  set  coordinates of rect if uploaded previous file
    function setRectCoordinates(uploadedFileInfo){
        rect.x = parseFloat(uploadedFileInfo.start_cx);
        rect.y = parseFloat(uploadedFileInfo.start_cy);
        rect.width = Math.abs(parseFloat(uploadedFileInfo.end_cx) - parseFloat(uploadedFileInfo.start_cx));
        rect.height = Math.abs(parseFloat(uploadedFileInfo.end_cy) - parseFloat(uploadedFileInfo.start_cy));

        canvasRect.addEventListener('mousedown', handleMouseDown);
        canvasRect.addEventListener('mouseup', handleMouseUp);
        canvasRect.addEventListener('mousemove', handleMouseMove);
      
        drawRect();
    }

    //add signature rect when click on add button
    function addSignature(){
        canvasRect.addEventListener('mousedown', handleMouseDown);
        canvasRect.addEventListener('mouseup', handleMouseUp);
        canvasRect.addEventListener('mousemove', handleMouseMove);
        drawRect();


    }
    //  draw rect
    function drawRect() {
        // Clear the rectangle canvas
        ctxRect.clearRect(0, 0, canvasRect.width, canvasRect.height);

        // Draw the rectangle on the separate canvas
        ctxRect.strokeStyle  = rect.color;
        // ctxRect.strokeRect(
        //                     Math.min(rect.x, rect.x+rect.width),
        //                     Math.min(rect.y, rect.y+rect.height),
        //                     Math.abs(rect.x, rect.x+rect.width),
        //                     Math.abs(rect.y, rect.y+rect.height)
        // );
        rect.draw=true;

        ctxRect.strokeRect(rect.x, rect.y, rect.width, rect.height);

    }
    // on mouse down effect
    function handleMouseDown(event) {

      const mouseX = parseFloat(event.clientX - canvasRect.getBoundingClientRect().left);
const mouseY = parseFloat(event.clientY - canvasRect.getBoundingClientRect().top);


        if (
            mouseX >= rect.x &&
            mouseX <= rect.x + rect.width &&
            mouseY >= rect.y &&
            mouseY <= rect.y + rect.height
        ) {
            rect.isDragging = true;
            rect.offsetX = mouseX - rect.x;
            rect.offsetY = mouseY - rect.y;
        }

    }
    // on mouse up effect
    function handleMouseUp() {
        rect.isDragging = false;



    }
    // on mouse move effect
    function handleMouseMove(event) {

        if (rect.isDragging) {
          const mouseX = parseFloat(event.clientX - canvasRect.getBoundingClientRect().left);
const mouseY = parseFloat(event.clientY - canvasRect.getBoundingClientRect().top);


            rect.x = mouseX - rect.offsetX;
            rect.y = mouseY - rect.offsetY;

            // Draw the rectangle on the separate canvas
            drawRect();
        }

    }
    // get coordinates of rect
    function getRectCoordinates() {
        const start_x = rect.x;
        const start_y = rect.y;
        const end_x = rect.x + rect.width;
        const end_y = rect.y + rect.height;

        // Adjust coordinates if needed based on your requirements

        return { start_x, start_y, end_x, end_y };
    }



    function validateForm() {
        // Get the form element by ID
        var form = document.getElementById('signForm');

        // Use the checkValidity() method to trigger the browser's built-in validation
        if (form.checkValidity()) {
            // If the form is valid, you can proceed with your logic
            // For example, you might want to submit the form
            return true;
        } else {
            // If the form is not valid, you can display an error message or take other actions

            return false;
        }
    }
    // when click on sign button
    function SignPdf(){









          // Now, the selectedKiosks array contains the values of checked checkboxes

            const rectCoordinates = getRectCoordinates();
            start = {
                    x: (rectCoordinates.start_x / (842/297)),
                    y: (rectCoordinates.start_y / (842/297)),
                    clientX:rectCoordinates.start_x,
                    clientY:rectCoordinates.start_y,
                };
            end = {
                    x: (rectCoordinates.end_x / (842/297)),
                    y: (rectCoordinates.end_y / (842/297)),
                    clientX:rectCoordinates.end_x,
                    clientY:rectCoordinates.end_y,
                };


            Livewire.emit('signPdf',start.x,start.y,end.x,end.y,start.clientX,start.clientY,end.clientX,end.clientY,pageNum);

        // }
        // else
        // alert('Please fill in all required fields.');
        }

</script>
<script>
//   success message for send pdf to signed
// close modal

    var flashedMessage_messagessaved= document.getElementById('flashedMessage_messagessaved').value;

     if(flashedMessage_messagessaved)
    {
        Swal.fire({
            icon: 'success',
            title:'Successfully Saved messages',
            text:flashedMessage_messagessaved,
            confirmButtonColor:'#1277D1',

    })
    }





</script>

@endpush
