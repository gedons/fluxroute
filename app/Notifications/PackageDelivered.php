<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PackageDelivered extends Notification
{
    use Queueable;

    public $product; // Add this property

    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Your package has been delivered.')
            ->line('Package Details:')
            ->line('Package Name: ' . $this->product->title)
            ->line('Package ID: ' . $this->product->tracking_number)
            ->line('Delivery Address: ' . $this->product->delivery_address)
            ->line('Special Instruction: ' . $this->product->special_instructions)
            ->line('Delivery Date: ' . now()->format('Y-m-d H:i:s'))           
            ->action('Track Package', url('http://localhost:5173/'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
