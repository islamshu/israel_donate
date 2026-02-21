<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultantController extends Controller
{
    public function index()
{
    if (auth()->user()->hasRole('consultant')) {

        $consultants = Consultant::where('user_id', auth()->id())
            ->orderBy('order')
            ->get();

    } else {
        $consultants = Consultant::orderBy('order')->get();
    }

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

        DB::transaction(function () use ($data) {

            // إنشاء يوزر
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $user->assignRole(roles: 'consultant');

            // ترتيب تلقائي
            $order = Consultant::max('order') + 1;

            // إنشاء المستشار
            Consultant::create([
                'name' => $data['name'],
                'title' => $data['title'],
                'rating' => $data['rating'],
                'years_experience' => $data['years_experience'],
                'description' => $data['description'],
                'price' => $data['price'],
                'image' => $data['image'],
                'order' => $order,
                'user_id' => $user->id,
            ]);
        });

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
        $data = $this->validateData($request, $consultant);
        DB::transaction(function () use ($data, $consultant) {

            // تحديث بيانات اليوزر
            $consultant->user->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);
                      $consultant->user->assignRole('consultant');


            if (!empty($data['password'])) {
                $consultant->user->update([
                    'password' => bcrypt($data['password'])
                ]);
            }

            // تحديث المستشار
            $consultant->update([
                'name' => $data['name'],
                'title' => $data['title'],
                'rating' => $data['rating'],
                'years_experience' => $data['years_experience'],
                'description' => $data['description'],
                'price' => $data['price'],
                'image' => $data['image'],
            ]);
        });

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

    protected function validateData(Request $request, $consultant = null)
    {
        $userId = $consultant?->user?->id;

        return $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'years_experience' => 'required|integer',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',

            'email' => 'required',
            'password' => $request->isMethod('post')
                ? 'required|min:6'
                : 'nullable|min:6',
        ]);
    }
}
