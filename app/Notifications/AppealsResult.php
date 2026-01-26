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
    public $content;
    public $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct($appeal, $status, $content, $reason)
    {
        $this->appeal = $appeal;
        $this->status = $status;
        $this->content = $content;
        $this->reason = $reason;
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $isValid = $this->status == 'approved';
        
        return [
            'type'=>'information',
            'title'=>$isValid ? 'Your appeal is approved' : 'Your appeal is rejected',
            'message'=>$isValid ? 'Hello, we would like to inform you that the appeal you submitted regarding your post titled "'. $this->content->title .'" has been thoroughly reviewed by our moderation team. After re-evaluating the content and your account history, we have decided to approve your appeal. Our admin provided the following note regarding this decision: '. $this->reason .'. As a result of this approval, your content has been restored and any restrictions previously applied to your account have been lifted or adjusted accordingly. Your trust score has also been updated to reflect this restoration. We appreciate your patience during the review process and encourage you to continue following our community guidelines to maintain a positive environment for all users. Thank you for your cooperation.' : 'We are writing to inform you that we have completed a detailed review of the appeal you submitted regarding your post titled "'. $this->content->title .'". After carefully considering our community policies and the evidence associated with the initial report, we regret to inform you that your appeal has been denied. This decision was made based on the following admin evaluation: '. $this->reason .'. Consequently, the current status of your content and any existing account restrictions will remain in effect according to our enforcement procedures. We understand this may not be the news you were hoping for, but this decision is final to ensure the safety and quality of our community environment. We recommend that you review our terms of service and guidelines to avoid similar issues in the future.',
            'appeal_id'=>$this->appeal->id,
            'content_id'=>$this->content->id,
            'content_type'=>$this->content->getMorphClass(),
            'isAppealable'=>false,
        ];
    }
}
