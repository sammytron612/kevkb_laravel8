<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class NewArticle extends Notification implements ShouldQueue
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

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->channel;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('A message from KB')
                    ->greeting('Hello!')
                    ->line('A new article has been added by ' . $this->data['user'])
                    ->line('Article "'  . $this->data['title'] . '" has been added to section ' . $this->data['section'])
                    ->action('Check it out here', url('/articles',$this->data['id']));

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [ 'user' => $this->data['user'],
                 'section' => $this->data['section'],
                 'title' => $this->data['title'],
                 'id' => $this->data['id']

        ];
    }
}
