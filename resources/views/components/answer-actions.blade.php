<div  class="grid">

    <div class="">
        <label class="mb-[1px] flex justify-start items-center cursor-pointer" for="selectedAction-{{ $i }}">

            <input    wire:model.defer="answers.{{ $i }}.action" value="None" data-bs-toggle="tooltip"
                data-bs-html="true" title="No action if the answer chosen"
                class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-3 h-3    " name="selectedAction-{{ $i }}" type="radio" />
            <span class="text-xs mr-1 ml-1">{{ __('main.none') }}</span>
        </label>
    </div>
    <div class="">
        <label class="mb-[1px] flex justify-start items-center cursor-pointer" for="selectedAction-{{ $i }}">

            <input  wire:model.defer="answers.{{ $i }}.action" value="Skip" data-bs-toggle="tooltip"
                data-bs-html="true" title="Skip Next Question if the answer chosen"
                class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-3 h-3 " name="selectedAction-{{ $i }}" type="radio" />
            <span class="text-xs mr-1 ml-1">{{ __('main.skipnextquestion') }}</span>
        </label>
    </div>
    <div class="">
        <label class="mb-[1px] flex justify-start items-center cursor-pointer" for="selectedAction-{{ $i }}">

            <input  wire:model.defer="answers.{{ $i }}.action" value="End" data-bs-toggle="tooltip"
                data-bs-html="true" title="End Form if the answer chosen"
                class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-3 h-3 " name="selectedAction-{{ $i }}" type="radio" />
            <span class="text-xs mr-1 ml-1">{{ __('main.endform') }}</span>
        </label>
    </div>
</div>

{{--
<div class="  "  x-data="{ isOpen: false, selectedAction: '{{ $answers[$i]['action'] }}' }">
    <div class="max-h-[20px]">
        <span class="text-xs">{{ __('main.action') }}</span>
    </div>
    <div>
        <x-jet-dropdown align="false"  width="w-[150px]">
            <x-slot name="trigger">
                <span class="inline-flex  rounded-md">

                    <button type="button" class=" no-underline hover:no-underline focus:no-underline
                    focus:outline-none inline-flex items-center
                    text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50
                    hover:text-gray-700  focus:bg-gray-50 active:bg-gray-50
                    transition">
                        <span class="pl-[2px] text-xs {{ $answers[$i]['action']!="None"?"text-primary_red":"" }} " >
                            {{ __('main.'.$answers[$i]['action']) }}
                        </span>
                        <svg fill="none" class="w-4 h-4" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"></path>
                        </svg>
                    </button>
                </span>
            </x-slot>

            <x-slot name="content">
                <div class="w-60">


                    <div class="border-t border-gray-100"></div>
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('main.ifanswerchoosen') }}
                    </div>
                    <div class="flex ml-2  mr-2">
                        <label class="cursor-pointer">
                            <span class="text-xs mr-1 ml-1">{{ __('main.none') }}</span>
                            <input x-model="selectedAction"  wire:model="answers.{{ $i }}.action" value="None" data-bs-toggle="tooltip"
                                data-bs-html="true" title="No action if the answer chosen"
                                class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4 hidden" type="radio" />
                        </label>
                    </div>
                    <div class="flex ml-2 mr-2">
                        <label class="cursor-pointer">
                            <span class="text-xs mr-1 ml-1">{{ __('main.skipnextquestion') }}</span>
                            <input x-model="selectedAction" wire:model="answers.{{ $i }}.action" value="Skip" data-bs-toggle="tooltip"
                                data-bs-html="true" title="Skip Next Question if the answer chosen"
                                class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4 hidden" type="radio" />
                        </label>
                    </div>
                    <div class="flex ml-2  mr-2">
                        <label class="cursor-pointer">
                            <span class="text-xs mr-1 ml-1">{{ __('main.endform') }}</span>
                            <input x-model="selectedAction" wire:model="answers.{{ $i }}.action" value="End" data-bs-toggle="tooltip"
                                data-bs-html="true" title="End Form if the answer chosen"
                                class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4 hidden" type="radio" />
                        </label>
                    </div>




                </div>
            </x-slot>
        </x-jet-dropdown>
    </div>
    {{-- <div x-show="selectedAction || selectedAction === ''" class="mt-2 text-gray-800 flex justify-center items-center">
       <span class="text-xs" x-text="selectedAction || 'None'"></span>
    </div> --}}
{{-- </div>

 --}}
