
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account Settings') }}
        </h2>
    </x-slot>

    <div class=" px-52 py-12 sm:px-6 lg:px-8   xs:px-0">
        {{-- account id --}}
        <div class="bg-white drop-shadow rounded-lg md:grid md:grid-cols-3 md:gap-6 px-4 py-5">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-0 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('main.accountid') }}</h3>


                </div>


            </div>

            <div class="mt-2 md:mt-0 md:col-span-2">
                <h1 class="font-bold text-xl text-secondary">{{ 'AC-'.$account->id }}</h1>
            </div>
        </div>
        @livewire('accounts.update-account-name-form', ['account' => $account])
        @livewire('accounts.account-member-manager', ['account' => $account])
        {{-- && ! $account->personal_account --}}
        {{-- @if (Gate::check('delete', $account) )
            <x-jet-section-border />

            <div class="">
                @livewire('accounts.delete-account-form', ['account' => $account])
            </div>
        @endif --}}
    </div>


    {{-- <p class="alert alert-{{$status}}">{{ Session::get($status) }}</p> --}}




</x-app-layout>



