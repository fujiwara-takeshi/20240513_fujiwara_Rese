<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $qr_code = QrCode::format('png')->size(200)->generate(route('reservation.show', ['reservation_id' => $this->reservation->id]));

        return $this->subject('飲食店予約サービスReseより予約当日のお知らせ')
                    ->view('mail.reminder')
                    ->with(['reservation' => $this->reservation, 'qr_code' => $qr_code]);
    }
}
