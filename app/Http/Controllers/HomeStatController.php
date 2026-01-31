<?php

namespace App\Http\Controllers;

use App\Models\HomeStat;
use Illuminate\Http\Request;

class HomeStatController extends Controller
{
    public function edit()
    {
        $stats = HomeStat::orderBy('order')->get();

        return view('dashboard.home-stats.edit', compact('stats'));
    }

    public function update(Request $request)
    {
        HomeStat::query()->delete();

        foreach ($request->stats ?? [] as $index => $row) {
            HomeStat::create([
                'value'     => $row['value'] ?? '',
                'label'     => $row['label'] ?? '',
                'order'     => $index + 1,
            ]);
        }

        return back()->with('success', 'تم حفظ الإحصائيات بنجاح');
    }
}
