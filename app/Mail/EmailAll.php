<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailAll extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    public function build()
    {
        $address = 'kb@kevinlwilson.co.uk';
        $subject = 'Something new has been added';
        $name = 'Admin';

        return $this->view('emails.emailall'
        )
                    ->from($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with($this->data);
    }
}
