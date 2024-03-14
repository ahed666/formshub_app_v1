<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
class FreePlanExpired extends Notification
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
                    ->subject('Free Subscription Expired')
                    ->line('Your Form Hub Free subscription is expired and due for upgrade !
                    To continue using your account without interruption, login to your account to upgrade your account or click the Button below.')
                    ->action('My Subscriptions', url('/subscriptions'))
                    ->line('Without an upgrade, accounts will be suspended after 30 days of expiry. read more about subscription terms.')
                    ->unsubscribeAction('Unsubscribe',$url)
                    ->line('Please do not reply to this message. Replies to this message are routed to an unmonitored mailbox.')
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
