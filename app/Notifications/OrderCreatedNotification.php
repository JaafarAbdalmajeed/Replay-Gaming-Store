<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
        $channels = ['database'];
        if ($notifiable->notification_preferences['order_created']['sms'] ?? false) {
            $channels[] = 'vonage';
        }
        if ($notifiable->notification_preferences['order_created']['mail'] ?? false) {
            $channels[] = 'mail';
        }
        if ($notifiable->notification_preferences['order_created']['broadcast'] ?? false) {
            $channels[] = 'broadcast';
        }
        // return ['mail','database', 'broadcast'];
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $addr = $this->order->billingAddress;
        return (new MailMessage)
                    ->subject('New Order #' . $this->order->number)
                    ->from('notification@solutions.ps', 'Replay Gaming')
                    ->greeting("Hi{$notifiable->name}")
                    ->line("A new order (#{$this->order->number}) created by {$addr->name} from {$addr->country_name}.")
                    ->action('View Order', url('/dashboard'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        $addr = $this->order->billingAddress;
        return [
            'body' => "A new order (#{$this->order->number}) created by {$addr->name} from {$addr->country_name}.",
            'icon' => 'fas fa-file',
            'url' => url('/dashboard'),
            'order_id' => $this->order->id
        ];
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

    public function toBroadcast()
    {
        $addr = $this->order->billingAddress;

        return new BroadcastMessage([
            'body' => "A new order (#{$this->order->number}) created by {$addr->name} from {$addr->country_name}.",
            'icon' => 'fas fa-file',
            'url' => url('/dashboard'),
            'order_id' => $this->order->id
        ]);

    }
}
