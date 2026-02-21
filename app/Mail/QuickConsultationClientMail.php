<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuickConsultationClientMail extends Mailable
{
    use SerializesModels;

    public $consultation;

    public function __construct($consultation)
    {
        $this->consultation = $consultation;
    }

    public function build()
    {
        return $this->subject('تم استلام استشارتك')
            ->view('emails.quick_consultation_client');
    }
}