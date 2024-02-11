<div wire:loading.attr="disabled">
    {{-- header --}}
    <div class="flex items-center space-x-10 justify-between p-4 border-b rounded-t ">

        <div class="grid">
            <div class="bg-primary_blue rounded-[0.5rem] px-2 py-1  grid grid-cols-2 space-x-1 items-center ">
               <span class="text-sm font-bold text-left col-span-1">{{ __('main.componenttype') }}</span>
               <span class="text-sm col-span-1">{{ __(' Terms & Conditions ') }}</span>
            </div>
            <div class="bg-primary_blue rounded-[0.5rem] px-2 py-1  grid grid-cols-2 space-x-1 items-center mt-1">
                <span class="text-sm font-bold text-left col-span-1">{{ __('main.displaylanguage') }}</span>
                <span class="text-sm col-span-1">{{$languageNamesByCode[$local] ?? 'Language Not Found' }}</span>
             </div>

        </div>
        <button   type="button" wire:click="resetvalue()"  class="close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
            items-center "  data-dismiss="modal" aria-label="Close">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
            011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </div>
{{-- end header --}}
      {{-- body --}}
        <form wire:submit.prevent="save(Object.fromEntries(new FormData($event.target)))"   >

           <div class="grid items-center justify-center p-2 max-h-[600px]  ">
               <div  class="flex justify-end items-center  text-sm ">
                  <span><span id="counter"></span>{{ __('/10000') }}</span>
               </div>
               <textarea required  maxlength="10000" class=" max-h-[500px] overflow-auto  {{ $local=='en'||$local=='tl'?"text-left":"text-right " }}" value="{!! $terms !!}"   name="terms" id="textarea_terms" cols="80" rows="200">

                </textarea>
                @error('terms') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror

            </div>
           {{-- end body --}}
           {{-- footer --}}

           <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">

               <x-jet-secondary-button data-dismiss="modal" aria-label="Close" wire:click="resetvalue()"  type="button"  wire:loading.attr="disabled">
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

<script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>

</script>
<script>
    var messageEle = document.getElementById('textarea_terms');
    var counterEle = document.getElementById('counter');

    // Function to update character count
    function updateCounterTerms() {
        var maxLength = messageEle.getAttribute('maxlength');
        var currentLength = messageEle.value.length;
        counterEle.innerText = `${currentLength}`;
    //     tinymce.init({
    //   selector: 'textarea',
    //   plugins: 'advlist autolink lists link image charmap print preview anchor',
    //   toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image',
    // });
    }



    // Add event listener for input
    messageEle.addEventListener('input', function(e) {
        updateCounterTerms();

    });


    window.addEventListener('loadterms', event => {
        document.getElementById('textarea_terms').value = event.detail.terms;
        updateCounterTerms();
    });

</script>



@endpush
