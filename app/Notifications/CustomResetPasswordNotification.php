<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        $url = env('FRONTEND_URL') . '/reset-password?token=' . $this->token
             . '&email=' . urlencode($notifiable->email);

        return (new MailMessage)
            ->subject('Reset Password - ' . env('APP_NAME'))
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line('We received a request to reset your account password.')
            ->action('Reset Password', $url)
            ->line('This link will expire in 60 minutes.')
            ->line('If you did not request a password reset, please ignore this email.');
    }
}