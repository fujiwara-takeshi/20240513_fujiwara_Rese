<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $subject;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $postarr)
    {
        $this->name = $postarr['name'];
        $this->subject = $postarr['subject'];
        $this->message = $postarr['message'];
    }

    public function attachments()
    {
        return [];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->text('mail.mailcontent')
                    ->with([
                        'to_name' => $this->name,
                        'body' => $this->message,
                    ]);
    }
}
