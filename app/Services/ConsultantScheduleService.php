<?php

namespace App\Services;

use App\Models\Consultant;
use Carbon\Carbon;
use App\Models\Booking;

class ConsultantScheduleService
{

    public function getAvailableSlots(Consultant $consultant, string $date): array
    {
        $dateObj = Carbon::parse($date)->startOfDay();
        $today   = now()->startOfDay();
    
        // ❌ منع أي تاريخ ماضي
        if ($dateObj->lt($today)) {
            return [];
        }
    
        $dayOfWeek = $dateObj->dayOfWeek;
    
        $availability = $consultant->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->first();
    
        if (!$availability) {
            return [];
        }
    
        $start = Carbon::parse($date . ' ' . $availability->start_time);
        $end   = Carbon::parse($date . ' ' . $availability->end_time);
    
        $slotDuration = $availability->slot_duration;
    
        // الأوقات المحجوزة
        $bookedTimes = Booking::where('consultant_id', $consultant->id)
            ->where('date', $date)
            ->whereIn('status', ['pending', 'paid'])
            ->pluck('start_time')
            ->map(fn($t) => Carbon::parse($t)->format('H:i'))
            ->toArray();
    
        $slots = [];
    
        while ($start->lt($end)) {
            $next = $start->copy()->addMinutes($slotDuration);
            if ($next->gt($end)) break;
    
            // ⛔ اليوم: تجاهل الأوقات الماضية
            if ($dateObj->isToday() && $start->lte(now())) {
                $start->addMinutes($slotDuration);
                continue;
            }
    
            $time = $start->format('H:i');
    
            if (!in_array($time, $bookedTimes)) {
                $slots[] = $time;
            }
    
            $start->addMinutes($slotDuration);
        }
    
        return $slots;
    }
    
}
