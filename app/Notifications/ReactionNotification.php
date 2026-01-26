<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReactionNotification extends Notification
{
    use Queueable;

    public $content;
    public $sender_user;
    public $reaction_type;

    /**
     * Create a new notification instance.
     */
    public function __construct($content, $sender_user, $reaction_type)
    {
        $this->content = $content;
        $this->sender_user = $sender_user;
        $this->reaction_type = $reaction_type;
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
        $voteText = ($this->reaction_type == 'up') ? 'upvote' : 'downvote';

        return [
            'type'=>'reaction',
            'reaction_type'=> $this->reaction_type,
            'title'=>'Your content with title "' . $this->content->title . '" get '. $voteText .' by ' . $this->sender_user->username . '.',
            'content_title'=>$this->content->title,
            'content_type'=>$this->content->getMorphClass(),
            'content_id'=>$this->content->id,
        ];
    }
}
