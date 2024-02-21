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


    protected $user;
    protected $message;
    protected $priority;
    // todo to continue later


    /**
     * Create a new notification instance.
     */
    public function __construct(UserProfile $user, string $message, string $priority)
    {
        $this->$user = $user;
        $this->$message = $message;
        $this->$priority = $priority;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['datadase'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [

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
