<?php

namespace App\Notifications;

use App\Models\UserProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostsNotifications extends Notification
{
    use Queueable;

    protected $user_profile;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(UserProfile $user_profile, string $message)
    {
        $this->user_profile = $user_profile;
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
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
            'sender_name' => $this->user_profile->name,
            'sender_image' => $this->user_profile->avatar_URL,
            'message' => __($this->message)
        ];
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
