@props(['account', 'component' => 'jet-dropdown-link'])

<form method="POST" action="{{ route('current-account.update') }}" x-data>
    @method('PUT')
    @csrf

    <!-- Hidden account ID -->
    <input type="hidden" name="account_id" value="{{ $account->id }}">

    <x-dynamic-component :component="$component" href="#" x-on:click.prevent="$root.submit();">
        <div class="flex items-center">
            @if (Auth::user()->isCurrentAccount($account))
                <svg class="mr-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @endif

            <div class="truncate">{{ $account->name }}</div>
        </div>
    </x-dynamic-component>
</form>
