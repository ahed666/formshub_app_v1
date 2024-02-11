@props(['account', 'component' => 'jet-dropdown-link'])

<form method="POST" action="{{ route('current-account.update') }}" x-data>
    @method('PUT')
    @csrf

    <!-- Hidden Account ID -->
    <input type="hidden"  name="account_id" value="{{ $account->id }}">

    <x-dynamic-component :component="$component" @class(['no-underline hover:no-underline focus:no-underline '])  href="#" x-on:click.prevent="$root.submit();">
        <div class="flex xs:grid items-center justify-center  grid-cols-12 xs:border-[1px] xs:border-gray-200 xs:p-1">
            @php
            $owner=DB::table('users')->join('accounts','users.id','=','accounts.user_id')->where('users.id','=',$account->user_id)->where('accounts.personal_account','=','1')->select('users.*')->first();

            @endphp
            <div class="col-span-2 xs:flex xs:justify-center xs:col-span-12">
            @if (Auth::user()->isCurrentAccount($account))
                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">

                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                <svg class="text-valid mr-[6px] h-5 w-5 inline-block" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                <g id="SVGRepo_iconCarrier"> <path opacity="0.1" d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" fill="currentColor"/> <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2"/> <path d="M9 12L10.6828 13.6828V13.6828C10.858 13.858 11.142 13.858 11.3172 13.6828V13.6828L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                </svg>

            @endif
            </div>
            <div  class=" grid col-span-7 xs:col-span-8 w-full text-left overflow-hidden whitespace-nowrap">
                <h1 class="text-[10px] truncate text-left">{{ $owner->name }}</h1>
                <h1 class="text-[10px]  text-left">{{ __('(') }}<span class="">{{ $owner->email }}</span>{{ __(')') }}</h1>
                </div>
            {{-- get user personal account  --}}

            <div class="col-span-3 xs:col-span-4">
                @if($account->user_id==Auth::user()->id)
                    <span class="bg-blue-200 ml-[2px] mr-[2px] text-blue-400 p-1 text-[10px]">{{ __('Owner') }}</span>
                    @else
                    <span class="bg-gray-200 ml-[2px] mr-[2px] text-blue-400 p-1 text-[10px]">{{ __('Shared') }}</span>
                @endif
            </div>

        </div>
    </x-dynamic-component>
</form>
