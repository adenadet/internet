<?php

namespace App\Mail\Certificate;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use PDF;

class NormalMail extends Mailable
{
    use Queueable, SerializesModels;
    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        $pdf = \PDF::loadView('certificates.horizontal', $this->appointment->toArray());

        return $this->subject('UK TB Screening Certificate from St. Nicholas Hospital')
        ->view('mails.certificates.horizontal')
        ->attachData($pdf->output(), "Certificate for UK TB Screening for ".$this->appointment->patient->first_name." ".$this->appointment->patient->last_name);
    }
}
