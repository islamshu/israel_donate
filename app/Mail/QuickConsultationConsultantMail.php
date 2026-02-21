<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuickConsultationConsultantMail extends Mailable
{
    use SerializesModels;

    public $consultation;

    public function __construct($consultation)
    {
        $this->consultation = $consultation;
    }

    public function build()
    {
        return $this->subject('استشارة جديدة بانتظارك')
            ->view('emails.quick_consultation_consultant');
    }
}