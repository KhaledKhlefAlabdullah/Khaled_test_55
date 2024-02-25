<?php

namespace App\Notifications;

use App\Mail\PortalMails;
use App\Models\UserProfile;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use function App\Helpers\send_mail;

class PortalNotifications extends Notification
{
    use Queueable;

    protected $user_profile;
    protected $message;
    protected $viaChannels;

    protected $receivers;


    /**
     * Create a new notification instance.
     */
    public function __construct(array $viaChannels = ['database'],$user_profile, string $message,$receivers)
    {
        $this->viaChannels = $viaChannels;
        $this->user_profile = $user_profile;
        $this->message = $message;
        $this->receivers = $receivers;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $this->viaChannels;
    }

    /**
     * Get the database representation of the notification.
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        try{
            // todo make the emails block and pass it without foreach

            $mails = $this->receivers->pluck('email')->toArray();

            $succes = send_mail($this->message,$mails);

            if($succes){
                return (new PortalMails('testing message'))->to($notifiable);
            }
        } 
        catch (Exception $e) {
            // Handle any exceptions that occur during mail sending
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('Could not send the email'),
            ], 500);
        }
    
        // If mail sending fails, return an appropriate response
        return response()->json([
            'error' => __('Could not send the email'),
        ], 500);
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
