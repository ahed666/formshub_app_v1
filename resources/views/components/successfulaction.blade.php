<div wire:ignore id="toast-update" class="hidden absolute z-50 w-full max-w-xs top-5 right-5  text-sm  border-t-4 rounded-l-full rounded-r-full rounded border-secondary_blue text-secondary_blue bg-primary_blue px-4 py-3 shadow" role="alert">
    <div class="flex">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 ">
            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg class="text-valid w-6 h-6 inline-block" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
            <g id="SVGRepo_iconCarrier"> <path opacity="0.1" d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" fill="currentColor"/> <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2"/> <path d="M9 12L10.6828 13.6828V13.6828C10.858 13.858 11.142 13.858 11.3172 13.6828V13.6828L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
            </svg>
        </div>
        @if($kiosks)
        <div class="ml-3 text-sm font-normal">
            <span class="mb-1 text-sm font-semibold text-gray-900 ">{{ __('main.successfullyaction_title') }}</span>
            @if(count($kiosks)>0)
            <div class="mb-2 text-sm text-black font-normal">{{ __('main.successfullyaction_withkiosks') }}</div>
            @else
            <div class="mb-2 text-sm text-black font-normal">{{ __('main.successfullyaction_withoutkiosks') }}</div>
            @endif
            @if(count($kiosks)>0)
            <div class="grid grid-cols-2 gap-2">
                <x-jet-secondary-button onclick="hideAlert()" class="text-center justify-center"  type="button"   >
                    {{ __('main.notnow') }}
                </x-jet-secondary-button>
                <x-jet-button class="ml-3 text-center justify-center" onclick="hideAlert()" wire:click="updateformonkiosks()" type="button"  >
                    {{ __('main.update') }}
                </x-jet-button>
            </div>
            @endif
        </div>
        @endif
        <button type="button" class="ml-auto -mx-1.5 -my-1.5  items-center justify-center flex-shrink-0 text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 " data-dismiss-target="#toast-update" aria-label="Close">
            <span class="sr-only">{{ __('main.close') }}</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
</div>
