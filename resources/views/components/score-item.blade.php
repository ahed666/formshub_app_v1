<div class="" x-data="{ isOpen: false, selectedScore: '{{ $answers[$i]['score'] }}' }" >
    <div class="max-h-[20px]">
      <span class="text-xs">{{ __('main.score') }}</span>
    </div>
    <div   class=" ">
        <input  wire:model.defer="answers.{{ $i }}.score"   max="10" min="0" onKeyDown="return false"   class=" p-[1px] text-xs text-center focus:ring-transparent  w-10 h-6 rounded-md" type="number" />
    </div>
</div>



