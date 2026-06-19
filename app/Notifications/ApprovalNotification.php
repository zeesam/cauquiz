<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovalNotification extends Notification
{
    use Queueable;
    private $notice;
    

    /**
     * Create a new notification instance.
     */
    public function __construct($notice)
    {
        $this->notice = $notice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Account Approved')
                    ->line('Welcome! '.$this->notice['name'])
                    ->line('Your account has been approved by Administrator. You may login.')
                    ->action('View Page', url('/'))
                    ->line('Do not reply to this email. This is a computer Generated Email.')
                    ->line('Thank you for using our Quiz application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
