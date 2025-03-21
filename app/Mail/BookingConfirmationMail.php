<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $flight;
    public $seat;
    public $price;

    public function __construct($user, $flight, $seat, $price)
    {
        $this->user = $user;
        $this->flight = $flight;
        $this->seat = $seat;
        $this->price = $price;
    }

    public function build()
    {
        return $this->subject('Xác nhận đặt vé thành công')
                    ->view('emails.booking_confirmation')
                    ->with([
                        'user' => $this->user,
                        'flight' => $this->flight,
                        'seat' => $this->seat,
                        'price' => $this->price,
                    ]);
    }
}
