<?php

namespace App\Http\Controllers;

use App\Models\AboutFeature;
use Illuminate\Http\Request;

class AboutFeatureController extends Controller
{
    public function edit()
    {
        $features = AboutFeature::orderBy('order')->get();

        return view('dashboard.about.features', compact('features'));
    }

    public function update(Request $request)
    {
        AboutFeature::query()->delete();

        foreach ($request->features ?? [] as $index => $row) {
            AboutFeature::create([
                'icon'        => $row['icon'] ?? null,
                'title'       => $row['title'] ?? null,
                'description' => $row['description'] ?? null,
                'order'       => $index + 1,
                'is_active'   => 1,
            ]);
        }

        return back()->with('success', 'تم حفظ الخدمات بنجاح');
    }
}