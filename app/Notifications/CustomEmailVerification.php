<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Notification;
use App\Channels\SendGridChannel;

class CustomEmailVerification extends BaseVerifyEmail
{
    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return [SendGridChannel::class];
    }

    /**
     * Get the SendGrid representation of the notification.
     */
    public function toSendGrid($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        
        return [
            'to' => $notifiable->email,
            'subject' => 'Verify Your Email Address',
            'content' => view('emails.verify-email', [
                'user' => $notifiable,
                'url' => $verificationUrl
            ])->render()
        ];
    }
}