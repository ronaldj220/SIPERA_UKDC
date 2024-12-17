<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DocumentSubmissionNotification extends Notification
{
    use Queueable;
    
    protected $recruitment;

    /**
     * Create a new notification instance.
     */
    public function __construct($recruitment)
    {
        $this->recruitment = $recruitment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Pelamar baru telah mengajukan dokumennya. Mohon periksa dokumennya',
            'recruitment_id' => $this->recruitment->id,
        ];
    }
}
