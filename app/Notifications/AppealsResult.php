<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppealsResult extends Notification
{
    use Queueable;

    public $appeal;
    public $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($appeal, $status)
    {
        $this->appeal = $appeal;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $isValid = $this->status == 'Approved';
        
        return [
            'title'=>$isValid ? 'Your appeal is approved' : 'Your appeal is rejected',
            'message'=>$isValid ? 'Good news, your appeal has been approved by the admin.' : 'We apologize, but your appeal has not been approved by the admin.',
            'appeal_id'=>$this->appeal->id,
        ];
    }
}
