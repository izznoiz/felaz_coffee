<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use App\Services\SendGridService;
use App\Notifications\CustomEmailVerification;

class SendGridChannel
{
    protected $sendGridService;

    public function __construct(SendGridService $sendGridService)
    {
        $this->sendGridService = $sendGridService;
    }

    /**
     * Send the given notification.
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toSendGrid')) {
            return;
        }

        $data = $notification->toSendGrid($notifiable);
        
        return $this->sendGridService->sendEmail(
            $data['to'] ?? $notifiable->email,
            $data['subject'],
            $data['content'],
            $data['from'] ?? null,
            $data['fromName'] ?? null
        );
    }
}