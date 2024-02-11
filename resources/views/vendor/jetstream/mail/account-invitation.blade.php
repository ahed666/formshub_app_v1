@component('mail::message')
{{ __('You have been invited to join the :account  Form Hub account!', ['account' => $invitation->account->name]) }}





{{ __('If you already have an account, you may accept this invitation by clicking the button below:') }}


@component('mail::button', ['url' => $acceptUrl])
{{ __('Accept Invitation') }}
@endcomponent


@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
{{ __('If you do not have an account, you may create one by clicking the button below.
After creating an account, you may click the invitation acceptance button in this email to accept the account invitation:') }}

@component('mail::button', ['url' => route('register')])
{{ __('Create Account') }}
@endcomponent
@endif




{{ __('If you did not expect to receive an invitation to this account, you may discard this email.') }}
@endcomponent
