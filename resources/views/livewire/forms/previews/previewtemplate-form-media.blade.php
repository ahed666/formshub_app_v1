<div>
    
   <div class="w-full h-full  justify-center items-center fixed inset-0 hidden" wire:loading.class="flex" wire:loading>
    <div class="w-full h-full bg-white p-4 rounded-md shadow-md flex justify-center items-center text-center ">
      <h1> Loading...</h1> 
    </div>
</div>
    {{-- owl-carousel owl-theme --}}
    <div  id="slider" class=" w-[100vw] h-[98vh]">


        <!-- Add more video slides as needed -->

    </div>
    @if($formSettings->allow_touch)

        <div id="ControlButtons" class="absolute top-1/2 w-full px-8 flex justify-between">

        </div>
    @endif
</div>
@push('scripts')
    <script   src="{{ asset('js/config.js') }}"></script>

    <script   src="{{ asset('js/templateFormMedia.js') }}"></script>
   
@endpush
