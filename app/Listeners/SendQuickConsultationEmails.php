<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\QuickConsultationClientMail;
use App\Mail\QuickConsultationConsultantMail;

class SendQuickConsultationEmails
{
    public function handle($event)
    {
            \Illuminate\Support\Facades\Log::info('Listener SendQuickConsultationEmails تم استدعاؤه');

        $consultation = $event->consultation;

        try {
            // 📩 للعميل
            Mail::to($consultation->client_email)
                ->send(new QuickConsultationClientMail($consultation));

            Log::info("تم إرسال إيميل الاستشارة للعميل: {$consultation->client_email}");

            

        } catch (\Exception $e) {
            Log::error("فشل إرسال إيميل للعميل ({$consultation->client_email}): " . $e->getMessage());
        }

        try {
            // 📩 للمستشار إذا البريد موجود
            if ($consultation->consultant->user->email) {
                Mail::to($consultation->consultant->user->email)
                    ->send(new QuickConsultationConsultantMail($consultation));

                Log::info("تم إرسال إيميل الاستشارة للمستشار: {$consultation->consultant->user->email}");
            }
        } catch (\Exception $e) {
            Log::error("فشل إرسال إيميل للمستشار ({$consultation->consultant->user->email}): " . $e->getMessage());
        }
    }
}