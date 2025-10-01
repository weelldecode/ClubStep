<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionDeactivatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Subscription $subscription;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Subscription $subscription)
    {
        $this->user = $user;
        $this->subscription = $subscription;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sua assinatura foi desativada',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription_deactivated',
            with: [
                'user' => $this->user,
                'subscription' => $this->subscription,
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