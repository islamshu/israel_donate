<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuickConsultationClientMail;
use App\Mail\QuickConsultationConsultantMail;

class SendQuickConsultationEmails implements ShouldQueue
{
    public function handle($event)
    {
        $consultation = $event->consultation;

        // 📩 للعميل
        Mail::to($consultation->client_email)
            ->queue(new QuickConsultationClientMail($consultation));

        // 📩 للمستشار
        if ($consultation->consultant?->email) {
            Mail::to($consultation->consultant->email)
                ->queue(new QuickConsultationConsultantMail($consultation));
        }
    }
}