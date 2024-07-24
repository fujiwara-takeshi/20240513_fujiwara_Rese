<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class MailCreate extends Mailable
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
                    ->from('tfdxvjiyre75528@gmail', '飲食店予約サービスRese')
                    ->text('mail.mailcontent')
                    ->with([
                        'to_name' => $this->name,
                        'body' => $this->message,
                    ]);
    }
}
