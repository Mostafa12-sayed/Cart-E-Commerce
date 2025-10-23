<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends Notification
{
    public string $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset your password')
            ->greeting('Hello!')
            ->line('You requested to reset your password.')
            ->action('Reset Password', $this->url)
            ->line('If you did not request this, please ignore this email.');
    }
}
