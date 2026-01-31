<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use App\Services\ConsultantScheduleService;
use Illuminate\Http\Request;

class ConsultantScheduleController extends Controller
{
    public function availableSlots(
        Request $request,
        Consultant $consultant,
        ConsultantScheduleService $service
    ) {
        $request->validate([
            'date' => 'required|date',
        ]);

        $slots = $service->getAvailableSlots(
            $consultant,
            $request->date
        );

        return response()->json([
            'date'  => $request->date,
            'slots' => $slots
        ]);
    }
}
