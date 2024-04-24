<div class="p-1 mt-4 mx-1 text-center">
    @if(!$validAddResponses)
    <span class="text-primary_red text-sm text-center">
   {{ __('main.responsesadderror') }}
    @elseif(!$currentsubscribe->valid)
    <span class="text-primary_red text-sm text-center">
        {{ __('Your plan has been expired.') }}
    </span>
    @else
    <ul wire:ignore class="relative flex justify-between items-center xs:grid xs:col-span-12 space-x-4 xs:space-x-0 ">
        @if($action=="buyresponses")

        @foreach ($responsesCategories as $cat)

        @if($currentsubscribe->num_of_responses+$cat->num<=$maxnumresponses&&$cat->num>0)

        <x-responses-category-item :cat="$cat" :choosenCategory="$choosenCategory"  />
        @endif
        @endforeach


        @else

        @foreach ($responsesCategories as $cat)

        @if($currentsubscribe->num_of_responses+$cat->num<=$maxnumresponses)

        <x-responses-category-item :cat="$cat" :choosenCategory="$choosenCategory"  />
        @endif
        @endforeach

        @endif

    </ul>


    </div>
           <div class="flex justify-center items-center">
            <span class="text-sm font-bold text-red-400 error" id="error"></span>

           </div>
    <div class="grid justify-center items-center mt-2">

        <button id="buyButton"  onclick="initBuy()"  class=" bg-secondary hover:bg-secondary_1 text-white text-md rounded-lg p-1 w-25 h-12 min-w-[100px]">
            {{ __('main.checkout') }}
       </button>

    </div>
    @endif

</div>
<script>
    function initBuy() {
        document.querySelectorAll('input[name="category_responses"]').forEach(function(item) {
            item.disabled = true;
        });
        try {
            value=document.querySelector('input[name="category_responses"]:checked').value;
         if(value)
        Livewire.emit('nextStep', value);
        } catch (error) {
            document.getElementById('error').innerHTML = 'Please choose category';


        }

     }
</script>
