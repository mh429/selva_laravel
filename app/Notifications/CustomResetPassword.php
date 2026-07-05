<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     * 通知を送信するチャンネルを指定
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     * メールの文面とデザインを構築
     */
    public function toMail(object $notifiable): MailMessage
    {
        // 遷移先URLの生成
        $url = url(route('passwordReset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // bladeテンプレートを直接指定（プレーンテキスト）
        return (new MailMessage)
            ->subject('パスワード再設定')
            ->text('emails.password_reset', [
                'url' => $url
            ]);
    }
}
