<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RescheduleMail extends Mailable
{
    use Queueable, SerializesModels;
    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->subject('Re: Appointment confirmation from St. Nicholas Hospital')
        ->view('mails.reschedule');
    }
}
