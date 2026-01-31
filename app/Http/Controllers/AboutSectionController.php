<?php

namespace App\Http\Controllers;

use App\Models\AboutFeature;
use App\Models\AboutPoint;
use App\Models\AboutSection;
use Illuminate\Http\Request;

class AboutSectionController extends Controller
{
    public function edit()
    {
        $about = AboutSection::first();
        $features = AboutFeature::orderBy('order')->get();
        $points = AboutPoint::orderBy('order')->get();

        return view('dashboard.about.edit', compact(
            'about',
            'features',
            'points'
        ));
    }

    public function update(Request $request)
    {
        // ================= ABOUT =================
        $about = AboutSection::first() ?? new AboutSection();
        $about->title = $request->title;
        $about->description = $request->description;
        $about->save();

        // ================= FEATURES =================
        AboutFeature::query()->delete();
        foreach ($request->features ?? [] as $i => $row) {
            AboutFeature::create([
                'icon'  => $row['icon'] ?? null,
                'title' => $row['title'] ?? null,
                'description' => $row['description'] ?? null,
                'order' => $i + 1,
                'is_active' => 1
            ]);
        }

        // ================= POINTS =================
        AboutPoint::query()->delete();
        foreach ($request->points ?? [] as $i => $row) {
            AboutPoint::create([
                'icon'  => $row['icon'] ?? null,
                'title' => $row['title'] ?? null,
                'description' => $row['description'] ?? null,
                'order' => $i + 1
            ]);
        }

        return back()->with('success', 'تم حفظ قسم عن المركز بالكامل');
    }
}
