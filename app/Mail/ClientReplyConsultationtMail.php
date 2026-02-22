<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientReplyConsultationtMail extends Mailable
{
    use SerializesModels;

    public $consultation;

    public function __construct($consultation)
    {
        $this->consultation = $consultation;
    }

    public function build()
    {
        return $this->subject('تم استلام رد جديد على استشارة سابقة ')
            ->view('emails.client_reply_consultation');
    }
}