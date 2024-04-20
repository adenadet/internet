<?php

namespace App\Mail\Leave;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $leave_request;
    public $employee;
    public $line_manager;

    public function __construct($leave_request, $employee, $line_manager)
    {
        $this->leave_request = $leave_request;
        $this->employee = $employee;
        $this->line_manager = $line_manager;
    }


    public function build()
    {
        return $this->subject('New Team Member Leave Request')
        ->view('mails.leaves.request');
    }
}
