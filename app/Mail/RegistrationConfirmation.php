<?php

namespace App\Mail;

use Illuminate\Bus\Queueable; 
use Illuminate\Mail\Mailable; 
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $fullname;
    public $otp;
    public $membershipCardNumber;

    public function __construct($fullname, $otp, $membershipCardNumber)
    {
        $this->fullname = $fullname;
        $this->otp = $otp;
        $this->membershipCardNumber = $membershipCardNumber;
    }

    public function build()
    {
        return $this->view('emails.registration_confirmation')
                    ->subject('Registration Confirmation');
    }
}

