<?php

namespace App\Http\Controllers;

use App\Models\AboutFeature;
use App\Models\AboutPoint;
use App\Models\AboutSection;
use App\Models\Consultant;
use App\Models\HomeHero;
use App\Models\HomeService;
use App\Models\HomeStat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $hero = HomeHero::first();
        $stastic = HomeStat::orderBy('order')->get();
        $about = AboutSection::first();
        $about_points = AboutPoint::orderBy('order')->get();
        $about_fet = AboutFeature::where('is_active', 1)->orderBy('order')->get();
        $services = HomeService::where('is_active', 1)->orderBy('order')->limit(3)->get();
        $doctors = Consultant::where('is_active', 1)->orderBy('order')->limit(6)->get();
            return view('frontend.index', compact('hero','stastic','about',
        'about_points','about_fet','services','doctors'));
    }
    public function services()
    {
        $services = HomeService::where('is_active', 1)
            ->orderBy('order')
            ->get();

        return view('frontend.services', compact('services'));
    }
    public function booking()
    {
        $consultants = Consultant::where('is_active', 1)
            ->orderBy('order')
            ->get();

        return view('frontend.booking', compact('consultants'));
    }
}
