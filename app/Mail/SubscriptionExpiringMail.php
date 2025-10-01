<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionExpiringMail extends Mailable
{
    use Queueable, SerializesModels;

public $user;
public $daysLeft;
public $renewUrl;


    /**
     * Create a new message instance.
     */
 public function __construct($user, $daysLeft, $subscription)
{
    $this->user = $user;
    $this->daysLeft = $daysLeft;
    $this->renewUrl = route('checkout.renew', ['id' => $subscription->plan_id, 'sub_id' => $subscription->id]);
}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Expiring Mail',
        );
    }

    /**
     * Get the message content definition.
     */
public function content(): Content
{
    return new Content(
        view: 'emails.subscription_expiring',
        with: [
            'user' => $this->user,
            'daysLeft' => $this->daysLeft,
        ],
    );
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
