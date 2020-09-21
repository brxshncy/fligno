<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
class InvoicePaid extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * 
     * @return void
     */
    public $purchase;
    public function __construct($purchase)
    {
        $this->purchase = $purchase;
    }

    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'product_id' => $this->purchase->product_id,
            'product_name' => $this->purchase->product_name,
            'customer_id' => $this->purchase->customer_id,
            'customer_name' => $this->purchase->customer_name,
            'quantity' => $this->purchase->quantity,
            'amount' => $this->purchase->amount,
        ];
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'product_id' => $this->purchase->product_id,
            'product_name' => $this->purchase->product_name,
            'customer_id' => $this->purchase->customer_id,
            'customer_name' => $this->purchase->customer_name,
            'quantity' => $this->purchase->quantity,
            'amount' => $this->purchase->amount,
        ]);
    }
}
