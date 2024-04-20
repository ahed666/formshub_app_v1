@component('mail::message')
# New Ticket Created

A new ticket has been created with ID: {{ $ticket->id }}

@component('mail::button', ['url' => url('/admin-center/supporttickets')])
View Ticket
@endcomponent

Thanks,<br>
Your Application
@endcomponent
