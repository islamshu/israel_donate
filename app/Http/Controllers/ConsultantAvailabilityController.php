<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use App\Models\ConsultantAvailability;
use Illuminate\Http\Request;

class ConsultantAvailabilityController extends Controller
{
    public function edit(Consultant $consultant)
    {
        $days = [
            0 => 'الأحد',
            1 => 'الاثنين',
            2 => 'الثلاثاء',
            3 => 'الأربعاء',
            4 => 'الخميس',
            5 => 'الجمعة',
            6 => 'السبت',
        ];

        $availabilities = $consultant->availabilities
            ->keyBy('day_of_week');

        return view(
            'dashboard.consultants.availability',
            compact('consultant', 'days', 'availabilities')
        );
    }

    public function update(Request $request, Consultant $consultant)
    {
        // نحذف القديم
        ConsultantAvailability::where('consultant_id', $consultant->id)->delete();

        foreach ($request->days ?? [] as $day => $row) {

            if (!isset($row['enabled'])) {
                continue;
            }

            ConsultantAvailability::create([
                'consultant_id' => $consultant->id,
                'day_of_week'   => $day,
                'start_time'    => $row['start_time'],
                'end_time'      => $row['end_time'],
                'slot_duration' => $row['slot_duration'] ?? 60,
            ]);
        }

        return back()->with('success', 'تم حفظ أوقات العمل بنجاح');
    }
}
