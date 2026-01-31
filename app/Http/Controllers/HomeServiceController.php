<?php

namespace App\Http\Controllers;

use App\Models\HomeService;
use Illuminate\Http\Request;

class HomeServiceController extends Controller
{
    public function index()
    {
        $services = HomeService::orderBy('order')->get();
        return view('dashboard.home-services.index', compact('services'));
    }

    public function create()
    {
        $service = new HomeService();
        return view('dashboard.home-services.form', compact('service'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);


        $data['order'] = HomeService::max('order') + 1;

        HomeService::create($data);

        return redirect()
            ->route('dashboard.home-services.index')
            ->with('success', 'تم إضافة الخدمة بنجاح');
    }
    public function toggle(HomeService $service)
    {
        $service->update([
            'is_active' => ! $service->is_active
        ]);

        return response()->json(['success' => true]);
    }


    public function edit(HomeService $homeService)
    {
        $service = $homeService;
        return view('dashboard.home-services.form', compact('service'));
    }

    public function update(Request $request, HomeService $homeService)
    {
        $data = $this->validateData($request);



        $homeService->update($data);

        return redirect()
            ->route('dashboard.home-services.index')
            ->with('success', 'تم تحديث الخدمة بنجاح');
    }

    public function destroy(HomeService $homeService)
    {


        $homeService->delete();

        return back()->with('success', 'تم حذف الخدمة');
    }

    protected function validateData(Request $request)
    {
        return $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'nullable|integer',
            'icon'        => 'nullable|string',
            'image'       => 'nullable',
        ]);
    }
}
