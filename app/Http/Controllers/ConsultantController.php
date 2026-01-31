<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use Illuminate\Http\Request;


class ConsultantController extends Controller
{
    public function index()
    {
        $consultants = Consultant::orderBy('order')->get();
        return view('dashboard.consultants.index', compact('consultants'));
    }

    public function create()
    {
        $consultant = new Consultant();
        return view('dashboard.consultants.form', compact('consultant'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $data['order'] = Consultant::max('order') + 1;
        // $data['is_active'] = $request->has('is_active');

        Consultant::create($data);

        return redirect()
            ->route('dashboard.consultants.index')
            ->with('success', 'تم إضافة المستشار بنجاح');
    }

    public function edit(Consultant $consultant)
    {
        return view('dashboard.consultants.form', compact('consultant'));
    }

    public function update(Request $request, Consultant $consultant)
    {
        $data = $this->validateData($request);
        // $data['is_active'] = $request->has('is_active');

        $consultant->update($data);

        return redirect()
            ->route('dashboard.consultants.index')
            ->with('success', 'تم تحديث المستشار بنجاح');
    }

    public function destroy(Consultant $consultant)
    {
        $consultant->delete();
        return back()->with('success', 'تم حذف المستشار');
    }

    public function toggle(Consultant $consultant)
    {
        $consultant->update([
            'is_active' => ! $consultant->is_active
        ]);

        return response()->json(['success' => true]);
    }

    protected function validateData(Request $request)
    {
        return $request->validate([
            'name'             => 'required|string|max:255',
            'title'            => 'nullable|string|max:255',
            'image'            => 'nullable|string',
            'rating'           => 'required|integer|min:1|max:5',
            'years_experience' => 'required|integer|min:0',
            'description'      => 'nullable|string',
            'price'            => 'nullable|integer',
        ]);
    }
}