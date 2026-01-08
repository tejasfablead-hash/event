<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MultiBookingcontroller extends Controller
{
    public function view()
    {
        if (Auth::check()) {
            $book = Booking::latest()->get();
            $event = Event::pluck('title', 'id');
            return view('book.view', compact('book', 'event'));
        } else {
            return view('pages.login');
        }
    }

    public function index()
    {
        if (Auth::check()) {
            $customer = User::all();
            $event = Event::all();
            return view('book.insert', compact(['customer', 'event']));
        } else {
            return view('pages.login');
        }
    }
 
    public function edit($id)
    {
        if (Auth::check()) {
            $event = Event::all();
            $single = Booking::where('id', $id)->first();
            return view('book.update', compact(['event', 'single']));
        } else {
            return view('pages.login');
        }
    }
    public function update(Request $request)
    {
        if (Auth::check()) {

            $data = Booking::where('id', $request->id)->first();
            $validator = Validator::make($request->all(), [
                'customer'      => 'required',
                'event.*'       => 'required',
                'eventdate.*'   => 'required',
                'qty.*'         => 'required|numeric|min:1',
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
            $startDate = [];
            $endDate   = [];

            foreach ($request->eventdate as $dateRange) {
                $dates = explode(',', $dateRange);
                $startDate[] = trim($dates[0]);
                $endDate[]   = trim($dates[1] ?? $dates[0]);
            }


            $result = $data->update([
                'event'       => $request->event,
                'start_date'  => $startDate,
                'end_date'    => $endDate,
                'qty'         => $request->qty,
                'status'      => 'pending',
                'total'       => $request->price,
                'grand_total' => $request->grandtotal[0],
            ]);
            if ($result) {
                return response()->json([
                    'status' => true,
                    'message' => ' Booking  Updated Successfully',
                    'data' => $result
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => ' Booking Not Update.'
                ]);
            }
        } else {
            return view('pages.login');
        }
    }
    public function delete($id)
    {
        if (Auth::check()) {
            $data = Booking::where('id', $id)->first();
            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Record Not Available'
                ]);
            }
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'Record Deleted Successfully'
            ]);
        } else {
            return view('pages.login');
        }
    }
    public function bookdetail($id)
    {
        if (Auth::check()) {
            $data = Booking::where('id', $id)->first();
            $event = Event::pluck('title', 'id');
            return view('book.bookingdetails', compact('data', 'event'));
        } else {
            return view('pages.login');
        }
    }
}
