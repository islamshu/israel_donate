<?php

namespace App\Http\Controllers;

use App\Models\HomeHero;
use Illuminate\Http\Request;

class HomeHeroController extends Controller
{
    public function edit()
    {
        $hero = HomeHero::first();
        return view('dashboard.hero.edit', compact('hero'));
    }

    public function update(Request $request)
    {

        $data = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'description' => 'nullable',
            'button_text' => 'nullable',
            'button_link' => 'nullable',
            'background_image' => 'nullable',
        ]);

        if ($request->has('background_image')) {
            $data['background_image'] = $request->background_image;
               
        }
        $hero = HomeHero::firstOrCreate($data);

        return back()->with('success','تم التحديث بنجاح');
    }
}
