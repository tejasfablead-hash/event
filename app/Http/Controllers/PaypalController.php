<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'orderID' => 'required',
            'transaction_id'  => 'required',
            'grand_total'     => 'required|numeric',
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
                'payment_id'      => $request->transaction_id,
                'amount'          => $request->grand_total,
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

    public function cancel()
    {
        return redirect('/')->with('error', 'Payment cancelled');
    }
}
