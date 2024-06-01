<div class="pl-10 w-full h-auto grid grid-cols-12  justify-center mt-[1px] ">
    {{-- score --}}
   <div class="col-span-3 "><x-score-item :i="$i" :answers="$answers" /></div>

    <div class="col-span-3 "><x-hide-answer :i="$i" :answers="$answers" /></div>
    <div class="col-span-6 "><x-answer-actions :i="$i" :answers="$answers" /></div>
</div>
