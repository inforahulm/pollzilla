<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $type;

    public function __construct($user,$type=1)
    {
        $this->user = $user;
        $this->type = $type;
    }

    public function build()
    {
        $user = $this->user;
        if($this->type ==1) {

            return $this->view('mails.otp',compact('user'))->subject(config('app.name').' Verification');
        } else {
            return $this->view('mails.forgototp',compact('user'))->subject('Reset Password Code');

        }

    }
}
