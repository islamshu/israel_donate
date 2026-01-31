<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\GeneralValue;
use App\Models\HomeService;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sector;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Booking;
use App\Models\Consultant;
use App\Models\ContactMessage;

class DashbaordController extends Controller
{


    public function dashboard()
    {
        // ===== Booking Stats (استعلام واحد) =====
        $counts = Booking::selectRaw("
            COUNT(*) as total,
            SUM(status = 'pending')  as pending,
            SUM(status = 'paid')     as paid,
            SUM(status = 'canceled') as canceled,
            SUM(status = 'failed')   as failed,
            SUM(status = 'expired')  as expired
        ")->first();

        // ===== Revenue =====
        $totalRevenue = Booking::where('status', 'paid')
            ->sum('amount_baisa');

        // ===== Stats Array =====
        $stats = [
            'total'       => $counts->total,
            'pending'     => $counts->pending,
            'paid'        => $counts->paid,
            'canceled'    => $counts->canceled,
            'failed'      => $counts->failed,
            'expired'     => $counts->expired,
            'consultants' => Consultant::count(),
            'revenue'     => $totalRevenue / 1000,
        ];

        // ===== Latest Bookings =====
        $latestBookings = Booking::with('consultant')
            ->latest()
            ->take(6)
            ->get();
        return view('dashboard.index', compact('stats', 'latestBookings','unreadContactCount'));
    }
    public function setting()
    {
        return view('dashboard.setting');
    }
    public function additinal_setting()
    {
        return view('dashboard.addititnal_setting');
    }
    public function add_general(Request $request)
    {
        if ($request->hasFile('general_file')) {
            foreach ($request->file('general_file') as $name => $value) {
                if ($value == null) {
                    continue;
                }
                // Save the uploaded file to the 'general' directory in storage and store the path in the database
                $path = $value->store('general', 'public');
                GeneralValue::setValue($name, $path);
            }
        }
        if ($request->has('general')) {

            foreach ($request->input('general') as $name => $value) {
                // if ($value == null) {
                //     continue;
                // }
                GeneralValue::setValue($name, $value);
            }
        }

        return redirect()->back()->with(['success' => 'تم التعديل بنجاح']);
    }
    public function edit_profile()
    {
        return view('dashboard.edit_profile');
    }
    public function edit_profile_post(Request $request)
    {
        $id = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        if ($request->password != null) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);
        }
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => 'false'], 422);
        }
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }

        if ($request->image != null) {
            $user->image = $request->image->store('/users');
        }
        $user->save();
        return response()->json(['success' => 'true'], 200);
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
    public function login()
    {
        if (auth()->check() == true) {
            return redirect()->route('dashboard');
        } else {
            return view('auth.login');
        }
    }
    public function post_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        get_pass_check($request->password);
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with(['error' => trans('البريد اللاكتروني او كلمة المرور غير صحيحة')]);
    }
}
