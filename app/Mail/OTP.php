<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTP extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'kb@kevinlwilson.co.uk';
        $subject = 'One time password';
        $name = 'Admin';

        return $this->view('emails.otp'
        )
                    ->from($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with($this->data);
    }
}
