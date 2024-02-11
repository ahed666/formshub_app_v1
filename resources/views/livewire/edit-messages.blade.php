<div wire:loading.class="disabled opacity-50 animate-pulse">
        {{-- header --}}
        <div  class="flex items-start justify-between p-4 border-b rounded-t ">

            <div  class="grid">
                <div wire:loading.class="animate-pulse"  class="bg-primary_blue rounded-[0.5rem] px-2 py-1  grid grid-cols-2 space-x-1 items-center ">
                   <span class="text-sm font-bold text-left col-span-1">{{ __('main.componenttype') }}</span>
                   <span class="text-sm col-span-1">{{ $type }}{{ __(' Page') }}</span>
                </div>
                <div wire:loading.class="animate-pulse"  class="bg-primary_blue rounded-[0.5rem] px-2 py-1  grid grid-cols-2 space-x-1 items-center mt-1">
                    <span class="text-sm font-bold text-left col-span-1">{{ __('main.displaylangauge') }}</span>
                    <span class="text-sm col-span-1">{{$languageNamesByCode[$local] ?? 'Language Not Found' }}</span>
                 </div>

            </div>
            <button  wire:click="resetvalue()" type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                items-center " data-te-modal-dismiss
                aria-label="Close">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
    {{-- end header --}}
          {{-- body --}}
        <form wire:submit.prevent="edit(Object.fromEntries(new FormData($event.target)))">
           @csrf
            <div class="grid grid-cols-12 p-4 gap-2 ">

                    <div class="col-span-12">
                        {{-- header --}}
                        <div class="w-full "  >
                            <div class="flex justify-between items-center">
                                <span  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 " for="header_message">
                                    <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('Here you may add the header of the welcome page, for a better looking it should not be long, you can always use the Preview option to see how does it look in the actual form.') }}">
                                        <svg   class="inline-block text-blue-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                        </svg>
                                    </a>
                                    {{ __('main.header') }}
                                </span>
                                <div  class="flex justify-end items-center  text-sm ">
                                    <span><span id="header_counter"></span>{{ __('/100') }}</span>
                                </div>
                            </div>
                            <input maxlength="100" type="text" id="header_message" name="header_message" class=" w-full  mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                            focus:border-blue-500 block
                             text-center px-2"     required>
                            @error('header') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror

                        </div>
                        {{-- text --}}
                        <div class="w-full mt-2 min-h-" >
                            <div class="flex justify-between items-center">
                                <span class="text-black text-sm  xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="text_message">
                                    <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('Here you can add more text to view on the welcome page, such as instructions for this form, It is advisable to keep the message concise and coherent.') }}">
                                        <svg   class="inline-block text-blue-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                    </svg></a>
                                    {{ __('main.message') }}
                                </span>
                                <div  class="flex justify-end items-center  text-sm ">
                                    <span><span id="text_counter"></span>{{ __('/200') }}</span>
                                </div>
                            </div>
                            <textarea maxlength="200" cols="100" rows="2" type="text" id="text_message" name="text_message" class=" w-full mr-2  h-20 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                            focus:border-blue-500 block    text-center px-2"   required></textarea>
                            @error('text') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror

                        </div>

                    </div>


            </div>
            {{-- end body --}}
            {{-- footer --}}

            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">

                <x-jet-secondary-button data-te-modal-dismiss
                aria-label="Close" wire:click="resetvalue()"  type="button"  wire:loading.attr="disabled">
                    {{ __('main.cancel') }}
                </x-jet-secondary-button>
                <x-jet-button class="ml-3" type="submit"   wire:loading.attr="disabled">
                        {{ __('main.save') }}
                </x-jet-button>

            </div>
            {{-- end footer --}}
        </form>
</div>
@push('scripts')

<script>
    const headerMessage = document.getElementById('header_message');
    const textMessage = document.getElementById('text_message');
    const counterHeader = document.getElementById('header_counter');
    const countertext = document.getElementById('text_counter');
    var currentLength;

    // Function to update character count
    function updateCounter(element,counter) {
        currentLength = element.value.length;

        counter.innerText = `${currentLength}`;

    }



    // Add event listener for input
    headerMessage.addEventListener('input', function(e) {
        updateCounter(headerMessage,counterHeader);
    });
    textMessage.addEventListener('input', function(e) {
        updateCounter(textMessage,countertext);
    });


    window.addEventListener('loadmessage', event => {
        headerMessage.value = event.detail.header;
        textMessage.value = event.detail.text;
        updateCounter(headerMessage,counterHeader);
        updateCounter(textMessage,countertext);
    });
</script>



@endpush
