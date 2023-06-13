<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelMail extends Mailable
{
    use Queueable, SerializesModels;
    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->subject('Cancellation of UK VI TB Appointment Screening at St. Nicholas Hospital')
        ->view('mails.cancellation');
    }
}
