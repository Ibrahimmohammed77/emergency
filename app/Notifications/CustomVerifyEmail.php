<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('تأكيد بريدك الإلكتروني')
            ->line('يرجى الضغط على الزر التالي لتأكيد بريدك الإلكتروني.')
            ->action('تأكيد البريد', $verificationUrl)
            ->line('إذا لم تقم بإنشاء حساب، فلا حاجة لاتخاذ أي إجراء.');
    }
}
