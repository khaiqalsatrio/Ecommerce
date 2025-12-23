<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $payment = Payment::create([
            'order_id' => $request->order_id,
            'payment_method' => $request->payment_method,
            'status' => 'waiting'
        ]);

        return response()->json($payment);
    }
}
