<?php

namespace App\Http\Controllers;

use App\Models\AboutPoint;
use Illuminate\Http\Request;

class AboutPointController extends Controller
{
    public function edit()
    {
        $points = AboutPoint::orderBy('order')->get();

        return view('dashboard.about.points', compact('points'));
    }

    public function update(Request $request)
    {
        AboutPoint::query()->delete();

        foreach ($request->points ?? [] as $index => $row) {
            AboutPoint::create([
                'title'       => $row['title'] ?? null,
                'description' => $row['description'] ?? null,
                'order'       => $index + 1,
            ]);
        }

        return back()->with('success', 'تم حفظ النقاط بنجاح');
    }
}