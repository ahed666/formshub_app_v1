<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 ">
            {{ __('main.deleteaccount') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 ">
            {{ __('main.deleteaccount_title') }}
        </p>
    </header>
    @php

        $kiosks = \App\Models\Kiosk::whereaccount_id(Auth::user()->current_account_id)->whereNotNull('form_id')->get();
   @endphp

    @if(count($kiosks)>0)
        <x-danger-button
        x-data=""
        onclick="showHaveKiosksAlaram()"
    >{{ __('main.deleteaccount_button') }}</x-danger-button>
    @else
        <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('main.deleteaccount_button') }}</x-danger-button>
    @endif


       {{-- delete account --}}
     {{-- inlinked alaram --}}
    <x-modal name="kiosks-unlinked-alarm" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf


            <h2 class="text-lg font-medium text-gray-900">
                {{ __('main.therelinkeddevices') }}
            </h2>

            {{-- <p class="mt-1 text-sm text-gray-600 ">
                {{ __('Once your profile is deleted, all of its resources and data will be permanently deleted, the account that you own will be also permanently deleted with all of its resources and data.
                 Please enter your password to confirm you would like to permanently delete your account.') }}
            </p> --}}



            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('main.cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('main.unlink') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('main.deleteprofilequestion') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 ">
                {{ __('main.deleteprofilealarm') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Password" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Password"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('main.cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('main.deleteaccount_button') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>

</section>
@push('scripts')
<script src="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>

<script>
         var translations = @json(__('main'));

function showHaveKiosksAlaram(){
    (async () => {
            const { value: confirmUnlink } = await Swal.fire({
                text: translations.havekiosksalaram,
                icon: 'question',
                showCancelButton: true,
                cancelButtonColor: '#f3f4f6',
                cancelButtonText: `<h5 style='color:000000;border:0;box-shadow: none;'>${translations.cancel}</h5>`,
                confirmButtonText: translations.unlink,
                confirmButtonColor: '#1277D1',
            });

            if (confirmUnlink) {
                const routeUrl = '{{ route('unlinkkiosks') }}';

                // Redirect to the route URL
                window.location.href = routeUrl;
            }
        })();
}
</script>
<script>
    var message = document.getElementById('message').value;

    if(message){
        if (message=="error")
        {
                Swal.fire({
                    icon: 'error',
                    title:message,
                    text:message,
                    confirmButtonColor:'#1277D1',
                })
        }
        else if(message=="success")
        {
            Swal.fire({
                        icon: 'success',
                        title:translations.unlinkedkioskssuccessfuly,
                        text:message,
                        confirmButtonColor:'#1277D1',
                })
        }
    }

</script>
@endpush
