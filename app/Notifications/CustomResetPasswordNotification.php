<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPasswordNotification extends Notification
{
  

    public $token;
    public $type;

    /**
     * Create a notification instance.
     */
    public function __construct($token, $type = 'user')
    {
        $this->token = $token;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        // بناء رابط إعادة التعيين باستخدام اسم المسار والمعاملات
        $resetUrl = route('password.reset', [
            'type' => $this->type,
            'token' => $this->token,
        ]);

        // إضافة البريد الإلكتروني كـ Query String
        $resetUrl .= '?email=' . urlencode($notifiable->getEmailForPasswordReset());

        return (new MailMessage)
            ->subject('إعادة تعيين كلمة المرور')
            ->line('لقد تلقيت هذا البريد الإلكتروني بسبب طلب إعادة تعيين كلمة المرور لحسابك.')
            ->action('إعادة تعيين كلمة المرور', $resetUrl)
            ->line('سينتهي صلاحية رابط إعادة التعيين بعد 60 دقيقة.')
            ->line('إذا لم تطلب إعادة التعيين، فلا حاجة لاتخاذ أي إجراء.');
    }
}
