<x-app-layout>
    <input type="hidden" id="message" value="{{ session('message') }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>


        <div class="px-52 py-12 sm:px-6 lg:px-8  xs:px-0">
            <div class="p-4  sm:mt-0 sm:p-8 bg-white  drop-shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 mt-5 sm:mt-0  sm:p-8 bg-white  drop-shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
            </div>
            <div class="mt-5 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-5 sm:mt-0">
                        @livewire('profile.two-factor-authentication-form')
                </div>

                <x-jet-section-border />
            @endif

            <div class="p-4 mt-5 sm:mt-0 sm:p-8 bg-white  drop-shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
            </div>

        </div>

</x-app-layout>

