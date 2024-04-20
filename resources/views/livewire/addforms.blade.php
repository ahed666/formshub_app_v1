@push('styles')
    <style>
        .visually-hidden {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    border: 0;
    overflow: hidden;
    clip: rect(0 0 0 0);
    white-space: nowrap;
}
    </style>
@endpush
<div>
    {{-- header --}}
     <div class="flex items-start justify-between p-4 border-b rounded-t ">
         <h3 class="text-xl font-semibold text-gray-900 ">
            {{ $isadd?__('main.createform'):__('main.editinfo') }}
         </h3>
         <button  wire:click="resetvalue()" type="button"  class="close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
             items-center "  data-dismiss="modal" aria-label="Close">
             <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
             011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
         </button>
     </div>
 {{-- end header --}}
       {{-- body --}}
       {{-- subscription setting and notifactions --}}


        @if($isadd&&!$valid)
       <x-add_item_error  :error="$error" :subscribe="$current_subscribe" />
        @else
            <form id="form_modal" wire:submit.prevent="addform">
                @csrf
                {{-- Add form --}}
                @if($isadd)

                            {{-- survry type --}}
                            <div class="p-4 mt-10">

                                <ul  class="my-2  grid w-full 2xl:grid-cols-12 lg:grid-cols-12  gap-6 md:grid-cols-2 xs:grid-cols-2  overflow-y-auto " >

                                    @foreach ( $form_types as $type )
                                        <li   class="2xl:col-span-3 xl:col-span-3 lg:col-span-3  "  >
                                            <input {{ $type->id==2?"disabled":"" }}   wire:model="form_type_id" value="{{ $type->id }}" class="peer visually-hidden " name="form-type" id="form-type-{{ $type->id }}" type="radio" required>
                                                <label for="form-type-{{ $type->id }}" class="{{ $type->enable?"":"opacity-50" }}
                                                    grid items-center justify-center w-full p-1  text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                                    peer-checked:border-secondary_blue
                                                    hover:text-gray-600 hover:bg-gray-100  ">
                                                    {{-- <img src="{{asset($type->image_url)}}" alt=""> --}}
                                                    <div  class="flex justify-center items-center">
                                                        {!! $type->svg !!}
                                                    </div>
                                                    <div class="flex justify-center items-center mt-2">
                                                        <span class="text-sm text-center whitespace-normal inline-block">  <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $type->type_details }}"><svg   class="inline-block text-secondary_blue ml-[1px] mr-[1px] w-[20px] h[20px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                                        </svg></a>{{ $type->form_type }}</span>
                                                    </div>
                                                </label>


                                        </li>
                                    @endforeach

                                </ul>
                                @error('form_type_id') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror

                            </div>
                            {{-- form info --}}
                            <div class="grid grid-cols-12 p-4 gap-2 ">
                                <div  class="col-span-9 xs:col-span-12">
                                    {{-- form title --}}

                                    <div class="w-full  "  >

                                        <label  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap" for="form-title">{{ __('main.formtitle') }}<a data-bs-toggle="tooltip"  data-bs-html="true"
                                        title="{{ __('main.formtitlehint') }}"><svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                        </svg></a></label>
                                        <input maxlength="60" type="text" id="form-title" name="form_title" class=" w-full  mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                                        focus:border-blue-500 block   px-2"  wire:model="form_title"   required>
                                        {{-- error on form name --}}
                                        @error('form_title') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror

                                        {{-- end on form name --}}
                                    </div>


                                    @if($languages!=null&&$isadd&&$form_type_id==1)
                                    <div class="w-full mt-6 " >

                                        <fieldset class="flex justify-between border-[1px] border-gray-300 ">
                                            <legend class="text-black text-sm  xs:ml-2 xs:mr-2 w-20 whitespace-nowrap ">{{ __('main.formlanguage') }}
                                                <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('main.formlanguageshint') }}"><svg   class="inline-block text-secondary_blue w-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                                </svg></a>
                                            </legend>
                                            @foreach ($this->languages as $i=> $lang)
                                                <label class="text-sm">
                                                    <input type="checkbox"
                                                            value="{{ $lang['code'] }}"
                                                            wire:model.defer="form_DefultLanguages"
                                                            class="w-4 h-4 text-secondary_blue bg-gray-100 border-gray-300 rounded focus:ring-secondary_blue focus:ring-0 focus:outline-none ">
                                                    {{ $lang['name'] }}
                                                </label><br>
                                            @endforeach
                                        </fieldset>
                                        {{-- error on defult language --}}
                                        @error('form_DefultLanguages') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
                                            {{-- end on defult language --}}

                                    </div>
                                    @endif
                                </div>
                                {{-- form logo --}}
                                 @if($form_type_id==1)
                                <div class="col-span-3 xs:col-span-12  " >
                                    <div class=" mr-6 ml-6 xs:mr-0 xs:ml-0  " >
                                        <label class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap" for="branch-name">
                                            {{ __('main.formlogo') }}<a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('main.formlogohint') }}"><svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                            </svg></a></label>
                                        <div class="border-2 rounded-lg border-gray-400  max-w-[120px] max-h-[90px] min-h-[90px] min-w-[120px] w-[120px] h-[90px] p-1  relative " >
                                            <img  class="object-contain w-full h-full" src="{{asset($form_logo_temp) }}" alt="">
                                            @if(!$custom)
                                            <label onclick="ShowWarning()" class="items-center  absolute  flex  left-[-0.5rem] bottom-[-1rem]   rounded bg-white " for="logo">
                                                <svg class="w-6 h-6  hover:cursor-pointer text-svg_primary hover:text-secondary_blue" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M8 10C8 7.79086 9.79086 6 12 6C14.2091 6 16 7.79086 16 10V11H17C18.933 11 20.5 12.567 20.5 14.5C20.5 16.433 18.933 18 17 18H16C15.4477 18 15 18.4477 15 19C15 19.5523 15.4477 20 16 20H17C20.0376 20 22.5 17.5376 22.5 14.5C22.5 11.7793 20.5245 9.51997 17.9296 9.07824C17.4862 6.20213 15.0003 4 12 4C8.99974 4 6.51381 6.20213 6.07036 9.07824C3.47551 9.51997 1.5 11.7793 1.5 14.5C1.5 17.5376 3.96243 20 7 20H8C8.55228 20 9 19.5523 9 19C9 18.4477 8.55228 18 8 18H7C5.067 18 3.5 16.433 3.5 14.5C3.5 12.567 5.067 11 7 11H8V10ZM15.7071 13.2929L12.7071 10.2929C12.3166 9.90237 11.6834 9.90237 11.2929 10.2929L8.29289 13.2929C7.90237 13.6834 7.90237 14.3166 8.29289 14.7071C8.68342 15.0976 9.31658 15.0976 9.70711 14.7071L11 13.4142V19C11 19.5523 11.4477 20 12 20C12.5523 20 13 19.5523 13 19V13.4142L14.2929 14.7071C14.6834 15.0976 15.3166 15.0976 15.7071 14.7071C16.0976 14.3166 16.0976 13.6834 15.7071 13.2929Z" fill="CurrentColor"/> </g>
                                                </svg>
                                            </label>
                                            @else
                                            <label class="items-center  absolute  flex rounded bg-white left-[-0.5rem] bottom-[-1rem]   " for="logo">


                                                <svg class="w-6 h-6  hover:cursor-pointer text-svg_primary hover:text-secondary_blue" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M8 10C8 7.79086 9.79086 6 12 6C14.2091 6 16 7.79086 16 10V11H17C18.933 11 20.5 12.567 20.5 14.5C20.5 16.433 18.933 18 17 18H16C15.4477 18 15 18.4477 15 19C15 19.5523 15.4477 20 16 20H17C20.0376 20 22.5 17.5376 22.5 14.5C22.5 11.7793 20.5245 9.51997 17.9296 9.07824C17.4862 6.20213 15.0003 4 12 4C8.99974 4 6.51381 6.20213 6.07036 9.07824C3.47551 9.51997 1.5 11.7793 1.5 14.5C1.5 17.5376 3.96243 20 7 20H8C8.55228 20 9 19.5523 9 19C9 18.4477 8.55228 18 8 18H7C5.067 18 3.5 16.433 3.5 14.5C3.5 12.567 5.067 11 7 11H8V10ZM15.7071 13.2929L12.7071 10.2929C12.3166 9.90237 11.6834 9.90237 11.2929 10.2929L8.29289 13.2929C7.90237 13.6834 7.90237 14.3166 8.29289 14.7071C8.68342 15.0976 9.31658 15.0976 9.70711 14.7071L11 13.4142V19C11 19.5523 11.4477 20 12 20C12.5523 20 13 19.5523 13 19V13.4142L14.2929 14.7071C14.6834 15.0976 15.3166 15.0976 15.7071 14.7071C16.0976 14.3166 16.0976 13.6834 15.7071 13.2929Z" fill="CurrentColor"/> </g>
                                                    </svg>
                                                <input   wire:model="logo" class="image opacity-0 absolute -z-10" type="file" name="logo" id="logo" accept="image/png,image/webp, image/svg, image/jpeg" />
                                            </label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>


                            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">

                                <x-jet-secondary-button wire:click="resetvalue()" data-dismiss="modal" aria-label="Close"  type="button"  wire:loading.attr="disabled">
                                    {{ __('main.cancel') }}
                                </x-jet-secondary-button>
                                <x-jet-button class="ml-3" type="submit"   wire:loading.attr="disabled">
                                    {{ __('main.create') }}
                                </x-jet-button>
                            </div>



                {{-- edit form --}}
                @else
                    <div class="grid grid-cols-12 p-4 gap-2 ">
                        <div class="col-span-8 xs:col-span-12">
                            {{-- form title --}}
                            <div class="w-full "  >

                                <label  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap" for="form-title">{{ __('main.formtitle') }}
                                <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('main.formtitlehint') }}"><svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                </svg></a></label>
                                <input maxlength="60" type="text" id="form-title" name="form_title" class=" w-full  mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                                focus:border-blue-500 block px-2"  wire:model="form_title"   required>
                                {{-- error on form name --}}
                                @error('form_title') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror


                                {{-- end on form name --}}
                            </div>


                        </div>
                        {{-- form logo --}}
                        <div class="col-span-4 xs:col-span-12 " >



                            <div class=" mr-6 ml-6 xs:mr-0 xs:ml-0  " >
                                <label class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap" for="branch-name">
                                    {{ __('main.formlogo') }}<a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('main.formlogohint') }}"><svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                    </svg></a></label>
                                <div class="border-2 rounded-lg border-gray-400  max-w-[160px] max-h-[120px] min-h-[120px] min-w-[160px] w-[160px] h-[120px] p-1  relative " >
                                    <img  class="object-contain w-full h-full" src="{{asset($form_logo_temp) }}" alt="">
                                    @if(!$custom)
                                    <label onclick="ShowWarning()" class="items-center  absolute  flex  left-[-0.5rem] bottom-[-1rem]   rounded bg-white " for="logo">
                                        <svg class="w-6 h-6  hover:cursor-pointer text-svg_primary hover:text-secondary_blue" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                            <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M8 10C8 7.79086 9.79086 6 12 6C14.2091 6 16 7.79086 16 10V11H17C18.933 11 20.5 12.567 20.5 14.5C20.5 16.433 18.933 18 17 18H16C15.4477 18 15 18.4477 15 19C15 19.5523 15.4477 20 16 20H17C20.0376 20 22.5 17.5376 22.5 14.5C22.5 11.7793 20.5245 9.51997 17.9296 9.07824C17.4862 6.20213 15.0003 4 12 4C8.99974 4 6.51381 6.20213 6.07036 9.07824C3.47551 9.51997 1.5 11.7793 1.5 14.5C1.5 17.5376 3.96243 20 7 20H8C8.55228 20 9 19.5523 9 19C9 18.4477 8.55228 18 8 18H7C5.067 18 3.5 16.433 3.5 14.5C3.5 12.567 5.067 11 7 11H8V10ZM15.7071 13.2929L12.7071 10.2929C12.3166 9.90237 11.6834 9.90237 11.2929 10.2929L8.29289 13.2929C7.90237 13.6834 7.90237 14.3166 8.29289 14.7071C8.68342 15.0976 9.31658 15.0976 9.70711 14.7071L11 13.4142V19C11 19.5523 11.4477 20 12 20C12.5523 20 13 19.5523 13 19V13.4142L14.2929 14.7071C14.6834 15.0976 15.3166 15.0976 15.7071 14.7071C16.0976 14.3166 16.0976 13.6834 15.7071 13.2929Z" fill="CurrentColor"/> </g>
                                            </svg>
                                    </label>
                                    @else
                                    <label class="items-center  absolute  flex rounded bg-white left-[-0.5rem] bottom-[-1rem]   " for="logo">


                                        <svg class="w-6 h-6  hover:cursor-pointer text-svg_primary hover:text-secondary_blue" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                            <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M8 10C8 7.79086 9.79086 6 12 6C14.2091 6 16 7.79086 16 10V11H17C18.933 11 20.5 12.567 20.5 14.5C20.5 16.433 18.933 18 17 18H16C15.4477 18 15 18.4477 15 19C15 19.5523 15.4477 20 16 20H17C20.0376 20 22.5 17.5376 22.5 14.5C22.5 11.7793 20.5245 9.51997 17.9296 9.07824C17.4862 6.20213 15.0003 4 12 4C8.99974 4 6.51381 6.20213 6.07036 9.07824C3.47551 9.51997 1.5 11.7793 1.5 14.5C1.5 17.5376 3.96243 20 7 20H8C8.55228 20 9 19.5523 9 19C9 18.4477 8.55228 18 8 18H7C5.067 18 3.5 16.433 3.5 14.5C3.5 12.567 5.067 11 7 11H8V10ZM15.7071 13.2929L12.7071 10.2929C12.3166 9.90237 11.6834 9.90237 11.2929 10.2929L8.29289 13.2929C7.90237 13.6834 7.90237 14.3166 8.29289 14.7071C8.68342 15.0976 9.31658 15.0976 9.70711 14.7071L11 13.4142V19C11 19.5523 11.4477 20 12 20C12.5523 20 13 19.5523 13 19V13.4142L14.2929 14.7071C14.6834 15.0976 15.3166 15.0976 15.7071 14.7071C16.0976 14.3166 16.0976 13.6834 15.7071 13.2929Z" fill="CurrentColor"/> </g>
                                            </svg>
                                        <input   wire:model="logo" class="image opacity-0 absolute -z-10" type="file" name="logo" id="logo" accept="image/png,image/webp, image/svg, image/jpeg" />
                                    </label>
                                    @endif
                                </div>
                            </div>



                        </div>
                    </div>
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">
                        {{-- <button  type="button" data-dismiss="modal" aria-label="Close"
                        class="text-white bg-red-400 hover:bg-red-500  font-medium rounded-lg
                        text-sm px-5 py-2.5 text-center  ">Cancel</button>
                        <button  type="submit"
                        class="text-white bg-blue-400  hover:bg-blue-500 font-medium rounded-lg
                        text-sm px-5 py-2.5 text-center  ">Save</button> --}}
                        <x-jet-secondary-button wire:click="resetvalue()" data-dismiss="modal" aria-label="Close"  type="button"  wire:loading.attr="disabled">
                            {{ __('main.cancel') }}
                        </x-jet-secondary-button>
                        <x-jet-button class="ml-3" type="submit"   wire:loading.attr="disabled">
                            {{ __('main.save') }}
                        </x-jet-button>


                    </div>
                @endif

            </form>
         @endif
        {{-- crop modal --}}
        <div  id="cropimage-form" data-bs-backdrop="static"
         class="modal   absolute z-[500px] top-4 bottom-4 left-0 xs:left-0 border-[1px] rounded-t-xl border-transparent
         max-h-[900px]  w-full bg-white
          {{ $modal?"block":"hidden" }}">

            <div class=" h-10 border-[1px] rounded-t-xl border-transparent p-2 flex justify-end modal-header">
            <a wire:click="closemodal" class=" w-10 h-6 text-secondary_red hover:text-primary_red cursor-pointer flex justify-center" >
                <span  class=" close   ">&times;</span>
            </a>
            </div>
            <!-- Modal content -->
            <div class="h-[80%]  overflow-y-scroll ">
                <div class=" resultupload  flex justify-center"></div>
            </div>
            <!--rightbox-->

            <!-- input file -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">
                <!-- save btn -->
                <x-jet-secondary-button  wire:click="closemodal"   type="button" >
                    {{ __('main.cancel') }}
                </x-jet-secondary-button>
                <x-jet-button  wire:click="cropingimage"  class="ml-3" type="button"   >
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
var tooltipTriggerList = [].slice.call(
 document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
 return new Tooltip(tooltipTriggerEl);
});

</script>

<script>
 function nextStep(){
       step1=document.getElementById('Step1');
       step2=document.getElementById('Step2');
       formTitle=document.getElementById('form-title');
       const formTitleError = document.getElementById('formTitleError');
       formTitleError.textContent ='';

       if (formTitle.value.trim() === '') {
        formTitleError.textContent = 'form title cannot be empty';
        // formTitle.setCustomValidity('form title cannot be empty');
        }
        else{
       step1.classList.remove('block');
       step1.classList.add('hidden');

       step2.classList.remove('hidden');
       step2.classList.add('block');
        }
    }
    function backStep(){
        step1=document.getElementById('Step1');
       step2=document.getElementById('Step2');

       step2.classList.remove('block');
       step2.classList.add('hidden');

       step1.classList.remove('hidden');
       step1.classList.add('block');
    }
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script >
  function ShowWarning(){
    Swal.fire({
            icon: 'error',

            text: 'Custom form logo is not available on this account, to upload your logo upgrade your account now',
            confirmButtonColor:'#1277D1',
            footer:`<a target="_blank" href="{{ route('subscribe','upgrade') }}" class="animate-pulse text-secondary_blue hover:text-blue-500">Upgrade now</a>`
    })
  }


   document.addEventListener('form-image-updated', event =>  {

  result = document.querySelector('.resultupload');
 save = document.querySelector('.save');
 upload = document.querySelector('.image');
 cropper = '';
 var finalCropWidth = 152;
 var finalCropHeight = 112;
 var finalAspectRatio = finalCropWidth / finalCropHeight;
 // on change show image with crop options

         // start file reader
     const reader = new FileReader();
     let img = document.createElement('img');
     img.id = 'image';
     console.log(result);
     img.src = @this.logosrc;
    console.log(img);
                 // clean result before
     result.innerHTML = '';

                 // append new image
     result.appendChild(img);
     console.log(result);
                 // show save btn and options

                 // init cropper
     cropper = new Cropper(img, {
         dragMode: 'move',
         aspectRatio: finalAspectRatio,
         autoCropArea: 0.9,
         restore: true,
         guides: true,
         center: true,
         highlight: true,
         cropBoxMovable: true,
         cropBoxResizable: true,

         toggleDragModeOnDblclick: false,
     });




 // save on click

 });
 document.addEventListener('saving',(e)=>{
     e.preventDefault();
     // get result to data uri
     let imgSrc = cropper.getCroppedCanvas({
         width:400,
         height:200
         }).toDataURL();



         @this.SavImage(imgSrc);
         @this.closemodalwithsave();
     // dwn.classList.remove('hide');
     // dwn.download = 'imagename.png';
     // dwn.setAttribute('href',imgSrc);
     });
</script>
@endpush
