
@push('styles')
<link
  rel="stylesheet"
  href="{{ asset('/styles/index.min.css') }}" />
  <link  rel="stylesheet" href="{{ asset('styles/bootstrap.min.css')}}">

@endpush

<div   class="h-screen overflow-hidden xs:overflow-auto xs:h-full">
    <div id="toast-update" class="hidden absolute z-50 w-full max-w-xs top-5 right-5  text-sm  border-t-4 rounded-l-full rounded-r-full rounded border-secondary_blue text-secondary_blue bg-primary_blue px-4 py-3 shadow" role="alert">
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
    </div>
    <div  wire:loading.class="flex z-[100]" wire:loading.remove.class="hidden" class="hidden  justify-center items-center absolute top-1/2 right-[44%] ">
        <svg class="animate-spin h-10 w-10 mr-1 text-secondary_blue" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
          </svg>

          <span class="text-sm">{{ __('Please Wait...') }}</span>
    </div>
    <input type="hidden" id="flashedMessage" value="{{ session('success_message') }}">
    <input type="hidden" id="flashedMessage_error" value="{{ session('error_message') }}">

    <div wire:loading.class="disabled opacity-50 animate-pulse" class="grid grid-rows-12 min-h-screen">






            {{-- form info --}}

        @if($current_form!=null)

            <div class="w-full h-full  row-span-12 mt-4  ">


                 {{-- form settings --}}
                <div class="grid xs:block 2xl:grid-cols-12 xl:grid-cols-12 lg:grid-cols-12 md:grid-cols-12 gap-2   ">
                    {{-- form settings --}}
                    <div class="col-span-3   " >


                        <div class="w-full flex justify-between space-x-4 items-center p-4  rounded-[0.5rem] bg-white  xs:my-2 xs:p-2 drop-shadow mb-2">
                            {{-- preview  hover:cursor-pointer ease-in delay-100  hover:-translate-z-1 hover:scale-[1.1]  duration-200--}}

                            <a target="_blank" href="{{ route('preview',$current_form->id) }}" class="bg-gray-400 rounded hover:no-underline  p-2  h-16 w-[35%]  xs:my-2   xs:flex xs:justify-center xs:items-center ">
                                <div  class="flex justify-center items-center">

                                    <?xml  version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                    <svg class=" w-4 h-4 mx-1 text-white  cursor-pointer " fill="currentColor"  viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}</style></defs><title>task--view</title><circle cx="22" cy="24" r="2"/><path id="_inner_path_" data-name="&lt;inner path&gt;" class="cls-1" d="M22,28a4,4,0,1,1,4-4A4.0039,4.0039,0,0,1,22,28Zm0-6a2,2,0,1,0,2,2A2.0027,2.0027,0,0,0,22,22Z"/><path d="M29.7769,23.4785A8.64,8.64,0,0,0,22,18a8.64,8.64,0,0,0-7.7769,5.4785L14,24l.2231.5215A8.64,8.64,0,0,0,22,30a8.64,8.64,0,0,0,7.7769-5.4785L30,24ZM22,28a4,4,0,1,1,4-4A4.0045,4.0045,0,0,1,22,28Z"/><path d="M12,28H7V7h3v3H22V7h3v9h2V7a2,2,0,0,0-2-2H22V4a2,2,0,0,0-2-2H12a2,2,0,0,0-2,2V5H7A2,2,0,0,0,5,7V28a2,2,0,0,0,2,2h5ZM12,4h8V8H12Z"/><rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;" class="cls-1" width="32" height="32"/></svg>
                                </div>
                               <div class="flex justify-center">
                                <span class="mt-1 text-white text-sm">{{ __('Preview') }}</span>
                               </div>
                            </a>
                            {{-- share --}}
                            {{-- <button data-toggle="modal" data-target="#publishform"
                                onclick="showboxlink('{{ $current_form->url }}','{{ $current_subscribe->valid }}')"
                                type="button" class="bg-secondary_blue rounded  p-2  h-16 w-[65%]  xs:my-2   xs:flex xs:justify-center xs:items-center ">
                                <div  class="flex justify-center items-center">
                                    <svg class="w-4 h-4 mx-1 text-white  cursor-pointer " fill="CurrentColor"  viewBox="0 0 52 52" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                        <path d="m48.5 30h-3c-0.8 0-1.5 0.7-1.5 1.5v11c0 0.8-0.7 1.5-1.5 1.5h-33c-0.8 0-1.5-0.7-1.5-1.5v-21c0-0.8 0.7-1.5 1.5-1.5h4c0.8 0 1.5-0.7 1.5-1.5v-3c0-0.8-0.7-1.5-1.5-1.5h-7.5c-2.2 0-4 1.8-4 4v28c0 2.2 1.8 4 4 4h40c2.2 0 4-1.8 4-4v-14.5c0-0.8-0.7-1.5-1.5-1.5z m-14.5-16c-10 0-19.1 8.9-19.9 19.4-0.1 0.8 0.6 1.6 1.5 1.6h3c0.8 0 1.4-0.6 1.5-1.3 0.7-7.5 7.1-13.7 14.9-13.7h1.6c0.9 0 1.3 1.1 0.7 1.7l-5.5 5.6c-0.6 0.6-0.6 1.5 0 2.1l2.1 2.1c0.6 0.6 1.5 0.6 2.1 0l13.6-13.5c0.6-0.6 0.6-1.5 0-2.1l-13.5-13.5c-0.6-0.6-1.5-0.6-2.1 0l-2.1 2.1c-0.6 0.6-0.7 1.5-0.1 2.1l5.6 5.6c0.6 0.6 0.2 1.7-0.7 1.7l-2.7 0.1z"></path>
                                        </g>
                                    </svg>
                                </div>
                               <div class="flex justify-center">
                                <span class="mt-1 text-white text-sm">{{ __('Publish') }}</span>
                               </div>
                            </button> --}}
                            <a href="{{ route('kiosks') }}" class="bg-secondary_blue rounded hover:no-underline  p-2  h-16 w-[65%]  xs:my-2   xs:flex xs:justify-center xs:items-center ">
                                <div  class="flex justify-center items-center">

                                        <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                        <svg class="w-4 h-4 mx-1 text-white  cursor-pointer " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.0005 15.9995L15.0005 11.9995M15.0005 11.9995L11.0005 7.99951M15.0005 11.9995H3.00049M11.0005 2.99951H17.7997C18.9198 2.99951 19.4799 2.99951 19.9077 3.2175C20.284 3.40925 20.59 3.71521 20.7817 4.09153C20.9997 4.51935 20.9997 5.07941 20.9997 6.19951V17.7995C20.9997 18.9196 20.9997 19.4797 20.7817 19.9075C20.59 20.2838 20.284 20.5898 19.9077 20.7815C19.4799 20.9995 18.9198 20.9995 17.7997 20.9995H11.0005" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                </div>
                                <div class="flex justify-center">
                                    <span class="mt-1 text-white text-sm">{{ __('Link to kiosk') }}</span>
                                </div>
                            </a>


                        </div>

                        {{-- form Information --}}
                        <div class=" w-full p-4  rounded-[0.5rem] bg-white  xs:my-2 xs:p-2 drop-shadow mb-2">
                            <div class="flex mb-4 text-black justify-between items-center "  >
                                <span class=" px-1 mr-1 text-sm font-bold" >{{ __('Form Inforamtion') }}</span>
                            </div>
                            <div class="grid grid-cols-12  PX-1">
                                <div class="col-span-12">
                                    {{-- form title --}}
                                    <div class="w-full  flex  space-x-1 "  >
                                        <span class="whitespace-nowrap text-sm">
                                            <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('The form title will help your audience to know the purpose of your form or to identify you, make sure to give a clear one.') }}">
                                                <svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                                </svg>
                                            </a>
                                            {{ __('Form Title:') }}
                                        </span>
                                        <span class="text-secondary_blue text-sm">{{ $current_form->form_title }}</span>
                                    </div>

                                </div>

                                {{-- bussines logo --}}
                                <div  class=" col-span-12 mt-4" >
                                    <div class="felx justify-between space-x-[1px]">
                                        <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('The form logo gives you branding credibility and helps your audience to recognise your business.') }}">
                                            <svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                            </svg>
                                        </a>
                                      <span class="whitespace-nowrap text-sm">{{ __('Form Logo') }}</span>
                                    </div>
                                    <div class="flex justify-between items-end">
                                        <div class="border-2 rounded-lg border-gray-400  max-w-[120px] max-h-[90px] min-h-[90px] min-w-[120px] w-[120px] h-[90px] p-1  flex justify-center " >
                                            <img  class="object-contain w-full h-full" src="{{ asset($current_form->logo_url) }}" alt="">
                                        </div>
                                        {{-- edit form  --}}
                                        <div class="grid justify-end items-center">
                                            <span class="text-xs text-center">{{ __('Edit') }}</span>
                                            <svg data-toggle="modal" data-target="#addform"
                                            wire:click="$emit('edit_form',{{ json_encode($current_form->form_title)}},{{ json_encode($current_form->business_name)}},{{ json_encode($current_form->logo_url)}},{{ json_encode($current_form->form_id)}})"
                                            class="w-6 h-6  text-svg_primary hover:text-secondary_blue hover:cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                <g id="SVGRepo_iconCarrier"> <path d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                            </svg>

                                        </div>
                                    </div>
                                </div>



                            </div>

                        </div>
                        {{-- end form information --}}

                        {{-- web options --}}
                        <div  class=" w-full p-4  rounded-[0.5rem] bg-white  xs:my-2 xs:p-2 drop-shadow mb-2 ">
                            <div class="flex mb-4 text-black justify-between items-center "  >
                                <h1 class="px-1 mr-1 text-sm font-bold" >{{ __('Form Options') }}</h1>
                            </div>

                            <div class=" px-1 items-center " >

                                {{-- in service --}}
                                <div class="grid w-full   mt-2   items-center"  >

                                    <div class="align-center" >
                                        <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('This option allows you to switch form (Active) meaning people can submit responses to this form, whether from a shared link or from a connected kiosk, or (Inactive), meaning this form will not be visible to people and responses can not be submitted whether from a shared link or from a connected kiosk.') }}">
                                            <svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                            </svg>
                                        </a>
                                        <span class="{{ $current_form->active?"text-valid":"text-primary_red" }}  text-sm " >{{ $current_form->active?__('Active'):__('Inactive') }}</span>
                                    </div>

                                    <div class="" >
                                            <label class="ml-4 relative inline-flex items-center cursor-pointer">

                                            <input type="checkbox" wire:model="service"  value="" {{ $current_form->active?"checked":"" }} class="sr-only peer"

                                            >
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none
                                            rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                                            after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                                 peer-checked:bg-secondary_blue"></div>

                                            </label>
                                    </div>
                                </div>
                                {{-- score --}}
                                <div class="grid w-full   mt-2   items-center"  >

                                    <div class="align-center" >
                                        <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('This option allows you to choose if you would like people to see their final score at the end of the form, the final score is based on the scores you have assigned to each answer in your form questions.') }}">
                                                <svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                                </svg>
                                        </a>
                                        <span class="text-black  text-sm " >{{ __('Show the score at the end of form') }}</span>
                                    </div>

                                    <div class="" >
                                            <label class="ml-4 relative inline-flex items-center cursor-pointer">

                                            <input type="checkbox" wire:model="score" value="" {{ $current_form->score?"checked":"" }} class="sr-only peer"

                                            >
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none
                                                rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                                                after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                                 peer-checked:bg-secondary_blue"></div>

                                            </label>
                                    </div>
                                </div>
                                {{-- terms --}}
                                <div class="grid w-full   mt-2   items-center"  >

                                    <div class="align-center" >
                                        <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('When this option is on, audience must accept the terms & conditions that you describe before the form begins, if they choose to disagree, the form will be ended immediately.') }}">
                                                <svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                                </svg>
                                        </a>
                                        <span class="text-black  text-sm " >{{ __('Audience must accept our terms before start form') }}</span>
                                    </div>
                                    <div class="flex space-x-1 items-center">
                                        <div class="" >
                                                <label class="ml-4 relative inline-flex items-center cursor-pointer">

                                                <input {{ $current_subscribe->form_terms==false?"disabled":"" }} type="checkbox" wire:model="terms" value="" {{ $current_form->terms?"checked":"" }} class="sr-only disabled:opacity-50 peer"

                                                >
                                                <div class="{{ $current_subscribe->form_terms==false?"opacity-50":"" }} w-11 h-6 bg-gray-200 peer-focus:outline-none
                                                    rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                                                    after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                                     peer-checked:bg-secondary_blue">
                                                </div>

                                                </label>

                                        </div>
                                        @if($current_form->terms)
                                            <div>
                                                {{-- <a wire:click="$emit('edit_terms',{{ json_encode($current_message) }})"  type="button"
                                                    data-toggle="modal" data-target="#formterms"
                                                    class="text-sm text-secondary_blue hover:font-bold">
                                                    {{ __('Edit terms') }}
                                                </a> --}}
                                                <a onclick="ShoweditTermsHint()" class="text-sm text-secondary_blue hover:font-bold hover:cursor-pointer">
                                                    {{ __('Edit terms') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- expiry --}}
                                <div class=" w-full  mt-2  grid grid-cols-12  justify-between  items-center"  >
                                    <div class=" grid col-span-12  items-center" >
                                        <span class="text-black text-sm  " >
                                            <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('This option allows you to automatically switch this form as (Inactive) on a specific date, to stop responses. You can always switch it back to (Active) anytime manually.') }}">
                                                <svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                                </svg>
                                            </a>
                                            {{ __('Set form as inactive automatically on date') }}
                                        </span>
                                        <label class="ml-4 relative inline-flex items-center cursor-pointer">

                                            <input disabled type="checkbox" wire:model="formexpiry" value="" {{ $current_form->expiry?"checked":"" }} class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none
                                            rounded-full peer peer-checked:after:translate-x-full
                                             peer-checked:after:border-white after:content-[''] after:absolute
                                            after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300
                                            after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                                 peer-checked:bg-secondary_blue"></div>

                                        </label>
                                    </div>

                                    <div class=" col-span-12 w-1/2" >
                                        <input disabled   {{ $current_form->expiry?"wire:ignore":"disabled" }} type="date" name="expiry-date" id="expiry-date"
                                        wire:model="formexpirydate" value="" class=" w-full h-8 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                        focus:ring-blue-500 {{ $current_form->expiry?"":"opacity-50" }} ml-4
                                                focus:border-secondary_blue block    "/>
                                    </div>
                                </div>


                            </div>
                        </div>
                        {{-- end web options --}}

                        {{-- linked devices --}}
                        <div class=" w-full p-4  rounded-[0.5rem]  bg-white xs:my-2 xs:p-2 drop-shadow mb-2">
                            <div class="flex mb-4 text-black justify-between items-center"  >
                                <h1 class="px-1 mr-1 text-sm font-bold" >{{ __('Linked Kiosks') }} </h1>
                                @if(count($current_form_kiosks)>0)
                                    <div class="flex space-x-2 justify-end items-center">
                                        @php
                                            $service=0;
                                            foreach ($current_form_kiosks as $key => $value) {
                                                $value->in_service==1?$service+=1:$service=$service;
                                            }
                                        @endphp
                                        <div class="grid ">
                                            <div class="flex w-full justify-center items-center">
                                                <div class="rounded-full h-5 w-5 bg-valid flex justify-center items-center  ">
                                                        <span class="text-center text-xs text-white">{{ $service }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid ]">
                                            <div class="flex w-full justify-center items-center">
                                                <div class="rounded-full h-5 w-5 bg-primary_red flex justify-center items-center  ">
                                                        <span class="text-center text-xs text-white">{{ count($current_form_kiosks)-$service }}</span>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                @endif
                            </div>
                            <div class="mt-1 mb-1 container w-full overflow-hidden h-full" >

                                @if(count($current_form_kiosks)>0)
                                <div class="mt-1 mb-1 owl-form owl-carousel owl-theme align-content-center  px-2">

                                    @foreach ( $current_form_kiosks as $kiosk)
                                        <div  wire:key="{{ $kiosk->id }}"    class="  item relative  w-full " >
                                            <div class="border-[1px] border-gray-400 rounded-[0.5rem] p-1 w-full">

                                                <div class="flex justify-between space-x-2 items-center">
                                                    {{-- kiosk icon --}}
                                                    <div class=" relative">
                                                        <div class="rounded-full h-[6px] w-[6px] left-[0px] absolute
                                                        {{ $kiosk->in_service?"bg-valid":"bg-primary_red" }} ">
                                                        </div>
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


                                        </div>
                                    @endforeach
                                </div>

                                @else
                                    <div class="w-full flex justify-center items-center "><span class="text-sm text-primary_red text-center">{{ __('No linked kiosks') }}</span></div>
                                @endif




                            </div>
                            {{-- link to device  --}}

                            {{-- <div class="mt-1 flex justify-between">
                                <a class="{{ $current_form->updating==false?"hidden":"" }} text-blue-400 hover:cursor-pointer hover:no-underline p-1 rounded-xl border-[1px] border-gray-200 hover:bg-slate-100 " wire:click="updateformonkiosks()">update</a>
                            </div> --}}
                        </div>
                        {{-- end linked devices --}}
                    </div>

                    {{-- form questions --}}
                    <div  class="col-span-9   px-2 pb-2 border-[1px] border-gray-400  rounded-[0.5rem] bg-white    drop-shadow"  >
                            <div>
                                <div class="grid grid-cols-3 min-h-[80px] ">
                                    <div class="block col-span-1  p-1">
                                        <span class="font-bold text-sm ">{{ __('Form Components') }}</span>
                                    </div>
                                    <div class="grid col-span-1 justify-center items-center my-2">

                                        <div  class="flex justify-center items-center" id="addquestionbutton1" >

                                            <svg  wire:click="$emit('add',{{ json_encode($current_form_id)}},{{json_encode($local)}},{{ json_encode($this->formlanguages) }})"
                                                data-toggle="modal" data-target="#addquestion"
                                                class="w-10 h-10  hover:cursor-pointer ease-in delay-100  hover:-translate-z-1 hover:scale-[1.2] duration-200"
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                <g id="SVGRepo_iconCarrier"> <path opacity="0.5" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" fill="#1277d1"/> <path d="M12.75 9C12.75 8.58579 12.4142 8.25 12 8.25C11.5858 8.25 11.25 8.58579 11.25 9L11.25 11.25H9C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75H11.25V15C11.25 15.4142 11.5858 15.75 12 15.75C12.4142 15.75 12.75 15.4142 12.75 15L12.75 12.75H15C15.4142 12.75 15.75 12.4142 15.75 12C15.75 11.5858 15.4142 11.25 15 11.25H12.75V9Z" fill="#1277d1"/> </g>
                                            </svg>
                                        </div>

                                        <div><span class="text-xs text-center">{{ __('Add Question') }}</span></div>
                                    </div>
                                </div>
                                <div class="flex xs:grid justify-between border rounded-md  border-gray-200  mb-4">
                                    <ul class="flex  -mb-px" id="tabs-tab3"role="tablist" data-te-nav-ref>
                                        @foreach ($formlanguages as $lang )


                                                        <li wire:click="changelocal({{ $lang['id'] }})"  class="  border-r-2 px-[2px] "  role=" presentation">
                                                            <a   href="#tabs-{{ $lang['code'] }}"    class=" flex border-x-0 border-t-0 border-b-2 border-transparent  text-sm font-medium
                                                            h-full leading-tight text-neutral-500 hover:isolate  hover:bg-neutral-100 focus:isolate
                                                            data-[te-nav-active]:border-secondary_blue data-[te-nav-active]:text-secondary_blue py-[1px] no-underline hover:no-underline focus:no-underline "
                                                            id="{{ $lang['code'] }}-tab"  data-te-toggle="pill"
                                                            data-te-target="#tabs-{{ $lang['code'] }}" {{ $local==$lang['code']?"data-te-nav-active":"" }}
                                                                role="tab" aria-controls="tabs-{{ $lang['code'] }}" aria-selected="false"  >
                                                                <div class="flex justify-between items-center">
                                                                    <svg wire:click="deletelanguageConfirmation({{ $lang['id'] }})" class="{{  count($formlanguages)==1?"hidden":"" }}  inline-block
                                                                    text-svg_primary hover:text-primary_red text-center w-[18px] h-[18px] ml-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" fill="currentColor" fill-opacity=".16" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"/>
                                                                    <path d="M8 12h8" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                                                    </g>
                                                                    </svg>
                                                                    <span  class="px-2 ">{{ $lang['name'] }}</span>
                                                                </div>
                                                            </a>
                                                        </li>

                                        @endforeach
                                        {{-- add languages button --}}

                                        <li data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('Add New Language') }}"
                                            class="{{  count($formlanguages)==4?"hidden":"" }} m-1 xs:text-xs flex justify-center items-center "  >

                                                <svg id="dropdownRadioButton" data-dropdown-toggle="dropdownDefaultRadio"  class="w-6 h-6  hover:cursor-pointer text-svg_primary hover:text-secondary_blue " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="Edit / Add_To_Queue">
                                                    <path id="Vector" d="M3 9V19.4C3 19.9601 3 20.2399 3.10899 20.4538C3.20487 20.642 3.35774 20.7952 3.5459 20.8911C3.7596 21 4.0395 21 4.59846 21H15.0001M14 13V10M14 10V7M14 10H11M14 10H17M7 13.8002V6.2002C7 5.08009 7 4.51962 7.21799 4.0918C7.40973 3.71547 7.71547 3.40973 8.0918 3.21799C8.51962 3 9.08009 3 10.2002 3H17.8002C18.9203 3 19.4801 3 19.9079 3.21799C20.2842 3.40973 20.5905 3.71547 20.7822 4.0918C21.0002 4.51962 21.0002 5.07969 21.0002 6.19978L21.0002 13.7998C21.0002 14.9199 21.0002 15.48 20.7822 15.9078C20.5905 16.2841 20.2842 16.5905 19.9079 16.7822C19.4805 17 18.9215 17 17.8036 17H10.1969C9.07899 17 8.5192 17 8.0918 16.7822C7.71547 16.5905 7.40973 16.2842 7.21799 15.9079C7 15.4801 7 14.9203 7 13.8002Z" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </g>
                                                </svg>

                                            <div id="dropdownDefaultRadio" class="z-20 hidden w-auto bg-white divide-y divide-gray-100 rounded-lg shadow  ">
                                                <ul class="p-3 space-y-1 text-sm text-gray-700  border-[1px] rounded-lg border-gray-200" aria-labelledby="dropdownRadioButton">
                                                    @foreach ($main_languages as $main_lan )

                                                    @if(! $this->formlang($main_lan['id']))

                                                    <li  wire:click="addlang('{{ $main_lan['code'] }}')"
                                                        class=" hover:cursor-pointer p-2 text-black hover:text-secondary_blue hover:font-bold  text-center">
                                                        <span>{{ $main_lan['name'] }}</span >
                                                    </li>
                                                    @endif
                                                    @endforeach


                                                </ul>
                                            </div>
                                        </li>
                                        {{-- end add languages btn  --}}
                                    </ul>
                                    <div class="flex items-center">
                                     <div class="flex">
                                       <span class="text-sm">{{ __('Question:') }}</span><span class="text-sm text-secondary_blue">{{ count($current_questions).'/'.$this->current_subscribe->num_questions }}</span>
                                     </div>
                                    <div class="m-1 xs:text-xs flex justify-center space-x-4 items-center">
                                        {{-- translation notification --}}
                                        <div>
                                            <svg onclick="ShowAlertTranslation()"  class="{{$current_form->trans_notification?"text-primary_red animate-pulse":"text-svg_primary"  }} w-6 h-6 hover:cursor-pointer " fill="CurrentColor"  viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <g data-name="Layer 2"><g data-name="menu-arrow-circle"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/>
                                                <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"/>
                                                <path d="M12 6a3.5 3.5 0 0 0-3.5 3.5 1 1 0 0 0 2 0A1.5 1.5 0 1 1 12 11a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0v-1.16A3.49 3.49 0 0 0 12 6z"/><circle cx="12" cy="17" r="1"/></g>
                                                </g>
                                            </svg>
                                        </div>

                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div   class="overflow-y-auto  max-h-[80vh] min-h-[80vh]  "  >
                                @php
                                     foreach ($formlanguages as $lan )
                                     if($local==$lan['code'])
                                     $current_language=$lan;

                                @endphp

                                @if($current_message!=null)
                                    {{-- welcome message --}}
                                        <li   class="list-none mr-1 ml-1 bg-gray-50 p-4 mt-2 hover:bg-slate-100 hover:border-2 hover:border-blue-300  rounded-lg  " >
                                            <div class="flex justify-between" >
                                                <div class="w-1/3 max-w-1/3">
                                                    <span class="mx-[1px] rounded bg-[#faebd7] text-black p-[2px] text-sm ">{{ __('🆂 Start Page') }}</span>
                                                    <span class="mx-[1px] rounded bg-blue-300 p-[2px] text-sm">{{ $current_language['name'] }}</span>
                                                </div>
                                                <div class="flex justify-between" >
                                                    <a wire:click="$emit('edit_message',{{ json_encode('Start') }},{{ json_encode($current_message) }})"  type="button"  data-te-toggle="modal"
                                                        data-te-target="#editmessage"
                                                        data-te-ripple-init
                                                        class="ml-1 mr-1" ><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                                                        <svg class="h-6 w-6 text-svg_primary hover:text-secondary_blue focus:text-secondary_blue"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <g id="SVGRepo_iconCarrier"> <path d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="flex justify-center">
                                                <h1 class="text-center"> {{ $current_message->form_start_header }}</h1>
                                            </div>
                                            <div class="mt-8 flex justify-center">
                                                <h1 class="text-center"> {{ $current_message->form_start_text }}</h1>
                                            </div>


                                        </li>
                                    {{-- terms --}}
                                    @if($current_form->terms&&$current_subscribe->form_terms!=false)
                                    <li   class=" list-none mr-1 ml-1 bg-gray-50 p-4 mt-2 hover:bg-slate-100 hover:border-2 hover:border-blue-300  rounded-lg " >
                                        <div class="flex justify-between " >

                                            <div class="w-1/3 max-w-1/3">
                                                <span class="mx-[1px] rounded bg-[#faebd7] text-black p-[2px] text-sm">{{ __('☒ Terms & Conditions') }}</span>
                                                <span class="mx-[1px] rounded bg-blue-300 p-[2px] text-sm">{{ $current_language['name'] }}</span>
                                            </div>
                                            <div class="flex justify-end" >
                                                {{-- edit terms --}}
                                                <a wire:loading="disabled"  wire:click="$emit('edit_terms',{{ json_encode($current_message) }})"  type="button"
                                                    data-toggle="modal"
                                                    data-target="#formterms"
                                                    class="ml-1 mr-1" >
                                                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                                                    <svg class="h-6 w-6 text-svg_primary hover:text-secondary_blue focus:text-secondary_blue"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <g id="SVGRepo_iconCarrier"> <path d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                                    </svg>
                                                </a>
                                                {{-- delete terms --}}
                                                {{-- <a wire:click="deletetermsConfirmation({{ $current_message->form_id }})" class="ml-1 mr-1   hover:text-red-400" ><svg class="h-6 w-6 text-black hover:text-red-400 hover:cursor-pointer"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"
                                                    stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                    <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                                                </a> --}}

                                            </div>
                                        </div>
                                        <div class="flex justify-center max-h-[100px] overflow-auto p-2">
                                            <p class=" {{ $local=='en'||$local=='tl'?"text-left justify-start":"text-right justify-end" }}">{!! $current_message->terms !!}</p>
                                        </div>


                                    </li>
                                    @endif
                                @endif
                                {{-- end welcome message --}}

                                    @foreach ($formlanguages as $lan )


                                            <ul   class="{{ $local==$lan['code']?" opacity-100 ":"hidden opacity-0 " }}
                                                transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                                                wire:sortable="updateQuestionOrder"
                                                            role="list" id="tabs-{{ $lan['code'] }}" role="tabpanel" aria-labelledby="{{ $lan['code'] }}-tab" {{ $local==$lan['code']?"data-te-nav-active":"" }}>

                                                @foreach ($current_questions as $i=> $ques )
                                                            {{-- wire:sortable.item="{{ $ques['id'] }}" wire:key="question-{{ $current_form_id }}-{{ $ques['id'] }}" --}}


                                                            <li wire:sortable.item="{{ $ques['id'] }}" wire:key="{{ $current_form_id }}-{{ $lan['code'] }}-{{ $ques['id'] }}"
                                                                class="{{$ques['show']==false?"opacity-50":""  }} bg-gray-50 p-4 mt-2 hover:bg-slate-100 hover:border-2 hover:border-blue-300  rounded-lg  " >
                                                                <div class="flex justify-between" >
                                                                    <div class="w-1/3 max-w-1/3">
                                                                        <span class="mx-[1px] rounded bg-[#faebd7] text-black p-[2px] text-sm">{{ $ques['type'] }}</span>
                                                                        <span class="mx-[1px] rounded text-sm {{ $ques['optional']?"bg-green-100":"bg-red-100" }} p-[2px] "> {{ $ques['optional']?__('Optional'):__('Mandetory') }}</span>
                                                                        <span class="mx-[1px] rounded bg-blue-300 p-[2px] text-sm">{{ $lan['name'] }}</span>
                                                                    </div>
                                                                    <div class="w-1/3 max-w-1/3 justify-center flex items-center" >
                                                                        <span class="text-blue-900 font-bold  text-lg " >{{ $i+1}}</span>
                                                                    </div>
                                                                    <div class="max-w-1/3 w-1/3 space-x-1 flex justify-end items-center" >
                                                                        {{-- hidden question --}}
                                                                        <a type="button"  class="ml-1 mr-1 ">
                                                                            @if($ques['show']==true)

                                                                                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                                                <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                                                                                <svg wire:click="setQuestionShow({{ $ques['show'] }},{{ $ques['id'] }})" class=" h-6 w-6 text-valid hover:text-black " viewBox="0 0 24 24"  fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                <g id="SVGRepo_iconCarrier"> <path opacity="1" fill-rule="evenodd" clip-rule="evenodd" d="M15.1614 12.0531C15.1614 13.7991 13.7454 15.2141 11.9994 15.2141C10.2534 15.2141 8.83838 13.7991 8.83838 12.0531C8.83838 10.3061 10.2534 8.89111 11.9994 8.89111C13.7454 8.89111 15.1614 10.3061 15.1614 12.0531Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.998 19.355C15.806 19.355 19.289 16.617 21.25 12.053C19.289 7.48898 15.806 4.75098 11.998 4.75098H12.002C8.194 4.75098 4.711 7.48898 2.75 12.053C4.711 16.617 8.194 19.355 12.002 19.355H11.998Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                                                                </svg>
                                                                               @elseif($ques['show']==false)
                                                                                <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                                                                <svg  wire:click="setQuestionShow({{ $ques['show'] }},{{ $ques['id'] }})" class="h-6 w-6 hover:text-black text-primary_red "  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path opacity="0.4" d="M9.76057 14.3667C9.18557 13.7927 8.83557 13.0127 8.83557 12.1377C8.83557 10.3847 10.2476 8.97168 11.9996 8.97168C12.8666 8.97168 13.6646 9.32268 14.2296 9.89668" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                <path opacity="0.4" d="M15.1047 12.6987C14.8727 13.9887 13.8567 15.0067 12.5677 15.2407" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                <path d="M6.65451 17.4722C5.06751 16.2262 3.72351 14.4062 2.74951 12.1372C3.73351 9.85823 5.08651 8.02823 6.68351 6.77223C8.27051 5.51623 10.1015 4.83423 11.9995 4.83423C13.9085 4.83423 15.7385 5.52623 17.3355 6.79123" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                <path d="M19.4475 8.99072C20.1355 9.90472 20.7405 10.9597 21.2495 12.1367C19.2825 16.6937 15.8065 19.4387 11.9995 19.4387C11.1365 19.4387 10.2855 19.2987 9.46753 19.0257" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                <path d="M19.8868 4.24951L4.11279 20.0235" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                </svg>


                                                                            @endif
                                                                        </a>
                                                                        {{-- re order question --}}
                                                                        <a type="button"  wire:sortable.handle class="ml-1 mr-1 ">
                                                                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                                            <svg class="h-6 w-6 text-svg_primary hover:text-secondary_blue focus:text-secondary_blue"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                                            <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0001 2.89331L8.81809 6.07529L9.87875 7.13595L11.2501 5.76463V11.2499H5.7649L7.13619 9.8786L6.07553 8.81794L2.89355 11.9999L6.07553 15.1819L7.13619 14.1212L5.76485 12.7499H11.2501V18.2352L9.87875 16.8639L8.81809 17.9245L12.0001 21.1065L15.182 17.9245L14.1214 16.8639L12.7501 18.2352V12.7499H18.2353L16.8639 14.1213L17.9246 15.1819L21.1066 11.9999L17.9246 8.81796L16.8639 9.87862L18.2352 11.2499H12.7501V5.76463L14.1214 7.13595L15.182 6.07529L12.0001 2.89331Z" fill="currentColor"/> </g>
                                                                            </svg>

                                                                        </a>
                                                                        {{-- delete question --}}
                                                                        <a type="button"  wire:click="deletequestionConfirmation({{ $ques['id'] }})" class="ml-1 mr-1   " >
                                                                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                                            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                                                                            <svg class="h-6 w-6 text-svg_primary hover:text-primary_red focus:text-primary_red"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                                            <g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M14 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M4 7H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                                                            </svg>
                                                                        </a>
                                                                        {{-- edit question --}}

                                                                        <a  wire:click="$emit('edit',{{ $ques['id'] }},{{ json_encode($local) }},{{ json_encode($formlanguages) }})"  type="button"
                                                                        data-toggle="modal"
                                                                        data-target="#editquestion"
                                                                        class="ml-1 mr-1" >
                                                                        <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                                                                        <svg class="h-6 w-6 text-svg_primary hover:text-secondary_blue focus:text-secondary_blue"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        <g id="SVGRepo_iconCarrier"> <path d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                                                        </svg>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="mt-2 mb-2 flex justify-center items-center" >
                                                                    <span class="text-center">{{ $ques['details'] }}</span>
                                                                </div>
                                                                {{-- <div class="mr-4 ml-4 p-2" >
                                                                    <ul >
                                                                        <li>answer1</li>
                                                                        <li>answer2</li>
                                                                        <li>answer3</li>
                                                                    </ul>

                                                                </div> --}}
                                                            </li>


                                                @endforeach
                                                {{-- add question  --}}
                                                <div class="mt-4 mb-4  grid justify-center items-center" >
                                                    <div  id="addquestionbutton" class="flex justify-center items-center">
                                                        <svg wire:loading.attr="disabled" wire:click="$emit('add',{{ json_encode($current_form_id)}},{{json_encode($local)}},{{ json_encode($this->formlanguages) }})"
                                                            data-toggle="modal" data-target="#addquestion"
                                                            class="w-10 h-10  hover:cursor-pointer ease-in delay-100  hover:-translate-z-1 hover:scale-[1.2] duration-200"
                                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <g id="SVGRepo_iconCarrier"> <path opacity="0.5" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" fill="#1277d1"/> <path d="M12.75 9C12.75 8.58579 12.4142 8.25 12 8.25C11.5858 8.25 11.25 8.58579 11.25 9L11.25 11.25H9C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75H11.25V15C11.25 15.4142 11.5858 15.75 12 15.75C12.4142 15.75 12.75 15.4142 12.75 15L12.75 12.75H15C15.4142 12.75 15.75 12.4142 15.75 12C15.75 11.5858 15.4142 11.25 15 11.25H12.75V9Z" fill="#1277d1"/> </g>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <span class="text-black text-xs">{{ __('Add Question') }}</span>
                                                    </div>

                                                </div>
                                            </ul>


                                    @endforeach
                                    {{-- thanks message  --}}
                                    @if($current_message!=null)
                                    <li   class="list-none mr-1 ml-1 bg-gray-50 p-4 mt-2 hover:bg-slate-100 hover:border-2 hover:border-blue-300  rounded-lg  " >
                                        <div class="flex justify-between" >
                                            <div class="w-1/3 max-w-1/3">
                                                <span class="mx-[1px] rounded bg-[#faebd7] text-black p-[2px] text-sm">{{ __('🅴 End Page') }}</span>
                                                <span class="mx-[1px] rounded bg-blue-300 p-[2px] text-sm">{{ $current_language['name'] }}</span>
                                            </div>
                                            <div class="flex justify-between" >
                                                <a wire:click="$emit('edit_message',{{ json_encode('End') }},{{ json_encode($current_message) }})"  type="button"  data-te-toggle="modal"
                                                data-te-target="#editmessage"
                                                data-te-ripple-init
                                                class="ml-1 mr-1" ><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                                <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                                                <svg class="h-6 w-6 text-svg_primary hover:text-secondary_blue focus:text-secondary_blue"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                <g id="SVGRepo_iconCarrier"> <path d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                                </svg></a>
                                            </div>
                                        </div>
                                        <div class="flex justify-center">
                                            <h1 class="text-center"> {{ $current_message->form_end_header }}</h1>
                                        </div>
                                        <div class="mt-8 flex justify-center">
                                            <h1 class="text-center"> {{ $current_message->form_end_text }}</h1>
                                        </div>


                                    </li>
                                    @endif
                                {{-- end thanks message --}}
                            </div>



                    </div>


                </div>

            </div>
        @else
         <div class="flex justify-center items-center text-primary_red"> {{ __('error') }}</div>
        @endif

                {{-- add form--}}
                <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="addform" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
                    <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
                    outline-none ">
                    @livewire('addforms')
                    </div>
                    </div>
                </div>
                {{-- share form modal --}}
                <x-share-form-box />
                {{-- edit form terms modal --}}
                <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="formterms" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[1000px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
                      <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
                      outline-none ">
                       @livewire('formterms')
                      </div>
                    </div>
                  </div>
                {{-- add question modal --}}
                <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="addquestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[1250px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
                      <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
                      outline-none ">
                       @livewire('add-question')
                      </div>
                    </div>
                  </div>
                {{-- edit question modal --}}
                    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="editquestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[1250px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
                        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
                        outline-none ">
                        @livewire('edit-question')
                        </div>
                        </div>
                    </div>

            {{-- edit messages --}}
            <div  data-te-modal-init class="fixed top-0 left-0 z-[1055] hidden h-full w-full  overflow-x-hidden outline-none"
                    id="editmessage" tabindex="-1" data-te-backdrop="static"
                    data-te-keyboard="false" aria-hidden="true" aria-labelledby="editmessage" aria-modal="true" role="dialog">
                        <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px]
                        items-center opacity-0 transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] ">
                            <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none ">
                            @livewire('edit-messages')
                        </div>
                </div>
            </div>


</div>

@push('scripts')
<script src="{{ asset('js/index.min.js')}}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js')}}"></script>
<script defer src="{{ asset('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js')}}" defer></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>
{{-- detect the start date of expiry  --}}
<script>
    var translations = @json(__('main'));
    function SetMinExpiryDate(){
        var time = new Date();
        var localTimeStr = time.toLocaleString('en-US', { timeZone: 'Asia/Shanghai' });
        today = new Date(localTimeStr);
        tomorrow = new Date(today.setDate(today.getDate() + 1)).toISOString().split('T')[0];
        document.getElementById("expiry-date").setAttribute('min', tomorrow);
     }
     SetMinExpiryDate();

</script>
{{-- sweet alert delete confirm --}}
<script>
// document.addEventListener("DOMContentLoaded", function() {
//         var addquestionbuttonDiv = document.getElementById("addquestionbutton");
//         var addquestionbuttonDiv1 = document.getElementById("addquestionbutton1");
//         addquestionbuttonDiv.classList.remove('hidden');
//         addquestionbuttonDiv.classList.add('flex');
//         addquestionbuttonDiv1.classList.remove('hidden');
//         addquestionbuttonDiv1.classList.add('flex');

//     });
    //  to confirm delete question
    window.addEventListener('show-question-delete-confirmation', event => {

        (async () => {

        const { value: accept } = await Swal.fire({
            text: translations.deletequestion_message,
        input: 'checkbox',
        inputValue: 0,
        icon:'question',
        confirmButtonColor: '#dc2626',
        showCancelButton: true,
        cancelButtonColor:'#f3f4f6',
        cancelButtonText:`<h5 style='color:000000;border:0;box-shadow: none;'>${translations.cancel}</h5>`,
        showCancelButton: true,
        inputPlaceholder:translations.suredelete_question,
        confirmButtonText:translations.delete,
        inputValidator: (result) => {
            return !result && translations.checkboxrequired
        }
        })

        if (accept) {
            Livewire.emit('deleteQuestionConfirmed');
        }

        })()
    });
    //  to confirm delete language
    window.addEventListener('show-language-delete-confirmation', event => {

        (async () => {

        const { value: accept } = await Swal.fire({
            text:translations.deletelanguage_message ,
        input: 'checkbox',
        inputValue: 0,
        icon:'question',
        confirmButtonColor: '#dc2626',
        showCancelButton: true,
        cancelButtonColor:'#f3f4f6',
        cancelButtonText:`<h5 style='color:000000;border:0;box-shadow: none;'>${translations.cancel}</h5>`,
        showCancelButton: true,
        inputPlaceholder:
        translations.suredelete_language,
        confirmButtonText:translations.delete,
        inputValidator: (result) => {
            return !result && translations.checkboxrequired
        }
        })

        if (accept) {
            Livewire.emit('deleteLanguageConfirmed');
        }

        })()
    });
    //  to confirm terms question
    window.addEventListener('show-terms-delete-confirmation', event => {
       console.log('terms');
        (async () => {

        const { value: accept } = await Swal.fire({
            text:translations.deletelanguage_message,
        input: 'checkbox',
        inputValue: 0,
        icon:'question',
        confirmButtonColor: '#3085d6',
        showCancelButton: true,
        inputPlaceholder:translations.suredelete_language,
        confirmButtonText:translations.delete,
        inputValidator: (result) => {
            return !result && translations.checkboxrequired
        }
        })

        if (accept) {
            Livewire.emit('deleteTermsConfirmed');
        }

        })()
    });

    // show alert of translation notification
    function ShowAlertTranslation(){
        Swal.fire({
            title: translations.multilanguage_title,
            html: translations.multilanguage_before+`<a href="" class="text-secondary_blue">${translations.learnmore}</a>`translations.multilanguage_after,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1277D1',
                showCancelButton: true,
                cancelButtonColor:'#f3f4f6',
                cancelButtonText:`<h5 style='color:000000;border:0;box-shadow: none;'>${translations.ignore}</h5>`,
            confirmButtonText:translations.warethat_button
            }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('hidetranslationalert');
            }
            })
    }
    // show edit terms hint
    function ShoweditTermsHint(){
        Swal.fire({
                html:`<span class="text-secondary_blue">${translations.termsconditions}</span> ${}`,
                confirmButtonColor:'#1277D1',
        })
    }
</script>

<script>

    // //  close modal edit terms
    window.addEventListener('close_modal_edit_terms', event => {
        $('#formterms').modal('hide').data('bs.modal', null);
            // $('.modal').remove();
        $('.modal-backdrop').remove();
        window.location.reload();

    });
    //   close modal add form
    window.addEventListener('close_modal_add_form', event => {
        $('#addform').modal('hide').data('bs.modal', null);
            // $('.modal').remove();
            $('.modal-backdrop').remove();
        // $('body').removeClass('modal-open');
        // $('body').removeAttr('style');

        window.location.reload();
    });
    // end close modal add form
    //   close modal add question
    window.addEventListener('close_modal_add_question', event => {
        $('#addquestion').modal('hide').data('bs.modal', null);
        // $('.modal').remove();
        $('.modal-backdrop').remove();
        // $('body').removeClass('modal-open');

        window.location.reload();

    });
    // end close modal add question
    //   close modal edit question
    window.addEventListener('close_modal_edit_question', event => {
        $('#editquestion').modal('hide').data('bs.modal', null);
        // $('.modal').remove();
        $('.modal-backdrop').remove();
        // $('body').removeClass('modal-open');


    });
    // end close modal add question
    // *******************
    // re build carousel after each action
    window.addEventListener('languagesChanged', event => {

        var id="tabs-"+@this.local;
        var tab=document.getElementById(id);

        tab.classList.remove("hidden");
        tab.classList.remove("opacity-0");
        tab.classList.add("opacity-100");
        RebuildCarousel();


    });
    function SetMinExpiryDate(){
    var time = new Date();
    var localTimeStr = time.toLocaleString('en-US', { timeZone: 'Asia/Shanghai' });
    today = new Date(localTimeStr);
    tomorrow = new Date(today.setDate(today.getDate() + 1)).toISOString().split('T')[0];
    document.getElementById("expiry-date").setAttribute('min', tomorrow);
    }
    // rebuild carousel
    function RebuildCarousel(){
        var $owl = $('.owl-form');
            $owl.trigger('destroy.owl.carousel');

           $owl.find('.owl-stage-outer').removeClass('owl-loaded');
            //    $(owl).owlCarousel($(owl).data()); // Initialize Owl carousel once again with same config options

            $owl.owlCarousel({
                loop:false,
            margin:10,
            nav:false,
            responsiveClass:true,
            // navText: ["<div class=''><</div>", "<div class=''>></div>"],

            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                },
                1800:{items:3}
            }
            });
    }
    // show Success Changed Message after each action
    function ShowSuccessChangedMessage(){

                const div = document.getElementById("toast-update");
                div.style.display = "block"; // Show the div
                setTimeout(function () {
                    div.style.display = "none"; // Hide the div after 3 seconds
                }, 10000);

    }
    // hide alert success
    function hideAlert(){
        const div = document.getElementById("toast-update");
        div.style.display = "none";

    }
    window.addEventListener('RebuildCarousel', event => {
        RebuildCarousel();
    });
    window.addEventListener('contentChanged', event => {
            // set min date for expiry date input
            SetMinExpiryDate();

            ShowSuccessChangedMessage();

    });
    // if not allowed
    window.addEventListener('notAllowed', event => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'This feature is not available on this plan To access this feature',
            footer: `<a href="{{ route('subscribe','upgrade') }}" class="animate-pulse text-blue-400 hover:text-blue-500">Upgrade now</a>`
            })
    });
</script>
<script>
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


{{-- success edit/add question --}}
<script>

    var flashedMessage = document.getElementById('flashedMessage').value;
    var flashedMessage_error = document.getElementById('flashedMessage_error').value;
    $kiosks=@json($current_form_kiosks);
    if (flashedMessage) {
        console.log(flashedMessage);
       ShowSuccessChangedMessage();
    }
    if(flashedMessage_error){
        console.log(flashedMessage_error);
        Swal.fire({
            icon: 'error',
            title:translations.addquestionfailed,
            text:flashedMessage,
            confirmButtonColor:'#1277D1',

    })
    }



</script>

@endpush
