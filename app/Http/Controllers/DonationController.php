<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Donation;
use App\Models\Visitor;

   class DonationController extends Controller
{
    public function index()
    {
        return view('donate');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'amount' => 'required|numeric|min:10',
            'payment_type' => 'required'
        ]);

        $donation = Donation::create([
            'name' => $request->name,
            'email' => $request->email,
            'amount' => $request->amount,
            'status' => 'pending'
        ]);

        $response = Http::withHeaders([
    'x-api-key' => env('NOWPAYMENTS_API_KEY')
])->post('https://api.nowpayments.io/v1/invoice', [
    'price_amount' => $request->amount,
    'price_currency' => 'usd',
    'order_id' => $donation->id,
    'order_description' => 'Donation',
    'ipn_callback_url' => url('/donation/webhook'),
    'success_url' => url('/thank-you'),
    'cancel_url' => url('/donate'),
]);
        

        $data = $response->json();

        $donation->update([
            'payment_id' => $data['payment_id'] ?? null,
            'payment_url' => $data['invoice_url'] ?? null,
        ]);
        // dd($data);

        return redirect($data['invoice_url']);
    }

    public function webhook(Request $request)
    {
        $paymentId = $request->payment_id;

        $donation = Donation::where('payment_id', $paymentId)->first();

        if (!$donation) {
            return response()->json(['error' => 'Not found'], 404);
        }

}
public function visitors()
{
    $visitors = Visitor::latest()->paginate(50);

    return view('visitors', compact('visitors'));
}
}