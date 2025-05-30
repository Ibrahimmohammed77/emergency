<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;
    public $type;  // Add type for proper URL generation

    public function __construct($token, $type = 'user')
    {
        $this->token = $token;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = url(config('app.url').route('password.reset', [
            'type' => $this->type,
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('إعادة تعيين كلمة المرور')
            ->line('لقد تلقيت هذا البريد الإلكتروني بسبب طلب إعادة تعيين كلمة المرور لحسابك.')
            ->action('إعادة تعيين كلمة المرور', $resetUrl)
            ->line('سينتهي صلاحية رابط إعادة التعيين بعد 60 دقيقة.');
    }
}