<li   class="2xl:col-span-2 xl:col-span-2 lg:col-span-2 md:col-span-4  sm:col-span-4 xs:col-span-12 w-32 max-w-32 min-w-32  xs:w-full    "  >
<input  value="{{ $cat->id }}"   class="hidden peer" name="category_responses" id="item{{ $cat->id }}" type="radio" required>
<label for="item{{ $cat->id }}" class="inline-flex items-center justify-between w-full p-1  text-gray-500 bg-white disabled:bg-slate-50 border-[2px] rounded-lg cursor-pointer
                                                   peer-checked:border-blue-400
                                                hover:text-gray-600 hover:bg-gray-100 ">
   <div class="grid grid-rows-3 gap-2 space-y-2 justify-center items-center w-full">
    <h1 class="text-center text-2xl font-bold p-2 bg-primary_blue text-secondary_blue rounded ">
        {{ $cat->num }}
    </h1>
    <h1 class="text-center text-sm">
        @if($cat->num==0)
        {{ __('main.continuewithoutresponses')}}
        @else
          {{ __('main.responses')}}
        @endif
    </h1>
    <h1 class="text-center font-bold text-sm">
        {{ $cat->price }} AED
    </h1>
   </div>
</label>
</li>

<script>

</script>
