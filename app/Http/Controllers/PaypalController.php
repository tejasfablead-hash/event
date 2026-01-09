<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function success(Request $request)
    {
        try {
            $payment = Payment::create([
                'user_id'       => $request->customer_id,
                'payment_id'    => $request->orderID,
                'amount'        => $request->grand_total,
                'currency'      => 'USD',
                'status'        => 'completed',
            ]);

            $events     = $request->input('event');       // array of event IDs
            $startDates = $request->input('eventdate');  // array of start dates
            $qtys       = $request->input('qty');        // array of quantities
            $totals     = $request->input('total');      // array of totals

            $booking = Booking::create([
                'customer'    => $request->customer_id,
                'event'       => $events,
                'start_date'  => $startDates,
                'end_date'    => $startDates, // if single date
                'qty'         => $qtys,
                'total'       => $totals,
                'grand_total' => $request->grand_total,
                'status'      => 'pending',
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Payment and Booking stored successfully',
                'payment' => $payment,
                'booking' => $booking,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    public function cancel()
    {
        return response()->json([
            'status'  => false,
            'message' => 'Payment Cancelled!',
        ]);
    }
}
