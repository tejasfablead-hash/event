<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MultiBookingcontroller extends Controller
{
    public function index()
    {
        $customer = User::all();
        $event = Event::all();
        return view('book.insert', compact(['customer', 'event']));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer.*'  => 'required',
            'event.*'     => 'required',
            'eventdate.*' => 'required',
            'qty.*'       => 'required|numeric|min:1',
        ], [
            'customer.*.required'  => 'Customer is required',
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

        foreach ($request->customer as $key => $value) {

            $startdate = null;
            $enddate = null;

            if (!empty($request->eventdate[$key])) {
                $dates = explode(',', $request->eventdate[$key]);
                $startdate = $dates[0] ?? null;
                $enddate = $dates[1] ?? $startdate;
            }

            Booking::create([
                'customer'   => $request->customer[$key],
                'event'      => $request->event[$key],
                'start_date' => $startdate,
                'end_date'   => $enddate,
                'qty'        => $request->qty[$key],
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Event Booking Successfully',
        ]);
    }
}
