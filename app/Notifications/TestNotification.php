<?php 

// app/Notifications/TestNotification.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database']; // Dual delivery
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('TEST Notification')
            ->line('This is a test notification')
            ->action('Test Action', url('/'))
            ->line('Thank you!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Test notification stored in database'
        ];
    }
}