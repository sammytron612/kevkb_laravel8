<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailArticle extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $address = 'kb@kevinlwilson.co.uk';
        $subject = 'View article';
        $name = 'Admin';

        return $this->view('emails.article'
        )
                    ->from($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with($this->data);
    }
}
