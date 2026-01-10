<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Charge;
use Stripe\Stripe;

class StripeController extends Controller
{
    

    public function processPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer'      => 'required',
            'event.*'       => 'required',
            'eventdate.*'   => 'required',
            'qty.*'         => 'required|numeric|min:1',
            'method' => 'required',
            'stripeToken' => 'required',
        ], [
            'event.*.required'     => 'Event is required',
            'eventdate.*.required' => 'Event date is required',
            'qty.*.required'       => 'Quantity is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            Stripe::setApiKey(config('services.stripe.secret'));

            $amount = (int) round($request->amount);

            $charge = Charge::create([
                'amount'      => $amount * 100,
                'currency'    => 'inr',
                'source'      => $request->stripeToken,
                'description' => 'Event Booking Payment',
            ]);

            if ($charge->status !== 'succeeded') {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment Failed'
                ], 400);
            }
            $payment = Payment::create([
                'user_id'    => $request->customer,
                'payment_id' => $charge->id,
                'amount'     => $amount,
                'currency'   => 'inr',
                'method'     => $request->method,
                'status'     => $charge->status,
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
                'status'  => true,
                'message' => 'Payment & Booking Successfully',
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function view()
    {
        $payment = Payment::all();
        return view('payment.view', compact('payment'));
    }
}
