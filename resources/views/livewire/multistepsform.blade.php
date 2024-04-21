<div>
{{-- wire:submit.prevent="register" --}}
        <form   method="POST"  action="{{ route('register') }}" >
            @csrf

            <div class="grid gap-4 mb-4 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2">
                <div class="" >
                    <x-jet-label style="" class="text-secondary mx-2 mt-2 mb-[2px] lg:w-30 xl:w-30" for="country" value="{{ __('auth.country') }}"  />
                    <select autofocus name="country" id="country" class="text-sm border-gray-300  focus:border-secondary mr-2
                     focus:ring-secondary  rounded-md shadow-sm block  w-full" wire:change="onchangestepone()" wire:model="country" required>

                    @foreach ($countries as $Country )
                    @if($Country->country=="United Arab Emaraties")
                    <option class="text-sm" value="{{$Country->country}}" selected >{{$Country->country}}</option>
                    @else
                    <option class="text-sm" value="{{$Country->country}}" >{{$Country->country}}</option>
                    @endif
                    @endforeach

                    </select>

                    @error('country') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300">{{ $message }}</span> @enderror

                </div>
                <div class="" >
                    <x-jet-label style="white-space:nowrap;" class="text-secondary mx-2 mt-2 mb-[2px] lg:w-30 xl:w-30" for="city" value="{{ __('auth.city') }}" />
                    <select   name="city" id="city" class="text-sm
                    border-gray-300  focus:border-secondary mr-2
                     focus:ring-secondary  rounded-md shadow-sm block  w-full" required  wire:model="city">
                    <option     class="text-sm" value="">{{   __('Select one') }}</option>
                    @foreach ($cities as $city )
                    <option class="text-sm" value="{{$city->city_name}}" >{{$city->city_name}}</option>
                    @endforeach

                    </select>
                    @error('city') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300">{{ $message }}</span> @enderror
                </div>
            </div>



             <div class="text-lg font-bold card-header  text-black">{{ __('auth.personalinformation') }} </div>
            <div class="grid gap-4 mb-4 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3">
                <div class=" ">
                    <x-jet-label style="white-space:nowrap;" class="text-secondary mx-2 mt-2 mb-[2px] lg:w-30 xl:w-30" for="name" value="{{ __('auth.fullname') }}" />

                    <input  maxlength="35" placeholder="Adam" id="name"
                     class="border-gray-300  focus:border-secondary mr-2
                      focus:ring-secondary rounded-md shadow-sm block w-full placeholder-gray-300 text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" wire:model.debounce.500ms="name" />
                    @error('name') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300" style="">{{ $message }}</span> @enderror
                </div>

                <div class="">
                    <x-jet-label style="white-space:nowrap;x;" class="text-secondary mx-2 mt-2 mb-[2px] lg:w-30 xl:w-30" for="email" value="{{ __('auth.email_label') }}" />
                    <input  maxlength="50" placeholder="example@domain.com" id="email"
                    class="border-gray-300  focus:border-secondary mr-2
                     focus:ring-secondary  rounded-md shadow-sm block  w-full placeholder-gray-300 text-sm " type="email" name="email"  required  wire:model.debounce.500ms="email" />
                    @error('email') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300" style="">{{ $message }}</span> @enderror

                </div>

                <div class="">

                    <x-jet-label style="white-space:nowrap;" class="text-secondary mx-2 mt-2 mb-[2px] block font-medium text-sm  lg:w-30 xl:w-30" for="" value="{{ __('auth.mobilenumber') }}" />
                    <div class=" row flex ">
                        <input  type="text" id="CountryMobileCode" class="border-gray-300  focus:border-secondary mr-2
                         focus:ring-secondary  rounded-md shadow-sm block text-sm  w-20 ml-[2px] mr-2 " value={{$CountryMobileCode}} type="text" name="CountryMobileCode"  wire:model.debounce.500ms="CountryMobileCode" disabled>
                    <input pattern="^(05|5)\d{8}$" title="Please enter a valid UAE mobile phone number with either '05xxxxxxxx' or '5xxxxxxxx' "
                    placeholder="5xxxxxxxx" maxlength="10"  id="mobile_number"
                    class="border-gray-300   focus:border-secondary mr-2
                     focus:ring-secondary  rounded-md shadow-sm block  w-full placeholder-gray-300 text-sm " type="text" required  name="mobile_number"  wire:model="mobile_number"  />
                    </div>


                    @error('mobile_number') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300" style="">{{$message}}</span> @enderror

                </div>
            </div>
            <div class="text-lg font-bold card-header  text-black">{{ __('auth.accountbillinginformation') }} </div>
            <div class="grid gap-4 mb-4 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4">
                {{-- bussiness name --}}
                <div class=" col-span-2">
                    <x-jet-label style="white-space:nowrap;" class="text-secondary mx-2 mt-2 mb-[2px]  lg:w-30 xl:w-30" for="business_name" value="{{ __('auth.businessname') }}({{ __('auth.optional') }})" />
                    <input maxlength="60"  placeholder=""  id="business_name" class="border-gray-300  focus:border-secondary mr-2
                     focus:ring-secondary  rounded-md shadow-sm block  w-full placeholder-gray-300 text-sm" type="text" name="business_name" wire:model="business_name"  />
                    @error('business_name') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300">{{ $message }}</span> @enderror
                </div>
                {{-- phone number  --}}
                <div class="">
                    <x-jet-label style="white-space:nowrap;" class="text-secondary mx-2 mt-2 mb-[2px] lg:w-30 xl:w-30" for="phone_number" value="{{ __('auth.phonenumber') }}({{ __('auth.optional') }})" />
                    <input  maxlength="10"  id="phone_number" placeholder="" class="border-gray-300  focus:border-secondary mr-2
                     focus:ring-secondary  rounded-md shadow-sm block  w-full placeholder-gray-300 text-sm" type="text" name="phone_number"   wire:model="phone_number"  />
                    @error('phone_number') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300">{{ $message }}</span> @enderror
                </div>
                 {{-- tax number --}}
                <div class="">
                    <x-jet-label style="white-space:nowrap;" class="text-secondary mx-2 mt-2 mb-[2px] lg:w-30 xl:w-30" for="tax_number" value="{{ __('auth.taxnumber') }}({{ __('auth.optional') }})" />
                    <input maxlength="20" placeholder="" id="tax_number" class="border-gray-300  focus:border-secondary mr-2
                     focus:ring-secondary  rounded-md shadow-sm block  w-full placeholder-gray-300 text-sm" type="text" name="tax_number"  wire:model="tax_number" />
                    @error('tax_number') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300 ">{{ $message }}</span> @enderror
                </div>


            </div>
            {{-- biiling Address --}}
            <div class="grid gap-4 mb-4 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4">
                <div class="col-span-4 ">
                    <x-jet-label style="white-space:nowrap;" class="text-secondary mx-2 mt-2 mb-[2px] lg:w-30 xl:w-30" for="billing_address" value="{{ __('auth.billingaddress') }}({{ __('auth.optional') }})" />
                    <input maxlength="150"  id="billing_address" placeholder="" class="border-gray-300   focus:border-secondary mr-2
                     focus:ring-secondary  rounded-md shadow-sm block  w-full placeholder-gray-300 text-sm" type="text" name="billing_address" wire:model="billing_address"  />
                    @error('billing_address') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="text-lg font-bold card-header  text-black">{{ __('Account Security') }} </div>
            <div class="grid gap-4 mb-4 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2">
                <div class="">

                    <div class="flex relative justify-between w-70  " >
                            <x-jet-label style="white-space:nowrap;" class="text-secondary mx-2 mt-2 mb-[2px] lg:w-30 xl:w-30" for="password" value="{{ __('auth.password_label') }}" />
                             <div class="flex items-center justify-end">
                                <div wire:ignore id="passwordStrength">
                                    <span class="mx-2 mt-2 mb-[2px] flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300" style="white-space:nowrap;margin:6px;">
                                        {{ __('*required') }}
                                    </span>
                                </div>
                                <div class="flex group" >
                                    <svg class="inline-block w-4 text-secondary h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                    <div style="right:-241px"  class=" inline-flex absolute bottom-0 whitespace-normal w-96  sm:right-1 items-center hidden mb-6 group-hover:flex">
                                        <span class=" relative text-ellipsis square z-10 p-2 text-xs leading-none text-gray-400  bg-white shadow-lg">
                                            {!! __('auth.passwordpolicy') !!}

                                        </span>

                                    </div>
                                </div>

                             </div>
                            {{-- <div class="justify-end" >
                                @if($passwordempty==1)
                                    @if($passwordStrength>=1)
                                        <span class="mx-2 mt-2 mb-[2px] flex font-medium text-sm text-gray-700  lg:w-30 xl:w-30 text-{{ $passwordLevelsColors[$passwordStrength] }}-600 " style="white-space:nowrap;margin:6px;">
                                        <svg class="flex w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                                        </svg>
                                        {{ $passwordLevels[$passwordStrength] }}
                                    @elseif($passwordStrength==0)
                                        <span class="mx-2 mt-2 mb-[2px] flex font-medium text-sm text-gray-700  lg:w-30 xl:w-30 text-{{ $passwordLevelsColors[$passwordStrength] }}-600 " style="white-space:nowrap;margin:6px;">
                                        <svg class="flex w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        {{ $passwordLevels[$passwordStrength] }}
                                    @endif
                                @elseif($passwordempty==0)
                                    <span class="mx-2 mt-2 mb-[2px] flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300" style="white-space:nowrap;margin:6px;">
                                        {{ __('*required') }}

                                @endif
                                <!-- Component Start -->
                                <div class="flex group" >
                                    <svg class="inline-block w-4 text-secondary h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                    <div style="right:-241px"  class=" inline-flex absolute bottom-0 whitespace-normal w-96  sm:right-1 items-center hidden mb-6 group-hover:flex">
                                        <span class=" relative text-ellipsis square z-10 p-2 text-xs leading-none text-gray-400  bg-white shadow-lg">
                                            {!! __('auth.passwordpolicy') !!}

                                        </span>

                                    </div>
                                </div>
                                </span>
                                <!-- Component End  -->
                            </div> --}}
                    </div>

                    <div class="relative" >
                        <input  oninput="validatePasswordStrength();validatePasswordMatch()" pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$"
                         title="Password must be strong"  wire:model="password" maxlength="30" id="password"
                          class="border-gray-300
                            focus:border-secondary mr-2
                           focus:ring-secondary
                         rounded-md shadow-sm block  w-full text-sm" type="{{ $show ? 'text' : 'password' }}" name="password"  required autocomplete="new-password"    />
                        <div class="w-9 absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">



                            <svg id="passIcon_password" class="h-6 w-8 text-gray-700 " fill="none" onclick="togglePasswordVisibility('password','passIcon_password')" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">

                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                                <g id="SVGRepo_iconCarrier">
                                    <path opacity="0.5" d="M10 22C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 18.7712 2 15" stroke="#1C274C" stroke-width="1.5"
                                    stroke-linecap="round"/> <path opacity="0.5" d="M22 15C22 18.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22"
                                    stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/> <path opacity="0.5"
                                    d="M14 2C17.7712 2 19.6569 2 20.8284 3.17157C22 4.34315 22 5.22876 22 9"
                                    stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                    <path opacity="0.5" d="M10 2C6.22876 2 4.34315 2 3.17157 3.17157C2 4.34315 2 5.22876 2 9" stroke="#1C274C" stroke-width="1.5"
                                    stroke-linecap="round"/>
                                    <path d="M5.89243 14.0598C5.29748 13.3697 5 13.0246 5 12C5 10.9754 5.29747 10.6303 5.89242 9.94021C7.08037 8.56222 9.07268 7
                                    12 7C14.9273 7 16.9196 8.56222 18.1076 9.94021C18.7025 10.6303 19 10.9754 19 12C19 13.0246 18.7025 13.3697 18.1076 14.0598C16.9196
                                    15.4378 14.9273 17 12 17C9.07268 17 7.08038 15.4378 5.89243 14.0598Z" stroke="#1C274C" stroke-width="1.5"/>
                                    <circle cx="12" cy="12" r="2" stroke="#1C274C" stroke-width="1.5"/>
                                </g>

                            </svg>



                        </div>
                        </div>

                    </div>
                    <div class="">
                        <x-jet-label style="white-space:nowrap;" class="text-secondary mx-2 mt-2 mb-[2px] lg:w-30 xl:w-30" for="password_confirmation" value="{{ __('auth.confirmpassword') }}" />
                        <div class="relative">
                            <input oninput="validatePasswordMatch()" maxlength="30"  id="password_confirmation"
                              class="border-gray-300  focus:border-secondary mr-2
                     focus:ring-secondary  rounded-md shadow-sm block  w-full text-sm"    type="password" name="password_confirmation"  required autocomplete="new-password"  wire:model="password_confirmation" />
                            <div class="w-9 absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">


                                <svg id="passIcon_password_confirmation" class="h-6 w-8 text-gray-700 " fill="none" onclick="togglePasswordVisibility('password_confirmation','passIcon_password_confirmation')" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">

                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                                    <g id="SVGRepo_iconCarrier">
                                        <path opacity="0.5" d="M10 22C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 18.7712 2 15" stroke="#1C274C" stroke-width="1.5"
                                        stroke-linecap="round"/> <path opacity="0.5" d="M22 15C22 18.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22"
                                        stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/> <path opacity="0.5"
                                        d="M14 2C17.7712 2 19.6569 2 20.8284 3.17157C22 4.34315 22 5.22876 22 9"
                                        stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                                        <path opacity="0.5" d="M10 2C6.22876 2 4.34315 2 3.17157 3.17157C2 4.34315 2 5.22876 2 9" stroke="#1C274C" stroke-width="1.5"
                                        stroke-linecap="round"/>
                                        <path d="M5.89243 14.0598C5.29748 13.3697 5 13.0246 5 12C5 10.9754 5.29747 10.6303 5.89242 9.94021C7.08037 8.56222 9.07268 7
                                        12 7C14.9273 7 16.9196 8.56222 18.1076 9.94021C18.7025 10.6303 19 10.9754 19 12C19 13.0246 18.7025 13.3697 18.1076 14.0598C16.9196
                                        15.4378 14.9273 17 12 17C9.07268 17 7.08038 15.4378 5.89243 14.0598Z" stroke="#1C274C" stroke-width="1.5"/>
                                        <circle cx="12" cy="12" r="2" stroke="#1C274C" stroke-width="1.5"/>
                                    </g>

                                </svg>



                            </div>
                        </div>

                        @error('password_confirmation') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300" required style="">{{ $message }}</span> @enderror

                    </div>


                </div>
                {{-- terms & conditions --}}
                <div class="grid gap-4 mb-6 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3 ">
                    <div class="">
                        <input id="terms"  name="terms" wire:model="terms"  aria-describedby="terms" type="checkbox" class="
                        w-4 h-4 border border-secondary rounded bg-primary focus:ring-[1px] focus:ring-primary
                           " required="">
                            <label for="terms" class="font-light text-gray-500  text-md ">{{ __('auth.acceptstart') }}
                            <a href="{{ route('terms_conditions') }}" class="font-medium text-blue-600  hover:underline" target="_blank"> {{ __('auth.termsconditions') }}</a>
                                {{ __('auth.acceptend') }}
                                <a href="{{ route('privacypolicy') }}" class="font-medium text-blue-600  hover:underline" target="_blank"> {{ __('auth.privacypolicy') }}</a></label>
                    </div>
                </div>
                {{-- subscribe email --}}
                {{-- <div class="grid gap-4 mb-6 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3 ">
                    <div class="col-span-2">
                        <input id="receive_emails"  name="receive_emails" wire:model="receive_emails" value="{{ $receive_emails }}" aria-describedby="receive_emails" type="checkbox"
                        class="w-4 h-4 border border-secondary rounded bg-primary focus:ring-[1px] focus:ring-primary " >
                        <label for="receive_emails" class="text-md font-light text-gray-500 ">
                            {{ __('I would like to receive emails from form point about our new offers and events ...etc.') }}</label>

                    </div>
                </div> --}}
                 {{-- source know us  --}}
                <div class=" pl-1 col-span-3" >
                        <x-jet-label style="white-space:nowrap;" class="text-secondary lg:w-30 xl:w-30" for="know_about_us" value="{{ __('auth.howknowaboutus') }}" />
                        <select   name="know_about_us" id="know_about_us" class="border-gray-300  focus:border-secondary mr-2
                         focus:ring-secondary
                        rounded-md shadow-sm block  text-sm w-1/4 xs:w-full"   wire:model="know_about_us">
                        <option class="text-sm" value="">{{   __('Select one') }}</option>

                        <option class="text-sm" value="Search engine (e.g. Google, Bing)" >{{__('auth.searchengine')}}</option>
                        <option class="text-sm" value="Recommendation from a friend" >{{__('auth.recommendation')}}</option>
                        <option class="text-sm" value="Social media" >{{__('auth.socialmedia')}}</option>
                        <option class="text-sm" value="Email" >{{__('auth.email_label')}}</option>
                        <option class="text-sm" value="Advertisement" >{{__('auth.advertisement')}}</option>
                        <option class="text-sm" value="Others" >{{__('auth.others')}}</option>


                        </select>

                </div>

                 <input wire:ignore type="hidden" name="timezone" id="timezone">
                <div class="container p-4 mx-0 min-w-full flex flex-col items-center">
                    <button  type="submit "  class=" text-center 2xl:w-full xl:w-full lg:w-full md:w-full items-center px-4 py-2 bg-secondary border border-transparent
                        rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-secondary_1 active:bg-secondary_1 focus:outline-none
                    focus:border-secondary_1 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ">
                            {{ __('auth.register') }}
                    </button>
                    <div class="mt-5 pt-2 w-full flex justify-center border-t border-gray-400">
                        <span class="" >{{ __('auth.alreadyregister') }} <a class="text-link" href="{{ route('login') }}">{{ __('auth.login') }}</a></span>
                    </div>
                </div>

            </div>
        </form>
</div>
@push('scripts')

<script>
    // function validatePasswordMatch() {
    //   var password = document.getElementById('password').value;
    //   var confirm_password = document.getElementById('password_confirmation');

    //   if (password === confirm_password.value) {
    //     confirm_password.setCustomValidity('');
    //   } else {
    //     confirm_password.setCustomValidity("Passwords don't match");
    //   }
    // }
    function validatePasswordMatch()
     {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('password_confirmation').value;
            if (password !== confirmPassword) {
                document.getElementById('password_confirmation').setCustomValidity("Passwords do not match");
            } else {
                document.getElementById('password_confirmation').setCustomValidity("");
            }
    }
    function CheckPassword(password) {
    // Check if password length is at least 8 characters
    if (password.length < 8) {
        return false;
    }

    // Check if password contains at least one lowercase letter
    if (!/[a-z]/.test(password)) {
        return false;
    }
    if (!/[A-Z]/.test(password)) {
        return false;
    }

    // Check if password contains at least one digit
    if (!/\d/.test(password)) {
        return false;
    }

    // Check if password contains at least one special character
    if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
        return false;
    }

    // Password meets all criteria
    return true;
}

    function validatePasswordStrength() {
            var password = document.getElementById('password').value;
            var result = CheckPassword(password);

            // Display the password strength
            var strengthText = '';

            result==false?
                    strengthText = `
                    <span class="mx-2 mt-2 mb-[2px] flex font-medium text-sm text-gray-700  lg:w-30 xl:w-30 text-red-600 " style="white-space:nowrap;margin:6px;">
                                        <svg class="flex w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>Week</span>`

                   :


                    strengthText = `
                    <span class="mx-2 mt-2 mb-[2px] flex font-medium text-sm text-gray-700  lg:w-30 xl:w-30 text-green-600 " style="white-space:nowrap;margin:6px;">
                                        <svg class="flex w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                                        </svg>Strong</span>`;


            document.getElementById('passwordStrength').innerHTML =  strengthText;
        }
</script>
<script>
    function togglePasswordVisibility(Id,PassIconId) {
      var passwordInput = document.getElementById(Id);
      var icon=document.getElementById(PassIconId);

      if (passwordInput.type == 'password') {
          passwordInput.type = 'text';  // Show password
          icon.innerHTML=`
              <g id="SVGRepo_bgCarrier" stroke-width="0"/>

              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

              <g id="SVGRepo_iconCarrier"> <g opacity="0.5">
              <path d="M14 2.75C15.9068 2.75 17.2615 2.75159 18.2892 2.88976C19.2952 3.02503 19.8749 3.27869 20.2981 3.7019C20.7852 4.18904 20.9973 4.56666 21.1147
              5.23984C21.2471 5.9986 21.25 7.08092 21.25 9C21.25 9.41422 21.5858 9.75 22 9.75C22.4142 9.75 22.75 9.41422 22.75 9L22.75 8.90369C22.7501 7.1045
              22.7501 5.88571 22.5924 4.98199C22.417 3.97665 22.0432 3.32568 21.3588 2.64124C20.6104 1.89288 19.6615 1.56076 18.489 1.40314C17.3498 1.24997
              15.8942 1.24998 14.0564 1.25H14C13.5858 1.25 13.25 1.58579 13.25 2C13.25 2.41421 13.5858 2.75 14 2.75Z" fill="#1C274C"/>
              <path d="M2.00001 14.25C2.41422 14.25 2.75001 14.5858 2.75001 15C2.75001 16.9191 2.75289 18.0014 2.88529
              18.7602C3.00275 19.4333 3.21477 19.811 3.70191 20.2981C4.12512 20.7213 4.70476 20.975 5.71085 21.1102C6.73852 21.2484 8.09318 21.25 10 21.25C10.4142
                  21.25 10.75 21.5858 10.75 22C10.75 22.4142 10.4142 22.75 10 22.75H9.94359C8.10583 22.75 6.6502 22.75 5.51098 22.5969C4.33856 22.4392 3.38961 22.1071
                  2.64125 21.3588C1.95681 20.6743 1.58304 20.0233 1.40762 19.018C1.24992 18.1143 1.24995 16.8955 1.25 15.0964L1.25001 15C1.25001 14.5858 1.58579 14.25
                  2.00001 14.25Z" fill="#1C274C"/> <path d="M22 14.25C22.4142 14.25 22.75 14.5858 22.75 15L22.75 15.0963C22.7501 16.8955 22.7501 18.1143 22.5924
                  19.018C22.417 20.0233 22.0432 20.6743 21.3588 21.3588C20.6104 22.1071 19.6615 22.4392 18.489 22.5969C17.3498 22.75 15.8942 22.75 14.0564
                  22.75H14C13.5858 22.75 13.25 22.4142 13.25 22C13.25 21.5858 13.5858 21.25 14 21.25C15.9068 21.25 17.2615 21.2484 18.2892 21.1102C19.2952 20.975 19.8749
                  20.7213 20.2981 20.2981C20.7852 19.811 20.9973 19.4333 21.1147 18.7602C21.2471 18.0014 21.25 16.9191 21.25 15C21.25 14.5858 21.5858 14.25 22 14.25Z"
                  fill="#1C274C"/>
                  <path d="M9.94359 1.25H10C10.4142 1.25 10.75 1.58579 10.75 2C10.75 2.41421 10.4142 2.75 10 2.75C8.09319 2.75 6.73852 2.75159 5.71085 2.88976C4.70476
                  3.02503 4.12512 3.27869 3.70191 3.7019C3.21477 4.18904 3.00275 4.56666 2.88529 5.23984C2.75289 5.9986 2.75001 7.08092 2.75001 9C2.75001 9.41422
                  2.41422 9.75 2.00001 9.75C1.58579 9.75 1.25001 9.41422 1.25001 9L1.25 8.90369C1.24995 7.10453 1.24992 5.8857 1.40762 4.98199C1.58304 3.97665 1.95681
                  3.32568 2.64125 2.64124C3.38961 1.89288 4.33856 1.56076 5.51098 1.40314C6.65019 1.24997 8.10584 1.24998 9.94359 1.25Z" fill="#1C274C"/> </g>
                  <path d="M12 10.75C11.3096 10.75 10.75 11.3096 10.75 12C10.75 12.6904 11.3096 13.25 12 13.25C12.6904 13.25 13.25 12.6904 13.25 12C13.25 11.3096
                  12.6904 10.75 12 10.75Z" fill="#1C274C"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.89243 14.0598C5.29747 13.3697 5 13.0246 5 12C5 10.9754
                  5.29748 10.6303 5.89242 9.94021C7.08037 8.56222 9.07268 7 12 7C14.9273 7 16.9196 8.56222 18.1076 9.94021C18.7025 10.6303 19 10.9754 19 12C19 13.0246
                  18.7025 13.3697 18.1076 14.0598C16.9196 15.4378 14.9273 17 12 17C9.07268 17 7.08038 15.4378 5.89243 14.0598ZM9.25 12C9.25 10.4812 10.4812 9.25 12
                  9.25C13.5188 9.25 14.75 10.4812 14.75 12C14.75 13.5188 13.5188 14.75 12 14.75C10.4812 14.75 9.25 13.5188 9.25 12Z" fill="#1C274C"/> </g>
              `;
      } else {
          passwordInput.type = 'password';  // Hide password
          icon.innerHTML=`
          <g id="SVGRepo_bgCarrier" stroke-width="0"/>

          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

          <g id="SVGRepo_iconCarrier">
              <path opacity="0.5" d="M10 22C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 18.7712 2 15" stroke="#1C274C" stroke-width="1.5"
              stroke-linecap="round"/> <path opacity="0.5" d="M22 15C22 18.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22"
              stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/> <path opacity="0.5"
              d="M14 2C17.7712 2 19.6569 2 20.8284 3.17157C22 4.34315 22 5.22876 22 9"
              stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
              <path opacity="0.5" d="M10 2C6.22876 2 4.34315 2 3.17157 3.17157C2 4.34315 2 5.22876 2 9" stroke="#1C274C" stroke-width="1.5"
              stroke-linecap="round"/>
              <path d="M5.89243 14.0598C5.29748 13.3697 5 13.0246 5 12C5 10.9754 5.29747 10.6303 5.89242 9.94021C7.08037 8.56222 9.07268 7
              12 7C14.9273 7 16.9196 8.56222 18.1076 9.94021C18.7025 10.6303 19 10.9754 19 12C19 13.0246 18.7025 13.3697 18.1076 14.0598C16.9196
              15.4378 14.9273 17 12 17C9.07268 17 7.08038 15.4378 5.89243 14.0598Z" stroke="#1C274C" stroke-width="1.5"/>
              <circle cx="12" cy="12" r="2" stroke="#1C274C" stroke-width="1.5"/>
          </g>`;
      }
     }

    //  detect timezone for user
    document.addEventListener('livewire:load', function () {


        // Get user timezone and emit the event
        const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
         document.getElementById('timezone').value=userTimezone;
         console.log(document.getElementById('timezone'));
    });
</script>
@endpush
