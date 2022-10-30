<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminApproval extends Mailable
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

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'kb@kevinlwilson.co.uk';
        $subject = 'Admin Approval needed';
        $name = 'Admin';

        return $this->view('emails.approvaladmin'
        )
                    ->from($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with($this->data);
    }
}
