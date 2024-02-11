<div class="grid grid-cols-12 justify-between items-center bg-gray-50 p-1 rounded-[0.5rem] max-h-10 ">
    {{-- name action --}}
    <div class="col-span-8">
        <h1 data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $action }}"  class="text-sm whitespace-nowrap overflow-hidden">{{ $action }}</h1>
    </div>
    {{-- buttons --}}
    @if($actionType=="responses_today")

        <div class="flex justify-end col-span-4"><a class=" inline-flex items-center p-1 w-14 h-7 text-center  bg-secondary_blue hover:bg-secondary_1 hover:cursor-pointer
                    border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest
                    active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3 "
                    wire:click="hideAction({{ $actionId }})"><div class="flex justify-center items-center text-center w-full"><span>{{ __('main.ok') }}</span></div></a></div>
    @else
        <div class="flex justify-end items-center col-span-4">
            @if($actionType=="subscription_expired"||$actionType=="account_locked")
                <a class="inline-flex items-center p-1 bg-secondary_blue whitespace-nowrap
                border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3"
                href="{{ route('subscriptions') }}">{{ __('main.fixit') }}</a>

            @elseif($actionType=="no_forms")
                <a class="inline-flex items-center p-1 bg-secondary_blue whitespace-nowrap
                border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3"
                href="{{ route('forms') }}">{{ __('main.createform') }}</a>
            @elseif($actionType=="no_kiosks")
                <a class="inline-flex items-center p-1 bg-secondary_blue whitespace-nowrap
                border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3"
                href="{{ route('kiosks') }}">{{ __('main.addone') }}</a>
            @elseif($actionType=="less_than_minimun_responses"||$actionType=="outof_responses")
                <a class="inline-flex items-center p-1 bg-secondary_blue whitespace-nowrap
                border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3"
                href="{{ route('subscriptions') }}">{{ __('main.getmore') }}</a>
            @elseif($actionType=="open_tasks")
                <a class="inline-flex items-center p-1 bg-secondary_blue whitespace-nowrap
                border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3"
                href="{{ route('todolist') }}">{{ __('main.checkitout') }}</a>
            @endif
            <button class="inline-flex items-center p-1 bg-gray-400
                            border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest
                            active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3 "
                            wire:click="hideAction({{ $actionId }})">   {{ __('main.dismiss') }}
            </button>
        </div>
    @endif

</div>
