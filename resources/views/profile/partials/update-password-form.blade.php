<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 ">
            {{ __('main.profilepassword') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 ">
            {{ __('main.profilepassword_title') }}
        </p>
    </header>
    <div id="ShowButton" class=""><button  onclick="showform()" class="mt-2 inline-flex items-center px-4 py-2 bg-secondary  border border-transparent
        rounded-md font-semibold text-xs text-white  uppercase tracking-widest hover:bg-secondary_1  focus:bg-secondary_1
          active:bg-gray-900  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
          transition ease-in-out duration-150">{{ __('main.changepassword') }}</button></div>
    <form id="form"  method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6 hidden">
        @csrf


        <div>
            <x-input-label for="current_password" :value="__('main.currentpassword')" />
            <div class="relative">
                <x-text-input  maxlength="30" id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                <div   class="absolute  top-2 right-0 pr-3 flex items-center text-sm leading-5">
                    <svg id="passIcon_current_password" onclick="togglePasswordVisibility('current_password','passIcon_current_password')" class="h-6 w-8 text-gray-700 " fill="none"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">

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
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('main.newpassword')" />
            <div class="relative">
                <x-text-input maxlength="30" oninput="validatePasswordMatch()" pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$"
                title="Password must be strong" id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                <div   class="absolute  top-2 right-0 pr-3 flex items-center text-sm leading-5">
                    <svg id="passIcon_password" onclick="togglePasswordVisibility('password','passIcon_password')" class="h-6 w-8 text-gray-700 " fill="none"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">

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
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('main.confirmpassword')" />
            <div class="relative">
            <x-text-input maxlength="30" oninput="validatePasswordMatch()" id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <div   class="absolute  top-2 right-0 pr-3 flex items-center text-sm leading-5">
                <svg id="passIcon_password_confirmation" onclick="togglePasswordVisibility('password_confirmation','passIcon_password_confirmation')" class="h-6 w-8 text-gray-700 " fill="none"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">

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
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('main.save') }}</x-primary-button>

            <x-secondary-button onclick="showform()">
                {{ __('main.cancel') }}
            </x-secondary-button>
            {{-- <button type="button" onclick="showform()" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2  transition ease-in-out duration-150">{{ __('Cancel') }}</button> --}}

        </div>
    </form>
    @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-green-600 "
                >{{ __('main.passwordsavedsuccessfully') }}</p>
    @endif
</section>
@push('scripts')
<script>
    // show passowrd function
    function showform(){
        var form =document.getElementById('form');
        var showbutton =document.getElementById('ShowButton');
        //if hidden
        form.classList.toggle('hidden');
        showbutton.classList.toggle('hidden');

    }
    function validatePasswordMatch() {
      var password = document.getElementById('password').value;
      var confirm_password = document.getElementById('password_confirmation');

      if (password === confirm_password.value) {
        confirm_password.setCustomValidity('');
      } else {
        confirm_password.setCustomValidity("Passwords don't match");
      }
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
</script>
@endpush
