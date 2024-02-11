<div class="" x-data="{ id:'{{ $i }}', selectedHide: {{ $answers[$i]['hide'] ? 'true' : 'false' }} }"   >
    <div class="max-h-[20px]">
      <span class="text-xs" >
      {{ $answers[$i]['hide']?__('main.hide'):__('main.show') }}
     </span>
    </div>
    @php
      $selectedHideCount  =count(array_filter($answers, function ($answer) {return $answer['hide'] == true;}));
    @endphp
    <label class="cursor-pointer">
        <input  x-bind:disabled="!selectedHide && ({{ count($answers) }} - {{ $selectedHideCount }}) === 1"
         type="checkbox" name="hide-{{ $i }}"  wire:model="answers.{{ $i }}.hide" x-model="selectedHide" class="hidden" >
        <?xml version="1.0" encoding="utf-8"?>
        <svg class="w-6 h-6 cursor-pointer {{ $answers[$i]['hide']?"text-primary_red":"text-svg_primary" }}  "     viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g >
        <path  id="Vector-{{ $i }}" d="M5.75 5.75L18.25 18.25M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </g>
        </svg>
    </label>
</div>

