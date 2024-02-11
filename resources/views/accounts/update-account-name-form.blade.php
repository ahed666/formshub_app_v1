

        <x-jet-form-section submit="updateAccountName">
            <x-slot name="title">
            </x-slot>

            <x-slot name="description">

            </x-slot>

            <x-slot name="form">
                <div class="my-2 col-span-6">
                    <h1 class="text-lg">  {{ __('main.account_billing_information') }}</h1>
                </div>
                <!-- Account Owner Information -->
                <div class="col-span-6">
                    <x-jet-label value="{{ __('main.accountowner') }}" />

                    <div class="flex items-center mt-2">
                        <img class="w-12 h-12 rounded-full object-cover" src="{{ $account->owner->profile_photo_url }}" alt="{{ $account->owner->name }}">

                        <div class="ml-4 leading-tight">
                            <div>{{ $account->owner->name }}</div>
                            <div class="text-gray-700 text-sm">{{ $account->owner->email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Account Name -->
                {{-- <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Account  Holder Name') }}" />

                    <x-jet-input id="name"
                                type="text"
                                maxlength="35"
                                class="mt-1 block  w-1/2"
                                wire:model.defer="state.name"
                                :disabled="! Gate::check('update', $account)" />

                    <x-jet-input-error for="name" class="mt-2" />
                </div> --}}
                {{-- bussiness name --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="business_name" value="{{ __('main.businessname') }}" />

                    <x-jet-input  id="business_name"
                                type="text"
                                maxlength="60"
                                class="mt-1 block w-1/2"
                                wire:model.defer="state.business_name"
                                :disabled="! Gate::check('update', $account)" />

                    <x-jet-input-error for="business_name" class="mt-2" />
                </div>
                {{-- country/city locations --}}
                <div class="col-span-6 sm:col-span-4 flex gap-1">
                    {{-- country --}}
                    <div class="col-span-3 sm:col-span-2  ">
                        <x-jet-label for="country" value="{{ __('main.country') }}" />
                        <select  name="country" id="country"   wire:model.defer="state.country" class="mt-1
                        text-sm border-gray-300  focus:border-secondary mr-2
                         focus:ring-secondary   rounded-md shadow-sm block  w-full" value={{ $account->country }} wire:model="state.country"   required>

                        {{-- <option  class="text-sm" value=" " >{{__('Select Country')}}</option> --}}
                        <option selected  class="text-sm" value="United Arab Emaraties" >{{__('United Arab Emaraties')}}</option>


                        </select>
                        <x-jet-input-error for="country" class="mt-2" />
                    </div>
                    {{-- city --}}
                    <div class="col-span-3 sm:col-span-2 ">
                        <x-jet-label for="city" value="{{ __('main.city') }}" />
                        <select  name="city" id="city" wire:model.defer="state.city" class="mt-1
                        text-sm border-gray-300  focus:border-secondary mr-2
                         focus:ring-secondary   rounded-md shadow-sm block  w-full
                        "   required>

                        {{-- <option  class="text-sm" value=" " >{{__('Select City')}}</option> --}}
                        <option class="text-sm"  value="Abu Dhabi" >{{__('Abu Dhabi')}}</option>
                        <option class="text-sm" value="Dubai" >{{__('Dubai')}}</option>
                        <option class="text-sm" value="Sharjah" >{{__('Sharjah')}}</option>
                        <option class="text-sm" value="Ajman" >{{__('Ajman')}}</option>
                        <option class="text-sm" value="Umm Al Quwain" >{{__('Umm Al Quwain')}}</option>
                        <option class="text-sm" value="Ras Al Khaimah" >{{__('Ras Al Khaimah')}}</option>
                        <option class="text-sm" value="Al Ain" >{{__('Al Ain')}}</option>
                        <option class="text-sm" value="Fujairah" >{{__('Fujairah')}}</option>

                        </select>
                        <x-jet-input-error for="city" class="mt-2" />
                    </div>

                </div>
                {{-- Phone Number --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="phone_number" value="{{ __('main.phonenumber') }}" />

                    <x-jet-input id="phone_number"
                                type="text"
                                maxlength="12"
                                pattern="^(02|03|04|06|07|09|)\d{7}$" title="Please enter a valid UAE  phone number with either '02xxxxxxx','03xxxxxxx','04xxxxxxx','06xxxxxxx','07xxxxxxx' or '09xxxxxxx' "
                                class="mt-1 block  w-1/2"
                                wire:model.defer="state.phone_number"
                                :disabled="! Gate::check('update', $account)" />

                    <x-jet-input-error for="phone_number" class="mt-2" />
                </div>
                {{-- billing address --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="billing_address" value="{{ __('main.billingaddress') }}" />

                    <x-jet-input id="billing_address"
                                type="text"
                                maxlength="150"
                                class="mt-1 block  w-1/2"
                                wire:model.defer="state.billing_address"
                                :disabled="! Gate::check('update', $account)" />

                    <x-jet-input-error for="billing_address" class="mt-2" />
                </div>

                {{-- tax Number --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="tax_number" value="{{ __('main.taxnumber') }}" />

                    <x-jet-input id="tax_number"
                                type="text"
                                maxlength="20"
                                class="mt-1 block  w-1/2"
                                wire:model.defer="state.tax_number"
                                :disabled="! Gate::check('update', $account)" />

                    <x-jet-input-error for="tax_number" class="mt-2" />
                </div>
            </x-slot>

            @if (Gate::check('update', $account))
                <x-slot name="actions" >


                    <x-jet-button>
                        {{ __('main.save') }}
                    </x-jet-button>
                    <x-jet-action-message class="mr-3 ml-3 text-green-600" on="saved">
                        {{ __('main.accountinfosuccessfulyupdated') }}
                    </x-jet-action-message>
                </x-slot>
            @endif
        </x-jet-form-section>