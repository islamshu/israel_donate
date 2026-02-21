<?php
namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use App\Mail\QuickConsultationClientMail;
use App\Mail\QuickConsultationConsultantMail;

class SendQuickConsultationEmails
{
    public function handle($event)
    {
        $consultation = $event->consultation;

        // 📩 للعميل مباشرة
        Mail::to($consultation->client_email)
            ->send(new QuickConsultationClientMail($consultation));

        // 📩 للمستشار مباشرة إذا البريد موجود
        if ($consultation->consultant?->email) {
            Mail::to($consultation->consultant->email)
                ->send(new QuickConsultationConsultantMail($consultation));
        }
    }
}