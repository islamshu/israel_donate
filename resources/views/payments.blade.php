{{-- resources/views/admin/payments.blade.php --}}

@extends('layouts.app')

@section('title', 'Payments')

@section('content')
<div class="min-h-screen bg-slate-100 py-10">
    <div class="max-w-7xl mx-auto px-6">

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="p-8 border-b border-slate-200">
                <h1 class="text-3xl font-bold text-slate-800">Payments</h1>
                <p class="text-slate-500 mt-2">All donation payments</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-100 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Payment ID</th>
                            <th class="px-6 py-4">Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($payments as $payment)
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="px-6 py-4">{{ $payment->id }}</td>

                                <td class="px-6 py-4 font-bold text-slate-800">
                                    ${{ number_format($payment->amount, 2) }}
                                </td>

                                <td class="px-6 py-4">
                                    @if($payment->status === 'paid')
                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-bold">
                                            Paid
                                        </span>
                                    @elseif($payment->status === 'waiting' || $payment->status === 'pending')
                                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-bold">
                                            Pending
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-bold">
                                            Failed
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 font-mono text-xs break-all">
                                    {{ $payment->payment_id }}
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    {{ $payment->created_at->format('Y-m-d H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                    No payments found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-100">
                {{ $payments->links() }}
            </div>
        </div>

    </div>
</div>
@endsection