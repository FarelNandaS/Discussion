<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class GetSuspend extends Notification
{
    use Queueable;

    public $type;
    public $content;
    public $suspend_until;
    public $message;
    /**
     * Create a new notification instance.
     */
    public function __construct($type, $content, $suspend_until = null, $message = '')
    {
        $this->type = $type;
        $this->content = $content;
        $this->suspend_until = $suspend_until;
        $this->message = $message;
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
        $isAuto = $this->type == 'auto';

        $message = $this->content->getMorphClass() == Post::class ? (
            $isAuto
            ? "Account Suspension Notice. Hello, we'd like to inform you that your account has been suspended due to your post titled \"" . Str::limit($this->content->title ?? $this->content->content, 50) . "\" receiving numerous reports. Your account suspension began on " . now()->format('d M Y, H:i') . " and will end on " . now()->addDays(7)->format('d M Y, H:i') . ". Please wait for an admin to review the report. If the report is inaccurate, your post will be restored and your account will be reactivated."
            : "Account Suspension Notice. Hello, we'd like to inform you that your account has been suspended because the admin confirmed that your post titled \"" . Str::limit($this->content->title ?? $this->content->content, 50) . "\" contains content violations and admin give a massage \"" . $this->message . "\". Your account suspension began on " . now()->format('d M Y, H:i') . " and will end on " . Carbon::parse($this->suspend_until)->format('d M Y, H:i') . ". If you feel the accusations are untrue, you can appeal by clicking the button below."
        ) : (
            $isAuto
            ? "Account Suspension Notice. Hello, we'd like to inform you that your account has been suspended due to your comment \"" . Str::limit($this->content->title ?? $this->content->content, 50) . "\" receiving numerous reports. Your account suspension began on " . now()->format('d M Y, H:i') . " and will end on " . now()->addDays(7)->format('d M Y, H:i') . ". Please wait for an admin to review the report. If the report is inaccurate, your post will be restored and your account will be reactivated."
            : "Account Suspension Notice. Hello, we'd like to inform you that your account has been suspended because the admin confirmed that your comment \"" . Str::limit($this->content->title ?? $this->content->content, 50) . "\" contains content violations and admin give a massage \"" . $this->message . "\". Your account suspension began on " . now()->format('d M Y, H:i') . " and will end on " . Carbon::parse($this->suspend_until)->format('d M Y, H:i') . ". If you feel the accusations are untrue, you can appeal by clicking the button below."
        );

        return [
            'type' => 'information',
            'title' => 'You get suspend because this post "' . Str::limit($this->content->title ?? $this->content->content, 50) . '"',
            'message' => $message,
            'content_id' => $this->content->id,
            'content_type' => $this->content->getMorphClass(),
            'isAppealable' => $isAuto ? false : true,
        ];
    }
}
