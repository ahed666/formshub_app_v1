<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 ">
            {{ __('main.profileinformation') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 ">
            {{ __('main.profile_title') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        {{-- name --}}
        <div>
            <x-input-label for="name" :value="__('main.name')" />
            <x-text-input  maxlength="35" id="name" name="name" type="text"  class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        {{-- email --}}
        <div>
            <x-input-label for="email" :value="__('main.email')" />
             <div class="relative">
            <x-text-input disabled maxlength="50"  id="email" name="email" pattern="email" title="enter valid email" type="email" class="mt-1 block w-full opacity-50" :value="old('email', $user->email)" required autocomplete="email" />
            <div class="flex justify-end items-center absolute right-0"><a id="editemailbutton" onclick="ShowEmail()" class="text-xs text-secondary hover:text-secondary_1 font-bold cursor-pointer hover:underline" type="button">{{ __('main.changeemail') }}</a></div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
             {{-- {{ session('error') }} --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 ">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600  hover:text-gray-900  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ">
                            {{ __('Click here to send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 ">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @elseif(session('error'))
                    <p class="mt-2 font-medium text-sm text-red-600 ">
                        {{ __('too many attempts. try after :seconds seconds ',['seconds' => session('error')]) }}
                    </p>
                    @endif
                </div>
            @endif
        </div>
        {{-- mobile number --}}
        <div>
            <x-input-label for="mobile_number" :value="__('main.mobilenumber')" />
            <div class="flex ">
                <input class="border-gray-300  focus:border-secondary mr-2
                 focus:ring-secondary  rounded-md shadow-sm mt-1 block w-1/5" type="text" value="+971" disabled class="w-4">
                <x-text-input id="mobile_number" name="mobile_number"  maxlength="10" pattern="^(05|5)\d{8}$" title="Please enter a valid UAE mobile phone number with either '05xxxxxxxx' or '5xxxxxxxx' "  type="text" class="mt-1 block w-full" :value="old('mobile_number', $user->mobile_number)" required autofocus autocomplete="mobile_number" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('mobile_number')" />
        </div>
        {{-- TimeZone --}}
        <div class=" " >
            <x-jet-label   for="timezone" value="{{ __('main.timezone') }}" />
            <select :value="old('', $user->timezone)"  name="timezone" id="timezone" class="border-gray-300  focus:border-secondary mr-2
                focus:ring-secondary
            rounded-md shadow-sm block  text-sm w-full xs:w-full"   >
                @php
                        $timezones = \DateTimeZone::listIdentifiers();
                @endphp

            @foreach($timezones as $tmzone)
                <option class="text-sm" value="{{ $tmzone }}" {{ $tmzone==$user->timezone?"selected":"" }}>
                    {{ $tmzone }}
                </option>
            @endforeach

            </select>

    </div>
        {{-- email subscriptions --}}
        <div>
            <x-input-label for="subscriptions" :value="__('main.communication')" />
            <div id="subscriptions" class="border-gray-300 border-[1px] rounded-md p-2 mt-[1px] ">
                <div class="flex xs:grid justify-between space-x-2 xs:space-x-0 ">
                    {{-- notifications --}}
                    <div class="min-w-[200px]">
                        <input  id="email_sub_notification" {{ $user->email_sub_notification==1?"checked":"" }}  name="email_sub_notification"  value="{{ old('email_sub_notification', $user->email_sub_notification) }}"
                        aria-describedby="email_sub_notification" type="checkbox"
                        class="w-4 h-4 border border-secondary rounded bg-primary focus:ring-[1px] focus:ring-primary
                        " >
                        <label for="email_sub_notification" class="text-md font-light text-gray-500 ">
                            {{ __('main.notifications') }}{{ __('main.recommended') }}</label>
                    </div>
                    <div class="min-w-[200px]">
                        {{-- marketing --}}
                        <input  id="email_sub_offers_events" {{ $user->email_sub_offers_events==1?"checked":"" }}  name="email_sub_offers_events"  value="{{ old('email_sub_offers_events', $user->email_sub_offers_events) }}" aria-describedby="email_sub_offers_events" type="checkbox"
                        class="w-4 h-4 border border-secondary rounded bg-primary focus:ring-[1px] focus:ring-primary
                        " >
                        <label for="email_sub_offers_events" class="text-md font-light text-gray-500 ">
                            {{ __('main.offers_events') }}</label>
                    </div>
                </div>
                <div class="flex xs:grid justify-between space-x-2 xs:space-x-0">

                    {{-- payment & subscriptions --}}
                    <div class="min-w-[200px]">
                        <input  id="email_sub_payment_subscriptions" {{ $user->email_sub_payment_subscriptions==1?"checked":"" }}  name="email_sub_payment_subscriptions"  value="{{ old('email_sub_payment_subscriptions', $user->email_sub_payment_subscriptions) }}" aria-describedby="email_sub_payment_subscriptions" type="checkbox"
                        class="w-4 h-4 border border-secondary rounded bg-primary focus:ring-[1px] focus:ring-primary
                        " >
                        <label for="email_sub_payment_subscriptions" class="text-md font-light text-gray-500 ">
                          {{ __('main.paymentsubscriptions') }} {{ __('main.recommended') }}</label>
                    </div>
                     {{-- security --}}
                     <div class="min-w-[200px]">
                        <input  id="email_sub_security" {{ $user->email_sub_security==1?"checked":"" }}  name="email_sub_security"  value="{{ old('email_sub_security', $user->email_sub_security) }}" aria-describedby="email_sub_security" type="checkbox"
                        class="w-4 h-4 border border-secondary rounded bg-primary focus:ring-[1px] focus:ring-primary
                        " >
                        <label for="email_sub_security" class="text-md font-light text-gray-500 ">
                            {{ __('main.security') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('main.save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-green-600 "
                >{{ __('main.saveprofileupdatesuccessfully') }}</p>
            @endif
        </div>
    </form>
</section>
@push('scripts')
    <script>
        function ShowEmail(){
          var EmailInput=document.getElementById('email');
          var EditEmailButton=document.getElementById('editemailbutton');
          EmailInput.disabled  = !EmailInput.disabled ;
          EditEmailButton.classList.toggle('hidden');
          EmailInput.classList.toggle('opacity-50');


        }
    </script>
@endpush
