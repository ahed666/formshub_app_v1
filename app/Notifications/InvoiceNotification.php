<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use \PDF;
use Dompdf\Dompdf;
use App\Models\Invoice;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
class InvoiceNotification extends Notification
{
    use Queueable;
    private $invoiceId;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoiceId)
    {
        //
        $this->invoiceId = $invoiceId;
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
        $invoice = Invoice::findOrFail($this->invoiceId);
        $account = Account::whereid(Auth::user()->current_account_id)->first();

        $html = view('pdf.invoice', compact('invoice', 'account'))->render();
        $pdf = PDF::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');

        // Generate the PDF file name
        $filename = 'FHINV-'.$invoice->invoice_no;

        // Get the generated PDF content as a string
        $pdfString = $pdf->output();
        $url=url('unsubscribe/payment_subscriptions/'.Auth::user()->unsubscribe_token.'/' . Auth::user()->id);
        return (new MailMessage)
                    ->subject('Payment Notification')
                    ->line('Thank you for your payment, invoice number: FHINV-'.$invoice->invoice_no)
                    ->line('Your order has been placed, and it will proceed right away.')
                    ->line('You can view and manage your account payment in the Payment & Billing under your account setting, or click the button below')
                    ->action('Payment & Billing', url('/payment_billing'))
                    ->unsubscribeAction('Unsubscribe',$url)
                    ->attachData($pdfString, $filename.'.pdf', ['mime' => 'application/pdf',])
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
