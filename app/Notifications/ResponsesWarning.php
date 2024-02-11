<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResponsesWarning extends Notification
{
    use Queueable;
    private $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user=$user;
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
        $url=url('unsubscribe/payment_subscriptions/'.$this->user->unsubscribe_token.'/' . $this->user->id);
        return (new MailMessage)
                    ->subject('Available Responses Are Running Low')
                    ->line('Your Form Hub available responses are running low, you have got less than 100 responses remaining in your account.')
                    ->line('To continue receiving responses without interruption, log in to your account to upgrade or to get more responses.')
                    ->line('Or you can click the Button below:')
                    ->action(' My Subscriptions', url('/subscriptions'))
                    ->unsubscribeAction('Unsubscribe',$url)
                    ->line('Thank you for using our application!');
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
