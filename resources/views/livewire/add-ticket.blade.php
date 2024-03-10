<div>
    {{-- header --}}
    <div class="flex items-center justify-between p-4 border-b rounded-t ">
        <div class="flex items-center">
        <h3 class="text-xl font-semibold text-gray-900 ">
            {{ __('main.createticket') }}
        </h3>
        </div>
        <button type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
        items-center  close" data-dismiss="modal" aria-label="Close">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
            011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </div>
    {{-- end header --}}
    <div  class=" 2xl:max-h-[700px] xs:max-h-[400px]">
        <form wire:loading.class="disabled opacity-50"  wire:submit.prevent="addticket">
            @csrf
            <div >
                {{--target  --}}
                <div class="  m-4 p-2 "  >
                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="target">{{ __('main.target') }}

                    </label>

                    <select  id="target" name="target" class=" w-full  h-10   text-sm rounded-lg
                      px-2  border-gray-300  focus:border-secondary mr-2
                      focus:ring-secondary " wire:model.defer="target"  >

                        <option value="Customer Support" wire:key="target-0" >{{ __('main.customersupport') }}</option>
                        {{-- <option value="Sales" wire:key="target-1" >{{ __('main.sales') }}</option> --}}

                    </select>

                </div>
                {{-- subject --}}
                <div class=" m-4 p-2 "  >
                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="device_name">{{ __('main.subject') }}

                    </label>
                    <input   type="text" id="subject" name="subject" wire:model.defer="subject"
                    class=" w-full   h-10 bg-gray-50   text-sm rounded-lg
                     block  px-2 border-gray-300  focus:border-secondary mr-2
                      focus:ring-secondary "  maxlength="100"   placeholder="" required>
                    {{-- error on device code --}}
                    @error('subject') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror


                </div>

               {{-- description --}}
               <div class=" m-4 p-2 "  >
                <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="desc">{{ __('main.description') }}

                </label>
                <textarea   type="text" id="desc" name="desc" wire:model.defer="desc"
                class=" w-full   h-32 bg-gray-50   text-sm rounded-lg
                 block  px-2 border-gray-300  focus:border-secondary mr-2
                  focus:ring-secondary "  maxlength="1000"   placeholder="" required></textarea>
                {{-- error on device code --}}
                @error('desc') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror


            </div>
            </div>

            {{-- end body  --}}
            {{-- footer --}}

            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">
                <x-jet-secondary-button wire:click="resetvalues()" data-dismiss="modal" aria-label="Close"  type="button"  wire:loading.attr="disabled">
                    {{ __('main.cancel') }}
                </x-jet-secondary-button>
                <x-jet-button class="ml-3" type="submit"   wire:loading.attr="disabled">
                    <span class="inline-block" wire:loading.class="hidden" >{{  __('main.create') }}</span>
                    <span class="hidden" wire:loading.class.remove="hidden" >
                        {{ __('main.saving') }}
                    </span>
                </x-jet-button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
    <script>

         document.addEventListener('saved',(e)=>{
            window.location.reload();
         });
    </script>
@endpush
