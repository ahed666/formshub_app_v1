<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SupportTicket;

class NewTicket extends Notification
{
    use Queueable;
    private  $ticket;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $ticket)
    {
        $this->ticket=$ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
        return (new MailMessage)
                    ->from('support@formshub.net','Form Hub')
                    ->subject("Support Ticket FHT-{$this->ticket->id}")
                    ->line("A support ticket ID FHT-{$this->ticket->id} has been created")
                    ->line('Our concern team will look into it and get back to you soon')
                    ->line('To track the status of your ticket, simply click on the link below')
                    ->action('Track Status', url('/support'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}