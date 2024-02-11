<div>
   {{-- header --}}
    <div class="flex items-center justify-between p-4 border-b rounded-t ">
        <div class="flex items-center">
        <h3 class="text-xl font-semibold text-gray-900 ">
            {{ __('main.addkiosk') }}
        </h3>
        <svg class=" mx-2 w-8 h-8" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" width="800px" height="800px" fill="#2d4b71" stroke="#2d4b71" stroke-width="0.00512">
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
            <g id="SVGRepo_iconCarrier"> <g> <ellipse style="fill:#1277d1;" cx="256" cy="414.302" rx="93.936" ry="38.661"/> <path style="fill:#1277d1;" d="M265.404,414.302h-18.808c-5.771,0-10.449-4.678-10.449-10.449v-52.245h39.706v52.245 C275.853,409.624,271.175,414.302,265.404,414.302z"/> <path style="fill:#1277d1;" d="M483.265,351.608H28.735c-11.542,0-20.898-9.356-20.898-20.898V79.935 c0-11.542,9.356-20.898,20.898-20.898h454.531c11.542,0,20.898,9.356,20.898,20.898V330.71 C504.163,342.252,494.807,351.608,483.265,351.608z"/> </g> <rect x="39.184" y="90.384" style="fill:#e0e0e0;" width="433.633" height="219.429"/> <path d="M483.265,51.2H28.735C12.89,51.2,0,64.091,0,79.935V330.71c0,15.844,12.89,28.735,28.735,28.735H228.31v10.015 c-37.954,4.688-74.083,19.875-74.083,44.842c0,26.508,43.753,46.498,101.773,46.498s101.773-19.99,101.773-46.498 c0-24.967-36.129-40.152-74.083-44.842v-10.015h199.576c15.845,0,28.735-12.891,28.735-28.735V79.935 C512,64.091,499.11,51.2,483.265,51.2z M325.251,396.856c10.707,5.392,16.849,11.751,16.849,17.446 c0,12.871-32.755,30.824-86.1,30.824s-86.1-17.953-86.1-30.824c0-5.695,6.141-12.054,16.848-17.446 c10.747-5.413,25.283-9.443,41.561-11.595v18.592c0,10.082,8.203,18.286,18.286,18.286h18.808c10.082,0,18.286-8.204,18.286-18.286 v-18.592C299.967,387.414,314.504,391.444,325.251,396.856z M268.016,403.853c0,1.441-1.172,2.612-2.612,2.612h-18.808 c-1.44,0-2.612-1.171-2.612-2.612v-44.408h24.033V403.853z M496.327,330.71c0,7.203-5.859,13.061-13.061,13.061H28.735 c-7.202,0-13.061-5.859-13.061-13.061V79.935c0-7.202,5.859-13.061,13.061-13.061h454.531c7.202,0,13.061,5.859,13.061,13.061 V330.71z"/> <path d="M31.347,317.649h449.306V82.547H31.347V317.649z M47.02,98.22H464.98v203.755H47.02V98.22z"/> </g>
            </svg>
        </div>
        <button wire:click="resetvalues()" type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
        items-center   close" data-dismiss="modal" aria-label="Close">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
            011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </div>
    {{-- end header --}}
    <div  class=" 2xl:max-h-[700px] xs:max-h-[400px]">
       {{-- locked  --}}
    @if($accountStatus['status']=="locked")
        <div class="  flex items-center justify-center">
            <div class="w-auto max-w-lg h-auto p-14 bg-white text-center rounded-lg">
            <h1 class="">{{ ('This feature  has been locked due to subscription expiry
                To continue using this feature please manage your subscription
                ') }}
                <a   href="{{ route('subscribe','upgrade') }}" target="_blank" class="text-blue-400 rounded-xl    hover:cursor-pointer  p-2">
                    {{ __(' here') }}
                </a>
            </h1>
            <div class="flex justify-center items-center">
                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                <svg class="w-14 h-14" fill="#545454" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" stroke="#545454">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                <g id="SVGRepo_iconCarrier"> <g> <path d="M33,85h34c5.514,0,10-4.605,10-10.119v-22c0-5.514-4.486-10-10-10v-8.167C67,25.432,59.545,18,50.382,18h-0.334 C40.647,18,33,25.432,33,34.714v8.167c-5.514,0-10,4.486-10,10v22C23,80.395,27.486,85,33,85z M37,34.714 C37,27.638,42.854,22,50.048,22h0.334C57.457,22,63,27.518,63,34.714V43H37V34.714z M73,75c0,3.313-2.687,6-6,6H33 c-3.313,0-6-2.687-6-6V53c0-3.313,2.687-6,6-6h34c3.313,0,6,2.687,6,6V75z"/> <path d="M47,66.785v4.221C47,72.594,48.287,74,49.875,74h0.25C51.713,74,53,72.594,53,71.006v-4.359 c1.798-1.068,3.007-3.023,3.007-5.266c0-3.383-2.742-6.125-6.125-6.125s-6.125,2.742-6.125,6.125 C43.757,63.722,45.07,65.754,47,66.785z"/> </g> </g>
                </svg>
            </div>
            <h1 class="text-red-500 text-sm">{{ __('Avoid your account being permanently suspended') }} <a href="" class="text-blue-400 hover:text-blue-500 underline">{{ __('read more') }}</a></h1>
            </div>
        </div>
     {{-- num of kisoks --}}
    @elseif(!$valid)
    <x-add_item_error  :error="$error" :subscribe="$current_subscribe" />
    @else
       {{-- body --}}
        <form wire:submit.prevent="adddevice">
            @csrf

            {{-- device code --}}
            <div class="  m-4 p-2 "  >
                <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="device_code">{{ __('main.devicecode') }}
                    <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('main.devicecode_hint') }}">
                        <svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                    </svg>
                    </a>

                </label>
                <div  class="flex {{$isavilable?"opacity-50":""}} ">
                <input {{$isavilable?"disabled":""}} type="number"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"   pattern="[0-9]{7}"  minlength="7" maxlength="7"  id="device_code" name="device_code"  wire:model="deviceCode"
                class="  w-full  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                 block  px-2 border-gray-300  focus:border-secondary
                  focus:ring-secondary  "    placeholder="xxxxxxx" required>

                <button {{$isavilable?"disabled":""  }} type="button" wire:click="checkdevicecode" class="inline-flex items-center px-4 py-2 bg-secondary_blue
                border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3">{{ __('main.ckeck') }}</button>


                 </div>
                {{-- error on device code --}}
                @error('deviceCode') <span class="text-sm text-primary_red error">{{ $message }}</span> @enderror

                <div class="{{ $showmessage?"block":"hidden" }} flex ">
                    <span class="{{$isavilable?"text-valid":"text-primary_red"  }}  text-sm">{{ $message_text }}</span>
                </div>
            </div>
            {{-- end of device code --}}

            <div {{$isavilable==false?"disabled ":""  }} class="{{$isavilable==false?"opacity-50 ":""  }}">
                {{-- Device Name --}}
                <div class=" m-4 p-2 "  >
                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="device_name">{{ __('main.kioskname') }}
                        <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('main.kioskname_hint') }}">
                            <svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                        </svg>
                        </a>

                    </label>
                    <input {{$isavilable==false?"disabled":""}}  type="text" id="device_name" name="device_name" wire:model="currentNameDevice"
                    class=" w-full   h-10 bg-gray-50   text-sm rounded-lg
                     block  px-2 border-gray-300  focus:border-secondary mr-2
                      focus:ring-secondary "  maxlength="25"   placeholder="My kiosk" required>
                    {{-- error on device code --}}
                    @error('currentNameDevice') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror


                </div>
                {{--form  --}}
                <div class="  m-4 p-2 "  >
                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="device_code">{{ __('main.linkedform') }}
                        <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('main.linkedform_hint') }}">
                            <svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                        </svg>
                        </a>

                    </label>

                    <select {{$isavilable==false?"disabled ":""  }} id="form" name="form" class="{{$currentFormId==""?"text-primary_red":"text-gray-900"}}  w-full  h-10   text-sm rounded-lg
                      px-2  border-gray-300  focus:border-secondary mr-2 focus:ring-secondary " wire:model="currentFormId"  >
                        <option class="text-primary_red" value="">{{ __(' ⏱ ') }}{{ __('Stand-By') }}</option>
                        @if($forms!=null)
                        @foreach ($this->forms as $form)
                        <option class="text-gray-900" value="{{ $form->id }}" wire:key="form-{{$form->id}}" >{{ $form->form_title}}</option>
                        @endforeach
                        @endif

                    </select>
                    {{-- <div class="{{ $formNullMessage!=""?"block":"hidden" }} flex ">
                        <span class="text-primary_red  text-sm">{{ $formNullMessage }}</span>
                    </div> --}}


                </div>
                {{-- In service --}}
                {{-- <div class="   m-4 p-2"  >

                    <div class="grid justify-start space-x-1" >
                        <span class="text-secondary_blue font-bold  text-sm " >{{ __('In Service') }}</span>



                        <label class="ml-2 relative inline-flex items-center cursor-pointer">

                        <input {{ $currentFormId!=""?"":"disabled" }} {{$isavilable==false?"disabled ":""  }} type="checkbox"  value=""  class="sr-only peer"
                        {{ $currentInService?"checked":"" }} wire:model="currentInService">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none
                        rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                        after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                         peer-checked:bg-blue-600"></div>

                        </label>
                    </div>
                </div> --}}
            </div>

            {{-- end body  --}}
            {{-- footer --}}

            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">
                <x-jet-secondary-button wire:click="resetvalues()" data-dismiss="modal" aria-label="Close"  type="button"  wire:loading.attr="disabled">
                    {{ __('main.cancel') }}
                </x-jet-secondary-button>
                <x-jet-button class="ml-3" type="submit"   wire:loading.attr="disabled">
                    {{ __('main.add') }}
                </x-jet-button>
            </div>
        </form>
    @endif
    </div>
    {{-- end footer --}}
</div>
@push('scripts')
    <script>
        document.getElementById("device_code").addEventListener("keypress", function (evt) {
            if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
            {
                evt.preventDefault();
            }
        });
    </script>
@endpush
