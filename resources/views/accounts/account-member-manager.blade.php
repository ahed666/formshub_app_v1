<div class="mb-12" >
    @if (Gate::check('addAccountMember', $account))
        <x-jet-section-border />
        <div x-data="{ showForm: false }" class="rounded-lg bg-white mt-5 drop-shadow  grid p-4">

            <h1 class="text-lg">  {{ __('main.addaccountmember') }}</h1>
            <h1 class="mt-2 text-sm">  {{ __('main.addnewaccount_title') }}</h1>
            <x-jet-action-message class="mr-3 ml-3 text-green-600" on="saved">
                {{ __('main.invitationsuccessfullysent') }}
            </x-jet-action-message>
           <!-- Add account Member -->
           <div  id="ShowButton" class=""><button  @click="showForm = !showForm" x-bind:class="{ 'hidden': showForm }" class="mt-2 inline-flex items-center px-4 py-2 bg-secondary  border border-transparent
            rounded-md font-semibold text-xs text-white  uppercase tracking-widest hover:bg-secondary_1  focus:bg-secondary_1
              active:bg-gray-900  focus:outline-none
              transition ease-in-out duration-150">{{ __('main.addpeople') }}</button></div>

            <div id="form" class="mt-2 sm:mt-0 " x-bind:class="{ 'hidden': !showForm }">

                <x-jet-form-section submit="addAccountMember">
                    <x-slot name="title">

                    </x-slot>

                    <x-slot name="description">

                    </x-slot>

                    {{-- @if(Gate::check('checkAddValidPlan',$account)==false)
                        <x-slot name="form">
                            <div class="flex col-span-6 justify-center text-center text-red-400">{{ __('This feature is not available on the Free plan, please upgrade your plan to add an account member.') }}</div>
                        </x-slot> --}}
                    @if(!Gate::check('checkAddValidDate',$account))
                        <x-slot name="form">
                            <div class="flex col-span-6 justify-center text-center text-red-400">{{ Gate::check('checkAddValid',$account) }}{{ __('Your subscription has expired, please renew your plan to use this feature.') }}</div>
                        </x-slot>

                    @elseif(!Gate::check('checkMaxInvitations',$account))
                    <x-slot name="form">
                        <div class="flex col-span-6 justify-center text-center text-red-400">{{ __('main.reachmaxaccountadded') }}</div>
                    </x-slot>
                    @else

                        <x-slot name="form">
                            <div class="col-span-6">
                                <div class="max-w-xl text-sm text-gray-600">
                                    {{ __('main.provideemailperson') }}
                                </div>
                            </div>

                            <!-- Member Email -->
                            <div class="col-span-6 sm:col-span-4">
                                <x-jet-label for="email" value="{{ __('main.email') }}" />
                                <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="addAccountMemberForm.email" />
                                <x-jet-input-error for="email" class="mt-2" />
                            </div>

                            <!-- Role -->
                            @if (count($this->roles) > 0)
                                <div class="col-span-6 lg:col-span-4">
                                    <x-jet-label for="role" value="{{ __('main.role') }}" />
                                    <x-jet-input-error for="role" class="mt-2" />

                                    <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                                        @foreach ($this->roles as $index => $role)
                                            <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                                            wire:click="$set('addAccountMemberForm.role', '{{ $role->key }}')">
                                                <div class="{{ isset($addAccountMemberForm['role']) && $addAccountMemberForm['role'] !== $role->key ? 'opacity-50' : '' }}">
                                                    <!-- Role Name -->
                                                    <div class="flex items-center">
                                                        <div class="text-sm text-gray-600 {{ $addAccountMemberForm['role'] == $role->key ? 'font-semibold' : '' }}">
                                                            {{ $role->name }}
                                                        </div>

                                                        @if ($addAccountMemberForm['role'] == $role->key)
                                                            <svg class="ml-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        @endif
                                                    </div>

                                                    <!-- Role Description -->
                                                    <div class="mt-2 text-xs text-gray-600 text-left">
                                                        {{ $role->description }}
                                                    </div>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </x-slot>

                        <x-slot name="actions">


                            <x-jet-button>
                                {{ __('main.add') }}
                            </x-jet-button>
                            <x-secondary-button class="ml-2" @click="showForm = !showForm">
                                {{ __('main.cancel') }}
                            </x-secondary-button>
                            {{-- <button type="button" @click="showForm = !showForm" class="ml-4 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2  transition ease-in-out duration-150">{{ __('Cancel') }}</button> --}}

                        </x-slot>
                    @endif
                </x-jet-form-section>
            </div>
        </div>
    @endif


    @if ($account->accountInvitations->isNotEmpty() && Gate::check('addAccountMember', $account))
        <x-jet-section-border />

        <!-- account Member Invitations -->
        <div class="mt-0 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Pending Account Invitations') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('main.peopleinvitation_desc') }}
                </x-slot>

                <x-slot name="content" class="mt-2">
                    <div class="space-y-6 p-4">
                        @foreach ($account->accountInvitations as $invitation)
                            <div class="flex items-center justify-between">
                                <div class="text-gray-600">{{ $invitation->email }}</div>

                                <div class="flex items-center">
                                    @if (Gate::check('removeAccountMember', $account))
                                        <!-- Cancel Account Invitation -->
                                        <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                            wire:click="cancelAccountInvitation({{ $invitation->id }})">
                                            {{ __('Cancel') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>
    @endif

    @if ($account->users->isNotEmpty())
        <x-jet-section-border />

        <!-- Manage Account Members -->
        <div class="mt-0 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('main.accountmembers') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('main.accountmembers_title') }}
                </x-slot>

                <!-- Account Member List -->
                <x-slot name="content">
                    <div class="space-y-6 p-4">
                        @foreach ($account->users->sortBy('name') as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                    <div class="ml-4">{{ $user->name }}</div>
                                </div>

                                <div class="flex items-center">
                                    <!-- Manage Account Member Role -->
                                    @if (Gate::check('addAccountMember', $account) && Laravel\Jetstream\Jetstream::hasRoles())
                                        <button class="ml-2 text-sm text-gray-400 underline" wire:click="manageRole('{{ $user->id }}')">
                                            {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                        </button>
                                    @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                                        <div class="ml-2 text-sm text-gray-400">
                                            {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                        </div>
                                    @endif

                                    <!-- Leave Account -->
                                    @if ($this->user->id === $user->id)
                                        <button class="cursor-pointer ml-6 text-sm text-red-500" wire:click="$toggle('confirmingLeavingAccount')">
                                            {{ __('main.leave') }}
                                        </button>

                                    <!-- Remove Account Member -->
                                    @elseif (Gate::check('removeAccountMember', $account))
                                        <button class="cursor-pointer ml-6 text-sm text-red-500" wire:click="confirmAccountMemberRemoval('{{ $user->id }}')">
                                            {{ __('main.remove') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>
    @endif

    <!-- Role Management Modal -->
    <x-jet-dialog-modal wire:model="currentlyManagingRole">
        <x-slot name="title">
            {{ __('main.managerole') }}
        </x-slot>

        <x-slot name="content">
            <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                @foreach ($this->roles as $index => $role)
                    <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                    wire:click="$set('currentRole', '{{ $role->key }}')">
                        <div class="{{ $currentRole !== $role->key ? 'opacity-50' : '' }}">
                            <!-- Role Name -->
                            <div class="flex items-center">
                                <div class="text-sm text-gray-600 {{ $currentRole == $role->key ? 'font-semibold' : '' }}">
                                    {{ $role->name }}
                                </div>

                                @if ($currentRole == $role->key)
                                    <svg class="ml-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>

                            <!-- Role Description -->
                            <div class="mt-2 text-xs text-gray-600">
                                {{ $role->description }}
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="stopManagingRole" wire:loading.attr="disabled">
                {{ __('main.cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="updateRole" wire:loading.attr="disabled">
                {{ __('main.save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Leave Account Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingLeavingAccount">
        <x-slot name="title">
            {{ __('main.leaveaccount_title') }}
        </x-slot>

        <x-slot name="content">
            {{ __('main.leaveaccountmessage') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingLeavingAccount')" wire:loading.attr="disabled">
                {{ __('main.cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="leaveAccount" wire:loading.attr="disabled">
                {{ __('main.leave') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>



    <!-- Remove Account Member Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingAccountMemberRemoval">
        <x-slot name="title">
            {{ __('main.removeaccountmember_title') }}
        </x-slot>

        <x-slot name="content">
            {{ __('main.removememberaccountalaram') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingAccountMemberRemoval')" wire:loading.attr="disabled">
                {{ __('main.cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="removeAccountMember" wire:loading.attr="disabled">
                {{ __('main.remove') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

</div>

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
    </script>
@endpush
