<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Package;

class PackageDelivered extends Mailable
{
    use Queueable, SerializesModels;
    public $product;

    /**
     * Create a new message instance.
     */
    public function __construct(Package $product)
    {
        $this->product = $product;
    }

    public function build()
    {
        return $this->markdown('emails.delivered')
                    ->subject('Your Package Has Been Delivered');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
