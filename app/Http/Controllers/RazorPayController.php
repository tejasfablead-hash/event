<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class RazorpayController extends Controller
{
    public function createOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );
        $order = $api->order->create([
            'receipt'         => 'order_' . time(),
            'amount'          => $request->amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1
        ]);
        return response()->json([
            'order_id' => $order->id,
            'currency' => 'currency',
            'key'      => config('services.razorpay.key'),
            'amount'   => $order->amount,
            'currency'  => $order->currency,
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required',
            'razorpay_payment_id'  => 'required',
            'amount'     => 'required|numeric',
            'currency'        => 'required',
            'customer'        => 'required',
            'method' => 'required',
            'event.*'       => 'required',
            'eventdate.*'   => 'required',
            'qty.*'         => 'required|numeric|min:1',
        ], [
            'event.*.required'     => 'Event is required',
            'eventdate.*.required' => 'Event date is required',
            'qty.*.required'       => 'Quantity is required',
        ]);

        $payment = Payment::create([
            'user_id'         => $request->customer,
            'payment_id'      => $request->razorpay_payment_id,
            'amount'          => $request->amount,
            'currency'        => $request->currency,
            'method'          => $request->method,
            'status'          => 'COMPLETED',
        ]);

        $startDate = [];
        $endDate   = [];

        foreach ($request->eventdate as $dateRange) {
            $dates = explode(',', $dateRange);
            $startDate[] = trim($dates[0]);
            $endDate[]   = trim($dates[1] ?? $dates[0]);
        }

        Booking::create([
            'customer'    => $request->customer,
            'event'       => $request->event,
            'start_date'  => $startDate,
            'end_date'    => $endDate,
            'qty'         => $request->qty,
            'total'       => $request->price,
            'status'      => 'pending',
            'grand_total' => $request->grandtotal[0],
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Payment & Booking stored successfully'
        ]);
    }
}
