<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $data;
    public $channel;


    public function __construct($data,$channel)
    {
        $this->data = $data;
        $this->channel = $channel;
    }

    public function toMail($notifiable)
    {

        return (new MailMessage)
                    ->subject('A message from KB')
                    ->greeting('Hello!')
                    ->line(' A quick message from KB')
                    ->line($this->data['comment'])
                    ->line('Thank you for using the KB');
    }
    public function via($notifiable)
    {
        return $this->channel;
    }


    public function toArray($notifiable)
    {
        return [
            'title' => null,
            'comment' => $this->data['comment'],
            'author' => $this->data['commentor']
        ];
    }
}
